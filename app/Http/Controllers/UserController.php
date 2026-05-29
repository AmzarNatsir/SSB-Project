<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\EmployeeApiService;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(protected EmployeeApiService $employees) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::with('roles')->latest()->get();
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('roles', function($user) {
                    return $user->roles->pluck('name')->map(function($role) {
                        return '<span class="badge bg-primary-transparent text-primary me-1">' . $role . '</span>';
                    })->implode('');
                })
                ->addColumn('action', function($row) {
                    $btn = '<div class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle btn btn-sm btn-danger d-inline-flex align-items-center" data-bs-toggle="dropdown">
                            <i class="ti ti-dots-vertical"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end p-3">
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 edit-user-btn"
                                    data-id="'.$row->id.'"
                                    data-employee-id="'.($row->employee_id ?? '').'"
                                    data-nik="'.e($row->nik ?? '').'"
                                    data-name="'.e($row->name).'"
                                    data-email="'.e($row->email).'"
                                    data-roles="'.$row->roles->pluck('name')->implode(',').'"
                                    data-bs-toggle="offcanvas" data-bs-target="#edit_user_offcanvas">
                                    <i class="ti ti-edit me-2"></i>Edit
                                </a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item rounded-1 text-danger delete-user-btn"
                                    data-id="'.$row->id.'">
                                    <i class="ti ti-trash me-2"></i>Delete
                                </a>
                            </li>
                        </ul>
                    </div>';
                    return $btn;
                })
                ->rawColumns(['roles', 'action'])
                ->make(true);
        }

        $roles = Role::all();
        return view('users.index', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'employee_id' => 'required|integer|min:1|unique:users,employee_id',
            'email_manual' => 'nullable|email|max:255',
            'password' => 'required|string|min:8',
            'roles' => 'nullable|array',
        ]);

        $profile = $this->employees->getProfile((int) $request->employee_id);
        if (! $profile) {
            return back()->withInput()->with('error', 'Karyawan tidak ditemukan di HRD.');
        }

        $email = $profile['email'] ?: $request->email_manual;
        if (! $email) {
            return back()->withInput()->with('error', 'Karyawan tidak memiliki email di HRD. Isi email manual.');
        }

        if (User::where('email', $email)->exists()) {
            return back()->withInput()->with('error', 'Email "'.$email.'" sudah terdaftar.');
        }

        $user = User::create([
            'employee_id' => (int) $request->employee_id,
            'nik' => $profile['employee_number'] ?? null,
            'name' => $profile['name'] ?? '-',
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->assignRole($request->roles);
        }

        return redirect()->route('manage-users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'employee_id' => ['required', 'integer', 'min:1', Rule::unique('users', 'employee_id')->ignore($user->id)],
            'email_manual' => 'nullable|email|max:255',
            'password' => 'nullable|string|min:8',
            'roles' => 'nullable|array',
        ]);

        $profile = $this->employees->getProfile((int) $request->employee_id);
        if (! $profile) {
            return back()->withInput()->with('error', 'Karyawan tidak ditemukan di HRD.');
        }

        $email = $profile['email'] ?: $request->email_manual;
        if (! $email) {
            return back()->withInput()->with('error', 'Karyawan tidak memiliki email di HRD. Isi email manual.');
        }

        if (User::where('email', $email)->where('id', '!=', $user->id)->exists()) {
            return back()->withInput()->with('error', 'Email "'.$email.'" sudah terdaftar di user lain.');
        }

        $user->update([
            'employee_id' => (int) $request->employee_id,
            'nik' => $profile['employee_number'] ?? null,
            'name' => $profile['name'] ?? '-',
            'email' => $email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->roles ?? []);

        return redirect()->route('manage-users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('manage-users.index')
                ->with('error', 'You cannot delete yourself.');
        }

        $user->delete();

        return redirect()->route('manage-users.index')
            ->with('success', 'User deleted successfully.');
    }
}
