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
        // Ini wajib ada agar error "Undefined variable $stats" hilang
        $stats = [
            'total_documents'  => Document::count(),
            'total_downloads'  => 0, // Placeholder (bisa dikembangkan nanti)
            'total_categories' => Category::count(),
            'total_users'      => User::count(),
        ];

        return view('dashboard', compact('documents', 'stats'));
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
        // 1. Validasi (Max 100MB)
        $request->validate([
            'title' => 'required|string|max:255',
            'document_file' => 'required|file|mimes:pdf|max:102400',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // 2. TENTUKAN ALAMAT LENGKAP
            // Karena pathPrefix di config KOSONG, kita tulis manual folder tujuannya disini.
            $targetFolder = 'Digilib_rspku/documents'; 

            try {
                // 3. EKSEKUSI UPLOAD
                // putFileAs(FolderTujuan, FileFisik, NamaBaru)
                $path = Storage::disk('nextcloud')->putFileAs($targetFolder, $file, $filename);
                
                if (!$path) {
                    return back()->with('error', 'Gagal: Server menolak file.');
                }
            } catch (\Exception $e) {
                return back()->with('error', 'Error Koneksi: ' . $e->getMessage());
            }

            // 4. Simpan ke Database
            Document::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . time(),
                'category_id' => $request->category_id,
                'file_path' => $path, // Path tersimpan: Digilib_rspku/documents/nama.pdf
                'file_size' => $file->getSize(),
                'user_id' => auth()->id(),
            ]);
            
            return redirect()->route('dashboard')->with('success', 'Berhasil Upload!');
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
        
        // Tampilkan sebagai PDF di browser (Inline) hsdgfdsjhgdsf kontol
        return response($fileContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $document->slug . '.pdf"');
    }

    // 6. HAPUS DOKUMEN
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