<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // 1. TAMPILKAN DASHBOARD & LIST DOKUMEN
    public function index(Request $request)
    {
        // Query Pencarian - untuk dashboard user yang login, tampilkan semua dokumen miliknya
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
        
        // Latest Activity for Sidebar - hanya public atau milik user
        $latestUploads = Document::public()
            ->orWhere('user_id', auth()->id())
            ->with('user')
            ->latest()
            ->take(5)
            ->get();

        $stats = [
            'total_documents'  => $totalDocuments,
            'total_downloads'  => 0, 
            'total_categories' => $totalCategories,
            'total_users'      => $totalUsers,
        ];

        $categories = Category::withCount('documents')->get();

        return view('dashboard', compact('documents', 'stats', 'categories', 'totalDocuments', 'latestUploads'));
    }

    // 1.a KOLEKSI SAYA - menampilkan kategori dan seluruh daftar dokumen milik user, dengan filter kategori
    public function collections(Request $request)
    {
        $userId = auth()->id();
        $user = auth()->user();
        
        // Default mode: 'all' untuk karyawan, 'mine' untuk admin/super-admin
        $defaultMode = $user->hasAnyRole(['admin', 'super-admin']) ? 'mine' : 'all';
        $mode = $request->get('mode', $defaultMode); // mine|all|favorites

        // Build categories counts depending on mode
        $categories = \App\Models\Category::withCount(['documents' => function ($q) use ($userId, $mode) {
            if ($mode === 'mine') {
                $q->where('user_id', $userId);
            } elseif ($mode === 'favorites') {
                $q->whereHas('favoritedBy', function ($qq) use ($userId) {
                    $qq->where('user_id', $userId);
                });
            }
            // mode === 'all' leaves query unfiltered
        }])->get();

        $query = Document::with('category');

        if ($mode === 'mine') {
            $query->where('user_id', $userId);
        } elseif ($mode === 'favorites') {
            $query->whereHas('favoritedBy', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter by visibility (public/private)
        if ($request->filled('visibility')) {
            $visibility = $request->get('visibility');
            if ($visibility === 'public') {
                $query->public();
            } elseif ($visibility === 'private') {
                $query->private();
            }
        }

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $documents = $query->latest()->paginate(12)->withQueryString();

        return view('collections.index', compact('categories', 'documents', 'mode'));
    }

    // Toggle favorite/bookmark for a document (AJAX)
    public function toggleFavorite(Request $request, Document $document)
    {
        $user = auth()->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        if ($user->favorites()->where('document_id', $document->id)->exists()) {
            $user->favorites()->detach($document->id);
            $favorited = false;
        } else {
            $user->favorites()->attach($document->id);
            $favorited = true;
        }

        return response()->json(['success' => true, 'favorited' => $favorited]);
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
        // 1. Validasi (Max 5MB for document, 5MB for cover image)
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:public,private',
            'cover_image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'year' => 'nullable|integer|min:1900|max:2100',
            'document_file' => 'required|file|max:51200',
            'category_id' => 'required',
        ]);

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();

            // 2. Mulai Try Block
            try {
                // Handle cover image upload first (if provided)
                $coverImagePath = null;
                if ($request->hasFile('cover_image')) {
                    try {
                        $coverFile = $request->file('cover_image');
                        // Use 'public' disk so it's accessible via /storage URL
                        $coverImagePath = Storage::disk('public')->putFile('cover-images', $coverFile);
                        \Log::info("Cover image stored publicly: {$coverImagePath}");
                    } catch (\Throwable $e) {
                        \Log::warning("Failed to store cover image: {$e->getMessage()}");
                        // Don't fail the entire upload if cover image fails, just skip it
                        $coverImagePath = null;
                    }
                }

                // Simpan ke Database DULU
                $document = Document::create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title) . '-' . time(),
                    'description' => $request->description,
                    'visibility' => $request->visibility,
                    'cover_image' => $coverImagePath,
                    'year' => $request->year,
                    'category_id' => $request->category_id,
                    'file_path' => '',
                    'file_size' => 0,
                    'mime_type' => $file->getMimeType() ?? 'application/pdf',
                    'user_id' => auth()->id(),
                ]);

                // 3. TENTUKAN ALAMAT LENGKAP (Based on Category)
                $prefix = trim(
                    config('nextcloud.folder_prefix', 'documents'),
                    '/'
                );
                
                // 4. EKSEKUSI UPLOAD - Create folder and upload with category subfolder structure
                $category = Category::find($request->category_id);
                $categoryName = $category ? Str::slug($category->name) : 'general';
                
                $targetFolder = "{$prefix}/{$categoryName}";
                $fullPath = "{$targetFolder}/{$filename}";
                
                \Log::info("Nextcloud upload attempt: folder={$targetFolder}, file={$filename}");
                
                // Step 1: Ensure folder exists via WebDAV MKCOL
                $this->ensureNextcloudFolder($targetFolder);
                
                // Step 2: Upload file using Guzzle
                $uploadSuccess = $this->uploadToNextcloud($fullPath, $file);

                if (!$uploadSuccess) {
                    $document->delete();
                    throw new \Exception("Server Nextcloud menolak file (Upload Error). Target: {$fullPath}");
                }
                
                // 5. Update Record dengan Path yang benar
                $document->update([
                    'file_path' => $fullPath,
                    'file_size' => $file->getSize()
                ]);

                // Sukses
                if ($request->wantsJson()) {
                    return response()->json(['success' => true, 'message' => 'Berhasil Upload!']);
                }
                return redirect()->route('dashboard')->with('success', 'Berhasil Upload!');

            } catch (\Exception $e) {
                // Rollback
                if (isset($document) && $document->exists) {
                    try {
                        $document->delete();
                    } catch (\Throwable $ex) {
                        \Log::warning('Gagal menghapus record dokumen setelah kegagalan upload: ' . $ex->getMessage());
                    }
                }

                \Log::error('Nextcloud upload error: ' . $e->getMessage(), ['exception' => $e]);

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
        // Check authorization - public documents siapa saja bisa download
        // Private documents hanya user yang sudah login
        if ($document->isPrivate() && !auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengunduh dokumen ini.');
        }

        try {
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            if (empty($baseUri) || empty($document->file_path)) {
                abort(404, 'File tidak tersedia.');
            }
            
            $fileUrl = "{$baseUri}/{$document->file_path}";
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('GET', $fileUrl, [
                'auth' => [$username, $appPassword],
                'http_errors' => false,
            ]);
            
            if ($response->getStatusCode() !== 200) {
                abort(404, 'File tidak ditemukan di server Nextcloud.');
            }
            
            return response($response->getBody()->getContents())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $document->title . '.pdf"');
        } catch (\Throwable $e) {
            \Log::error("Download file error: {$e->getMessage()}");
            abort(500, 'Gagal mengunduh file.');
        }
    }

    // 5. PREVIEW DOKUMEN
    public function view(Document $document)
    {
        // Check authorization - public documents siapa saja bisa view
        // Private documents hanya user yang sudah login
        if ($document->isPrivate() && !auth()->check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk mengakses dokumen ini.');
        }

        try {
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            if (empty($baseUri) || empty($document->file_path)) {
                abort(404, 'File tidak tersedia.');
            }
            
            $fileUrl = "{$baseUri}/{$document->file_path}";
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('GET', $fileUrl, [
                'auth' => [$username, $appPassword],
                'http_errors' => false,
            ]);
            
            if ($response->getStatusCode() !== 200) {
                abort(404, 'File tidak ditemukan di server Nextcloud.');
            }
            
            return response($response->getBody()->getContents())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $document->slug . '.pdf"');
        } catch (\Throwable $e) {
            \Log::error("View file error: {$e->getMessage()}");
            abort(500, 'Gagal membuka file.');
        }
    }

    // Menampilkan dokumen publik tanpa login
    public function viewPublic(Document $document)
    {
        // Hanya dokumen publik yang bisa diakses tanpa login
        if (!$document->isPublic()) {
            abort(403, 'Dokumen ini tidak tersedia untuk akses publik.');
        }

        try {
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            if (empty($baseUri) || empty($document->file_path)) {
                abort(404, 'File tidak tersedia.');
            }
            
            $fileUrl = "{$baseUri}/{$document->file_path}";
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            $response = $client->request('GET', $fileUrl, [
                'auth' => [$username, $appPassword],
                'http_errors' => false,
            ]);
            
            if ($response->getStatusCode() !== 200) {
                abort(404, 'File tidak ditemukan di server Nextcloud.');
            }
            
            return response($response->getBody()->getContents())
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="' . $document->slug . '.pdf"');
        } catch (\Throwable $e) {
            \Log::error("View file error: {$e->getMessage()}");
            abort(500, 'Gagal membuka file.');
        }
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
            'visibility' => 'required|in:public,private',
            'cover_image' => 'nullable|image|mimes:jpeg,png,gif,webp|max:5120',
            'year' => 'nullable|integer|min:1900|max:2100',
            'category_id' => 'required',
            'document_file' => 'nullable|file|mimes:pdf|max:102400',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'visibility' => $request->visibility,
            'year' => $request->year,
            'category_id' => $request->category_id,
        ];
        
        if ($request->title !== $document->title) {
            $data['slug'] = Str::slug($request->title) . '-' . time();
        }

        // Handle cover image update
        if ($request->hasFile('cover_image')) {
            try {
                // Delete old cover image if exists
                if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
                    Storage::disk('public')->delete($document->cover_image);
                }

                // Store new cover image using public disk
                $coverFile = $request->file('cover_image');
                $coverImagePath = Storage::disk('public')->putFile('cover-images', $coverFile);
                $data['cover_image'] = $coverImagePath;
                \Log::info("Cover image updated: {$coverImagePath}");
            } catch (\Throwable $e) {
                \Log::warning("Failed to update cover image: {$e->getMessage()}");
                // Don't fail the entire update if cover image fails
            }
        }

        if ($request->hasFile('document_file')) {
            $file = $request->file('document_file');
            $filename = time() . '-' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            
            $prefix = trim(
                config('nextcloud.folder_prefix', 'documents'),
                '/'
            );
            
            $newCategory = Category::find($request->category_id);
            $categoryName = $newCategory ? Str::slug($newCategory->name) : 'uncategorized';
            
            $targetFolder = "{$prefix}/{$categoryName}";
            $fullPath = "{$targetFolder}/{$filename}";

            try {
                // Try to delete old file via WebDAV
                try {
                    if (!empty($document->file_path)) {
                        $this->deleteFromNextcloud($document->file_path);
                    }
                } catch (\Throwable $e) {
                    \Log::warning("Nextcloud: Could not delete old file {$document->file_path}: {$e->getMessage()}");
                }
                
                \Log::info("Nextcloud update upload attempt: folder={$targetFolder}, file={$filename}");
                
                // Ensure folder exists
                $this->ensureNextcloudFolder($targetFolder);
                
                // Upload file
                $uploadSuccess = $this->uploadToNextcloud($fullPath, $file);
                
                if (!$uploadSuccess) {
                    throw new \Exception("Server Nextcloud menolak file baru (Upload Error). Target: {$fullPath}");
                }

                $data['file_path'] = $fullPath;
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
        // Hapus cover image public jika ada
        if ($document->cover_image && Storage::disk('public')->exists($document->cover_image)) {
            try {
                Storage::disk('public')->delete($document->cover_image);
                \Log::info("Cover image deleted: {$document->cover_image}");
            } catch (\Throwable $e) {
                \Log::warning("Failed to delete cover image {$document->cover_image}: {$e->getMessage()}");
            }
        }

        // Hapus file fisik di Nextcloud jika ada
        if (!empty($document->file_path)) {
            try {
                $this->deleteFromNextcloud($document->file_path);
            } catch (\Throwable $e) {
                \Log::warning("Could not delete Nextcloud file {$document->file_path}: {$e->getMessage()}");
            }
        }

        // Hapus data dari database
        $document->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    /**
     * Ensure Nextcloud folder exists via WebDAV MKCOL
     */
    private function ensureNextcloudFolder($folderPath)
    {
        try {
            // Get credentials from config
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            \Log::debug("Nextcloud MKCOL Credentials", [
                'baseUri_empty' => empty($baseUri),
                'username' => $username,
                'password_len' => strlen($appPassword ?? ''),
            ]);
            
            if (empty($baseUri) || empty($username) || empty($appPassword)) {
                \Log::error("Nextcloud credentials not configured properly", [
                    'baseUri' => $baseUri,
                    'username' => $username,
                    'app_password' => $appPassword,
                ]);
                return false;
            }
            
            $folderUrl = "{$baseUri}/{$folderPath}";
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            
            // Try MKCOL to create folder - use Basic Auth with username:appPassword
            $response = $client->request('MKCOL', $folderUrl, [
                'auth' => [$username, $appPassword],
                'http_errors' => false,
            ]);
            
            $statusCode = $response->getStatusCode();
            if (in_array($statusCode, [200, 201, 204, 405])) { // 405 = folder already exists
                \Log::info("Nextcloud folder ensured: {$folderPath} (HTTP {$statusCode})");
                return true;
            } else {
                \Log::warning("Nextcloud MKCOL failed for {$folderPath} (HTTP {$statusCode})");
                \Log::warning("MKCOL Response: " . $response->getBody()->getContents());
                return false;
            }
        } catch (\Throwable $e) {
            \Log::warning("Nextcloud folder creation exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Upload file to Nextcloud via WebDAV PUT
     */
    private function uploadToNextcloud($filePath, $file)
    {
        try {
            // Get credentials from config
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            \Log::debug("Nextcloud PUT Credentials", [
                'baseUri_empty' => empty($baseUri),
                'username' => $username,
                'password_len' => strlen($appPassword ?? ''),
            ]);
            
            if (empty($baseUri) || empty($username) || empty($appPassword)) {
                \Log::error("Nextcloud credentials not configured properly");
                return false;
            }
            
            $uploadUrl = "{$baseUri}/{$filePath}";
            
            $fileContent = file_get_contents($file->getRealPath());
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            
            // Use Basic Auth with username:appPassword
            $response = $client->request('PUT', $uploadUrl, [
                'auth' => [$username, $appPassword],
                'body' => $fileContent,
                'headers' => [
                    'Content-Type' => $file->getMimeType() ?: 'application/octet-stream',
                ],
                'http_errors' => false,
            ]);
            
            $statusCode = $response->getStatusCode();
            \Log::info("Nextcloud WebDAV PUT {$filePath}: HTTP {$statusCode}");
            
            if (!in_array($statusCode, [200, 201, 204])) {
                \Log::warning("PUT Response: " . $response->getBody()->getContents());
            }
            
            return in_array($statusCode, [200, 201, 204]);
        } catch (\Throwable $e) {
            \Log::error("Nextcloud WebDAV PUT exception: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Delete file from Nextcloud via WebDAV DELETE
     */
    private function deleteFromNextcloud($filePath)
    {
        try {
            $baseUri = rtrim(config('nextcloud.webdav_base_uri', ''), '/');
            $username = config('nextcloud.username');
            $appPassword = config('nextcloud.app_password');
            
            if (empty($baseUri) || empty($username) || empty($appPassword)) {
                \Log::error("Nextcloud credentials not configured properly");
                return false;
            }
            
            $deleteUrl = "{$baseUri}/{$filePath}";
            
            $client = new \GuzzleHttp\Client(['verify' => false]);
            
            $response = $client->request('DELETE', $deleteUrl, [
                'auth' => [$username, $appPassword],
                'http_errors' => false,
            ]);
            
            $statusCode = $response->getStatusCode();
            if (in_array($statusCode, [200, 204])) {
                \Log::info("Nextcloud file deleted: {$filePath} (HTTP {$statusCode})");
                return true;
            } else {
                \Log::warning("Nextcloud DELETE failed for {$filePath} (HTTP {$statusCode})");
                \Log::warning("DELETE Response: " . $response->getBody()->getContents());
                return false;
            }
        } catch (\Throwable $e) {
            \Log::error("Nextcloud WebDAV DELETE exception: {$e->getMessage()}");
            throw $e;
        }
    }
}
