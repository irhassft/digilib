<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\User; // Tambahkan ini untuk statistik User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // 1. TAMPILKAN DASHBOARD & LIST DOKUMEN
    public function index(Request $request)
    {
        // Query Pencarian
        $query = Document::with('category', 'uploader');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhereHas('category', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%");
                  });
        }

        // Ambil Data (Pagination 10 per halaman)
        $documents = $query->latest()->paginate(10);

        // STATISTIK DASHBOARD
        $totalDocuments = Document::count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        
        // Latest Activity for Sidebar
        $latestUploads = Document::with('user')->latest()->take(5)->get();

        $stats = [
            'total_documents'  => $totalDocuments,
            'total_downloads'  => 0, 
            'total_categories' => $totalCategories,
            'total_users'      => $totalUsers,
        ];

        $categories = Category::withCount('documents')->get(); // Update to include count

        return view('dashboard', compact('documents', 'stats', 'categories', 'totalDocuments', 'latestUploads'));
    }

    // 2. HALAMAN FORM UPLOAD
    public function create()
    {
        $categories = Category::all();
        return view('documents.create', compact('categories'));
    }

    // 3. PROSES UPLOAD KE NEXTCLOUD
    public function store(Request $request)
    {
        // 1. Validasi (Max 5MB)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'document_file' => 'required|file|max:5400',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // 2. Mulai Try Block untuk menangkap SEMUA error (DB maupun Upload)
            try {
                // Simpan ke Database DULU (agar dapat ID)
                $document = Document::create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . time(),
                    'description' => $request->description,
                    'category_id' => $request->category_id,
                    'file_path' => '', // Placeholder sementara
                    'file_size' => 0,  // Placeholder sementara
                    'user_id' => auth()->id(),
                ]);

                // 3. TENTUKAN ALAMAT LENGKAP (Based on Category)
                // Format: [Prefix] / [Nama Kategori] / [Filename]
                $prefix = trim(env('NEXTCLOUD_FOLDER_PREFIX', 'documents'), '/');
                
                // Ambil Kategori manual untuk memastikan tidak null
                $category = Category::find($request->category_id);
                $categoryName = $category ? Str::slug($category->name) : 'general';
                
                $targetFolder = "{$prefix}/{$categoryName}";

                // 4. EKSEKUSI UPLOAD
                // Pastikan folder tujuan ada
                if (!Storage::disk('nextcloud')->exists($targetFolder)) {
                    Storage::disk('nextcloud')->makeDirectory($targetFolder);
                }

                // Method Upload: Pakai Stream (Read Only)
                $fullPath = $targetFolder . '/' . $filename;
                $stream = fopen($file->getRealPath(), 'r');
                
                $uploadSuccess = Storage::disk('nextcloud')->put($fullPath, $stream);
                
                if (is_resource($stream)) {
                    fclose($stream);
                }
                
                // Fallback: Jika stream gagal, coba payload biasa
                if (!$uploadSuccess) {
                    $uploadSuccess = Storage::disk('nextcloud')->put($fullPath, file_get_contents($file->getRealPath()));
                }

                if (!$uploadSuccess) {
                    $document->delete(); // Rollback DB
                    throw new \Exception("Server Nextcloud menolak file (Upload Error). Target: {$fullPath}");
                }
                
                $path = $fullPath;
                
                // 5. Update Record dengan Path yang benar
                $document->update([
                    'file_path' => $path,
                    'file_size' => $file->getSize()
                ]);

                // Sukses
                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Berhasil Upload!']);
                }
                return redirect()->route('dashboard')->with('success', 'Berhasil Upload!');

            } catch (\Exception $e) {
                // Jika error terjadi setelah dokumen dibuat tapi sebelum upload selesai, hapus dokumen
                if (isset($document) && $document->existing) { // Correction: 'exists' property or checking ID
                    $document->delete();
                }
                // Check if document exists using model instance check
                 if (isset($document) && $document->id) {
                    $document->delete();
                }

                $msg = 'Error System: ' . $e->getMessage();
                
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => $msg], 500);
                }
                return back()->with('error', $msg);
            }
        }
    }

    // 4. DOWNLOAD DOKUMEN
    public function download(Document $document)
    {
        // Cek apakah file ada di Nextcloud
        if (!Storage::disk('nextcloud')->exists($document->file_path)) {
            return back()->with('error', 'File fisik tidak ditemukan di server Nextcloud.');
        }

        // Proses download
        return Storage::disk('nextcloud')->download($document->file_path, $document->title . '.pdf');
    }

    // 5. PREVIEW (LIHAT) DOKUMEN
    public function view(Document $document)
    {
        if (!Storage::disk('nextcloud')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        // Ambil isi file dari Nextcloud
        $fileContent = Storage::disk('nextcloud')->get($document->file_path);
        
        // Tampilkan sebagai PDF di browser (Inline)
        return response($fileContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $document->slug . '.pdf"');
    }

    // 6. HALAMAN EDIT
    public function edit(Document $document)
    {
        $categories = Category::all();
        return view('documents.edit', compact('document', 'categories'));
    }

    // 7. PROSES UPDATE
    public function update(Request $request, Document $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required',
            'document_file' => 'nullable|file|mimes:pdf|max:102400',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id,
        ];
        
        // Update slug hanya jika judul berubah (opsional, tapi baik untuk SEO/URL)
        if ($request->title !== $document->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            
            // Dynamic Folder Logic (Based on Category)
            $prefix = trim(env('NEXTCLOUD_FOLDER_PREFIX', 'documents'), '/');
            
            // Ambil nama kategori yang DIPILIH (bukan yang lama)
            $newCategory = Category::find($request->category_id);
            $categoryName = $newCategory ? Str::slug($newCategory->name) : 'uncategorized';
            
            $targetFolder = "{$prefix}/{$categoryName}";

            try {
                // Hapus file lama di Nextcloud
                if (Storage::disk('nextcloud')->exists($document->file_path)) {
                    Storage::disk('nextcloud')->delete($document->file_path);
                }
                
                // Upload file baru
                // Pastikan folder tujuan ada
                if (!Storage::disk('nextcloud')->exists($targetFolder)) {
                    Storage::disk('nextcloud')->makeDirectory($targetFolder);
                }
                
                // Method Upload: Pakai Stream (Read Only)
                $fullPath = $targetFolder . '/' . $filename;
                $stream = fopen($file->getRealPath(), 'r');
                
                $uploadSuccess = Storage::disk('nextcloud')->put($fullPath, $stream);
                
                if (is_resource($stream)) {
                    fclose($stream);
                }

                if (!$uploadSuccess) {
                     $uploadSuccess = Storage::disk('nextcloud')->put($fullPath, file_get_contents($file->getRealPath()));
                }
                
                if (!$uploadSuccess) {
                    throw new \Exception("Server Nextcloud menolak file baru. Target: {$fullPath}");
                }

                $path = $fullPath;

                $data['file_path'] = $path;
                $data['file_size'] = $file->getSize();

            } catch (\Exception $e) {
                 $msg = 'Error Koneksi Nextcloud: ' . $e->getMessage();
                 if ($request->wantsJson()) {
                     return response()->json(['success' => false, 'message' => $msg], 500);
                 }
                 return back()->with('error', $msg);
            }
        }

        $document->update($data);

        if ($request->wantsJson()) {
             return response()->json(['success' => true, 'message' => 'Dokumen berhasil diperbarui.']);
        }

        return redirect()->route('dashboard')->with('success', 'Dokumen berhasil diperbarui.');
    }

    // 8. HAPUS DOKUMEN
    public function destroy(Document $document)
    {
        // Hapus file fisik di Nextcloud jika ada
        if (Storage::disk('nextcloud')->exists($document->file_path)) {
            Storage::disk('nextcloud')->delete($document->file_path);
        }

        // Hapus data dari database
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }
}