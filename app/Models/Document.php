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
        'slug',     
        'description',
        'cover_image',
        'year',
        'file_path',
        'file_size', 
        'category_id',
        'user_id',
    ];

    // Type casting for attributes
    protected $casts = [
        'year' => 'integer',
        'file_size' => 'integer',
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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}