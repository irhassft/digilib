<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Reset Cache Permission (Penting untuk Spatie)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Buat Permissions (Izin-izin spesifik)
        // Izin Dokumen
        Permission::create(['name' => 'view_documents']);
        Permission::create(['name' => 'download_documents']);
        Permission::create(['name' => 'upload_documents']);
        Permission::create(['name' => 'edit_documents']);
        Permission::create(['name' => 'delete_documents']);
        // Izin Kategori
        Permission::create(['name' => 'manage_categories']);
        // Izin User
        Permission::create(['name' => 'manage_users']);

        // 3. Buat Roles & Assign Permissions

        // A. Role KARYAWAN (Hanya bisa lihat dan download)
        $roleEmployee = Role::create(['name' => 'employee']);
        $roleEmployee->givePermissionTo(['view_documents', 'download_documents']);

        // B. Role ADMIN (Bisa kelola dokumen & kategori)
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleAdmin->givePermissionTo([
            'view_documents', 
            'download_documents',
            'upload_documents', 
            'edit_documents', 
            'delete_documents',
            'manage_categories'
        ]);

        // C. Role SUPER ADMIN (Dewa - Punya semua akses)
        $roleSuperAdmin = Role::create(['name' => 'super-admin']);
        // Super admin biasanya di-bypass di AuthServiceProvider, 
        // tapi untuk eksplisit kita beri semua permission:
        $roleSuperAdmin->givePermissionTo(Permission::all());

        // 4. Buat Akun Super Admin Pertama
        $user = User::create([
            'name' => 'Super Administrator',
            'email' => 'super@digilib.com', // Email untuk login
            'password' => Hash::make('password123'), // Password
            'email_verified_at' => now(),
        ]);

        // 5. Berikan Role Super Admin ke User tadi
        $user->assignRole($roleSuperAdmin);
        
        // Opsional: Buat akun Admin Biasa & Karyawan untuk testing nanti
        $admin = User::create([
            'name' => 'Admin Divisi',
            'email' => 'admin@digilib.com',
            'password' => Hash::make('password123'),
        ]);
        $admin->assignRole($roleAdmin);

        $karyawan = User::create([
            'name' => 'Budi Karyawan',
            'email' => 'budi@digilib.com',
            'password' => Hash::make('password123'),
        ]);
        $karyawan->assignRole($roleEmployee);
    }
}