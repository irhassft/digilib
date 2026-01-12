<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Keamanan: Hanya kolom ini yang boleh diisi via formulir
    protected $fillable = ['name', 'slug'];

    // Relasi: Satu kategori memiliki BANYAK dokumen
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}