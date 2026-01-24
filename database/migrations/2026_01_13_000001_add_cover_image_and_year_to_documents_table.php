<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            // Hanya tambah jika belum ada
            if (!Schema::hasColumn('documents', 'cover_image')) {
                $table->string('cover_image')->nullable()->after('description');
            }
            if (!Schema::hasColumn('documents', 'year')) {
                $table->unsignedSmallInteger('year')->nullable()->after('cover_image');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('documents', function (Blueprint $table) {
            $table->dropColumn(['cover_image', 'year']);
        });
    }
};
