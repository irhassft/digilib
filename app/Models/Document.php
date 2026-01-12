<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    // Pastikan 'slug' ada di sini
    protected $fillable = [
        'title',
        'slug',         // <--- TAMBAHKAN INI
        'description',
        'file_path',
        'file_size',    // <--- TAMBAHKAN INI
        'category_id',
        'user_id',
    ];

    // ... relasi lainnya biarkan saja
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function uploader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}