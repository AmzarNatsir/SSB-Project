<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

/**
 * SSO Client Controller — mengelola alur OAuth2 Authorization Code dengan IdP (ssb-project HRD).
 *
 * Alur:
 *   1. redirect()  → arahkan browser user ke halaman login IdP (/oauth/authorize)
 *   2. callback()  → terima authorization code dari IdP, tukar ke access token,
 *                    ambil userinfo, buat/update user lokal, login
 *   3. logout()    → hapus session lokal + redirect ke IdP /sso/logout untuk Single Logout
 */
class SsoController extends Controller
{
    /**
     * Tampilkan halaman login dengan tombol SSO.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return view('login');
    }

    /**
     * Tahap 1 — Redirect user ke halaman login IdP.
     */
    public function redirect()
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard'));
        }

        return Socialite::driver('ssb-idp')->redirect();
    }

    /**
     * Tahap 2 & 3 — Callback dari IdP setelah user login.
     *
     * IdP mengirim ?code=XXX ke URI ini. Client:
     *   - Menukar code → access_token (POST /oauth/token)
     *   - Mengambil userinfo (GET /api/oauth/userinfo)
     *   - Membuat/update user lokal berdasarkan NIK
     *   - Login user lokal
     */
    public function callback()
    {
        try {
            // Ambil data user dari IdP (exchange code → token → userinfo)
            $ssoUser = Socialite::driver('ssb-idp')->user();

            $nik       = $ssoUser->nik;
            $name      = $ssoUser->name;
            $email     = $ssoUser->email;
            $isActive  = $ssoUser->is_active ?? true;

            // Tolak user yang tidak aktif (sudah resign)
            if (! $isActive) {
                return redirect()->route('login')
                    ->withErrors(['sso' => 'Akun Anda tidak aktif. Hubungi administrator.']);
            }

            // Cari user lokal berdasarkan NIK (identifier universal dari IdP).
            $user = User::where('nik', $nik)->first();

            // Jika user tidak terdaftar di project ini, tolak login.
            if (! $user) {
                return redirect()->route('login')
                    ->withErrors(['sso' => 'Akun Anda tidak terdaftar di aplikasi ini. Silakan hubungi Administrator.']);
            }

            // Sinkronisasi nama dan email dari IdP ke database lokal
            $user->update([
                'name'  => $name,
                'email' => $email ?? $user->email,
            ]);

            // Login user lokal (session-based, guard 'web')
            Auth::login($user, remember: true);

            return redirect()->intended(route('dashboard'));

        } catch (\Laravel\Socialite\Two\InvalidStateException $e) {
            Log::warning('SSO callback: invalid state (mungkin expired atau CSRF)', [
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('login')
                ->withErrors(['sso' => 'Sesi SSO tidak valid atau telah habis. Silakan coba lagi.']);

        } catch (\Exception $e) {
            Log::error('SSO callback error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('login')
                ->withErrors(['sso' => 'Gagal terhubung ke server SSO. Silakan coba beberapa saat lagi.']);
        }
    }

    /**
     * Logout — Single Logout (SLO).
     *
     * Alur:
     *   1. Hapus session lokal (guard 'web')
     *   2. Redirect browser ke endpoint /sso/logout di IdP,
     *      dengan parameter ?redirect=<URL login client> agar IdP
     *      dapat revoke token & redirect kembali ke sini setelah selesai.
     */
    public function logout(Request $request)
    {
        // Hapus session lokal terlebih dahulu
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect ke IdP untuk Single Logout + revoke access token
        $idpBaseUrl    = rtrim(config('services.ssb-idp.base_url', ''), '/');
        $clientLoginUrl = route('login');       // IdP akan redirect balik ke sini setelah logout

        return redirect($idpBaseUrl . '/sso/logout?' . http_build_query([
            'redirect' => $clientLoginUrl,
        ]));
    }
}
