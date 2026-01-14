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

    // Users who bookmarked this document
    public function favoritedBy()
    {
        return $this->belongsToMany(\App\Models\User::class, 'bookmarks')->withTimestamps();
    }

    // Check if given user has favorited this document
    public function isFavoritedBy(?\App\Models\User $user)
    {
        if (!$user) return false;
        return $this->favoritedBy()->where('user_id', $user->id)->exists();
    }
}