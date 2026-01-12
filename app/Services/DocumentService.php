<?php

namespace App\Services;

use App\Models\Document;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DocumentService
{
    /**
     * Menangani proses upload dokumen secara menyeluruh.
     * * @param array $data Data text (judul, deskripsi, kategori_id)
     * @param UploadedFile $file File fisik yang diupload
     * @param int $userId ID pengguna yang melakukan upload
     */
    public function uploadDocument(array $data, UploadedFile $file, int $userId)
    {
        return DB::transaction(function () use ($data, $file, $userId) {
            
            // 1. Buat SLUG unik untuk URL (misal: sop-keuangan-x7z9)
            $slug = Str::slug($data['title']) . '-' . Str::random(4);

            // 2. Buat NAMA FILE unik agar tidak bentrok
            // Format: waktu_slug.pdf
            $filename = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();

            // 3. Tentukan Folder Penyimpanan
            // Kita simpan per tahun agar folder tidak terlalu penuh (Scalability)
            $folder = 'documents/' . date('Y');

            // 4. UPLOAD FILE (Logika Inti)
            // 'public' bisa diganti 's3' nanti lewat .env tanpa ubah kode ini
            $path = $file->storeAs($folder, $filename, 'public'); 

            // 5. Simpan Data ke Database
            return Document::create([
                'user_id'     => $userId,
                'category_id' => $data['category_id'],
                'title'       => $data['title'],
                'slug'        => $slug,
                'description' => $data['description'] ?? null,
                'file_path'   => $path, 
                'file_size'   => $file->getSize(), // Byte
                'mime_type'   => $file->getMimeType(),
                'download_count' => 0
            ]);
            // 1. Jika ada file baru diupload
            if ($file) {
                // Hapus file lama fisik
                if (Storage::disk('public')->exists($document->file_path)) {
                    Storage::disk('public')->delete($document->file_path);
                }

                // Upload file baru
                $filename = time() . '_' . Str::slug($data['title']) . '.' . $file->getClientOriginalExtension();
                $folder = 'documents/' . date('Y');
                $path = $file->storeAs($folder, $filename, 'public');
                
                // Update path & metadata file
                $document->file_path = $path;
                $document->file_size = $file->getSize();
                $document->mime_type = $file->getMimeType();
            }

            // 2. Update data teks (Judul, Deskripsi, Kategori)
            $document->update([
                'title'       => $data['title'],
                'slug'        => Str::slug($data['title']) . '-' . Str::random(5), // Update slug juga
                'category_id' => $data['category_id'],
                'description' => $data['description'] ?? $document->description,
            ]);

            return $document;
        });
    }
    /**
     * Hapus dokumen dari database & penyimpanan fisik
     */
    public function deleteDocument(Document $document)
    {
        // 1. Hapus file fisik dulu
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        // 2. Baru hapus data di database
        return $document->delete();
    }
}