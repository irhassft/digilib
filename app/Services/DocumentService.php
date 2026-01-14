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
    public function uploadDocument(array $data, UploadedFile $file, int $userId, ?UploadedFile $cover = null)
    {
        return DB::transaction(function () use ($data, $file, $userId, $cover) {
            // 1. Buat SLUG unik untuk URL (misal: sop-keuangan-x7z9)
            $slug = Str::slug($data['title']) . '-' . Str::random(4);

            // 2. Buat NAMA FILE unik agar tidak bentrok
            $filename = time() . '_' . $slug . '.' . $file->getClientOriginalExtension();

            // 3. Tentukan Folder Penyimpanan untuk dokumen
            $folder = 'documents/' . date('Y');

            // 4. UPLOAD FILE (Logika Inti) ke disk public
            $path = $file->storeAs($folder, $filename, 'public'); 

            // 5. Handle optional cover image (simpan ke disk public)
            $coverPath = null;
            if ($cover) {
                try {
                    $coverPath = Storage::disk('public')->putFile('cover-images', $cover);
                } catch (\Throwable $e) {
                    \Log::warning('Failed to store cover image in DocumentService: ' . $e->getMessage());
                    $coverPath = null;
                }
            }

            // 6. Simpan Data ke Database
            $document = Document::create([
                'user_id'     => $userId,
                'category_id' => $data['category_id'],
                'title'       => $data['title'],
                'slug'        => $slug,
                'description' => $data['description'] ?? null,
                'cover_image' => $coverPath,
                'file_path'   => $path, 
                'file_size'   => $file->getSize(), // Byte
                'mime_type'   => $file->getMimeType(),
                'download_count' => 0
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