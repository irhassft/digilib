<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;       // <--- PASTIKAN INI ADA
use Illuminate\Support\Str;    // <--- PASTIKAN INI ADA

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name'
        ]);

        // Simpan ke database
        $category = Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        // Kembalikan respon JSON
        return response()->json([
            'success' => true,
            'category' => $category
        ]);
    }

    // TAMBAHAN BARU: Hapus Kategori via AJAX
    public function destroy(Category $category)
    {
        // Cek apakah kategori ini dipakai oleh dokumen?
        // Kita asumsikan relasi di model Document adalah 'category_id'
        $isUsed = \App\Models\Document::where('category_id', $category->id)->exists();

        if ($isUsed) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal! Kategori ini sedang digunakan oleh dokumen lain.'
            ]);
        }

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Kategori berhasil dihapus.'
        ]);
    }
}