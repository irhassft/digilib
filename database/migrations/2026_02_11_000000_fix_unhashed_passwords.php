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
        // Migration intentionally left blank to avoid hashing existing passwords.
        // Passwords will be stored as provided by application logic.
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
