<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        $users = User::with('roles')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    // Tampilkan form tambah user
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:user', 'regex:/^\S*$/'],
            'email' => ['nullable', 'string', 'lowercase', 'email', 'max:255'],
            'password' => ['required', 'confirmed', 'string'],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Hapus user
    public function destroy(User $user)
    {
        if ($user->id == auth()->user()->id || $user->id == 1) {
            return back()->with('error', 'Tidak bisa menghapus akun ini.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // 1. TAMPILKAN FORM EDIT
    public function edit(User $user)
    {
        if ($user->id == 1) {
            return back()->with('error', 'Akun Super Admin utama tidak bisa diedit.');
        }

        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // 2. PROSES UPDATE DATA
    public function update(Request $request, User $user)
    {
        if ($user->id == 1) {
            return back()->with('error', 'Restricted.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:user,username,'.$user->id, 'regex:/^\S*$/'],
            'email' => ['nullable', 'string', 'email', 'max:255'],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', 'confirmed', 'string'],
        ]);

        try {
            \DB::beginTransaction();

            // Update data dasar
            $user->username = $request->username;
            $user->name = $request->name;
            $user->email = $request->email;

            // Update password HANYA JIKA diisi
            if ($request->filled('password')) {
                $user->password = $request->password;
            }

            $user->save();

            // Update Role
            $user->syncRoles($request->role);

            \DB::commit();

            return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
        } catch (\Throwable $e) {
            \Log::error('Gagal memperbarui user: '.$e->getMessage(), ['user_id' => $user->id]);
            \DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat memperbarui data user. Silakan coba lagi.');
        }
    }
}