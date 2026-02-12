<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ambil semua users
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // Cek apakah password sudah ter-hash (dimulai dengan $2y$, $2a$, atau $2b$)
            if (!preg_match('/^\$2[aby]\$/', $user->password)) {
                // Password belum ter-hash, hash sekarang
                DB::table('users')
                    ->where('id', $user->id)
                    ->update(['password' => Hash::make($user->password)]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak bisa di-reverse karena password sudah ter-hash
        // Jika di-reverse, akan kehilangan password yang sudah ter-hash
    }
};
