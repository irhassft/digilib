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
        Schema::create('documents', function (Blueprint $table) {
        $table->id();
        
        // Relasi: Siapa yang upload? (Jika user dihapus, dokumen ikut terhapus 'cascade')
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        // Relasi: Masuk kategori apa?
        $table->foreignId('category_id')->constrained()->onDelete('cascade');
        
        $table->string('title'); // Judul dokumen
        $table->string('slug')->unique(); // Untuk URL SEO friendly
        $table->text('description')->nullable(); // Deskripsi (opsional)
        
        // Informasi File Teknis
        $table->string('file_path')->default(''); // Lokasi file disimpan (misal: documents/file.pdf)
        $table->string('mime_type')->default('application/pdf'); // Tipe file
        $table->unsignedBigInteger('file_size')->default(0); // Ukuran file (dalam bytes)
        $table->unsignedInteger('download_count')->default(0); // Hitung berapa kali didownload
        
        // Visibility & year
        $table->enum('visibility', ['public', 'private'])->default('private');
        $table->string('cover_image')->nullable();
        $table->year('year')->nullable();
        
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
