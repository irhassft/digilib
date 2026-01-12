<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Tampilkan daftar user
    public function index()
    {
        // Ambil semua user kecuali diri sendiri (optional)
        $users = User::with('roles')->latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    // Tampilkan form tambah user
    public function create()
    {
        // Ambil semua role untuk dropdown
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    // Simpan user baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->role);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }

    // Hapus user
    public function destroy(User $user)
    {
        // Cegah hapus diri sendiri atau Super Admin utama (id 1)
        if ($user->id == auth()->user()->id || $user->id == 1) {
            return back()->with('error', 'Tidak bisa menghapus akun ini.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }

    // 1. TAMPILKAN FORM EDIT
    public function edit(User $user)
    {
        // Cegah edit Super Admin Utama (ID 1)
        if ($user->id == 1) {
            return back()->with('error', 'Akun Super Admin utama tidak bisa diedit.');
        }

        $roles = \Spatie\Permission\Models\Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    // 2. PROSES UPDATE DATA
    public function update(Request $request, User $user)
    {
        // Cegah edit Super Admin Utama
        if ($user->id == 1) {
            return back()->with('error', 'Restricted.');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // Email unique, tapi abaikan email milik user ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'exists:roles,name'],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        // Update data dasar
        $user->name = $request->name;
        $user->email = $request->email;

        // Update password HANYA JIKA diisi
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Update Role (Sync = Hapus role lama, pasang role baru)
        $user->syncRoles($request->role);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui!');
    }
        
}