<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update role name dari 'employee' ke 'karyawan' di table roles
        DB::table('roles')
            ->where('name', 'employee')
            ->update(['name' => 'karyawan']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Rollback: Update kembali dari 'karyawan' ke 'employee'
        DB::table('roles')
            ->where('name', 'karyawan')
            ->update(['name' => 'employee']);
    }
};
