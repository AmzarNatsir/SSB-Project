<?php

namespace App\Socialite;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;
use Laravel\Socialite\Two\User;

/**
 * Custom Socialite driver untuk SSO dengan Identity Provider SSB (HRD).
 *
 * IdP menggunakan Laravel Passport dengan endpoint:
 *   - /oauth/authorize  → halaman login + consent
 *   - /oauth/token      → tukar authorization code → access token
 *   - /api/oauth/userinfo → data identitas user (guard 'oauth')
 */
class SsbIdpProvider extends AbstractProvider implements ProviderInterface
{
    /** Scope Passport (default '*' = semua scope) */
    protected $scopes = ['*'];

    /** Separator scope Passport menggunakan spasi */
    protected $scopeSeparator = ' ';

    /**
     * Base URL IdP, dibaca dari config('services.ssb-idp.base_url').
     */
    protected function baseUrl(): string
    {
        return rtrim(config('services.ssb-idp.base_url', ''), '/');
    }

    /**
     * Tahap 1 — URL halaman authorize di IdP.
     * Browser user akan diarahkan ke sini.
     */
    protected function getAuthUrl($state): string
    {
        return $this->buildAuthUrlFromBase($this->baseUrl() . '/oauth/authorize', $state);
    }

    /**
     * Tahap 2 — URL endpoint token IdP.
     * Client menukar authorization code dengan access token di sini.
     */
    protected function getTokenUrl(): string
    {
        return $this->baseUrl() . '/oauth/token';
    }

    /**
     * Override HTTP client untuk menonaktifkan verifikasi SSL di lingkungan lokal.
     * Di production, hapus 'verify' => false.
     */
    protected function getHttpClient(): Client
    {
        if (is_null($this->httpClient)) {
            $this->httpClient = new Client([
                'verify' => app()->environment('production'),
            ]);
        }

        return $this->httpClient;
    }

    /**
     * Override agar request token dikirim sebagai form-params (sesuai Passport).
     */
    public function getAccessTokenResponse($code): array
    {
        $response = $this->getHttpClient()->post($this->getTokenUrl(), [
            RequestOptions::HEADERS => $this->getTokenHeaders($code),
            RequestOptions::FORM_PARAMS => $this->getTokenFields($code),
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Tahap 3 — Ambil data user dari IdP menggunakan access token.
     * Endpoint: GET /api/oauth/userinfo (guard 'oauth' di IdP).
     *
     * Response IdP:
     * {
     *   "sub":       "12345",    // NIK sebagai universal identifier
     *   "nik":       "12345",
     *   "name":      "Nama Lengkap",
     *   "email":     "email@example.com",
     *   "is_active": true
     * }
     */
    protected function getUserByToken($token): array
    {
        $response = $this->getHttpClient()->get($this->baseUrl() . '/api/oauth/userinfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer ' . $token,
                'Accept'        => 'application/json',
            ],
        ]);

        return json_decode((string) $response->getBody(), true);
    }

    /**
     * Petakan response IdP ke objek Socialite User.
     * Field 'id' diset ke NIK agar AbstractProvider bisa resolve user.
     */
    protected function mapUserToObject(array $user): User
    {
        return (new User)->setRaw($user)->map([
            'id'        => Arr::get($user, 'nik'),      // NIK sebagai identifier utama
            'nik'       => Arr::get($user, 'nik'),
            'name'      => Arr::get($user, 'name'),
            'email'     => Arr::get($user, 'email'),
            'is_active' => Arr::get($user, 'is_active', true),
        ]);
    }
}
