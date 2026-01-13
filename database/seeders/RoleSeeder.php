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
        Permission::firstOrCreate(['name' => 'view_documents']);
        Permission::firstOrCreate(['name' => 'download_documents']);
        Permission::firstOrCreate(['name' => 'upload_documents']);
        Permission::firstOrCreate(['name' => 'edit_documents']);
        Permission::firstOrCreate(['name' => 'delete_documents']);
        // Izin Kategori
        Permission::firstOrCreate(['name' => 'manage_categories']);
        // Izin User
        Permission::firstOrCreate(['name' => 'manage_users']);

        // 3. Buat Roles & Assign Permissions

        // A. Role KARYAWAN (Hanya bisa lihat dan download)
        $roleEmployee = Role::firstOrCreate(['name' => 'employee']);
        $roleEmployee->syncPermissions(['view_documents', 'download_documents']);

        // B. Role ADMIN (Bisa kelola dokumen & kategori)
        $roleAdmin = Role::firstOrCreate(['name' => 'admin']);
        $roleAdmin->syncPermissions([
            'view_documents', 
            'download_documents',
            'upload_documents', 
            'edit_documents', 
            'delete_documents',
            'manage_categories'
        ]);

        // C. Role SUPER ADMIN (Dewa - Punya semua akses)
        $roleSuperAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        // Super admin biasanya di-bypass di AuthServiceProvider, 
        // tapi untuk eksplisit kita beri semua permission:
        $roleSuperAdmin->syncPermissions(Permission::all());

        // 4. Buat Akun Super Admin Pertama
        $user = User::firstOrCreate(
            ['email' => 'acidprjct@gmail.com'],
            [
                'name' => 'Super Administrator',
                'password' => Hash::make('password123'),
                'email_verified_at' => now(),
            ]
        );

        // 5. Berikan Role Super Admin ke User tadi
        $user->assignRole($roleSuperAdmin);
        
        // Opsional: Buat akun Admin Biasa & Karyawan untuk testing nanti
        $admin = User::firstOrCreate(
            ['email' => 'admin@digilib.com'],
            [
                'name' => 'Admin Divisi',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($roleAdmin);

        $karyawan = User::firstOrCreate(
            ['email' => 'budi@digilib.com'],
            [
                'name' => 'Budi Karyawan',
                'password' => Hash::make('password123'),
            ]
        );
        $karyawan->assignRole($roleEmployee);
    }
}