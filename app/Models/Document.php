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
        'visibility',
        'cover_image',
        'year',
        'file_path',
        'file_size',
        'mime_type',
        'category_id',
        'user_id',
    ];

    // Type casting for attributes
    protected $casts = [
        'year' => 'integer',
        'file_size' => 'integer',
    ];

    // SCOPES FOR VISIBILITY
    /**
     * Scope untuk filter dokumen public
     */
    public function scopePublic($query)
    {
        return $query->where('visibility', 'public');
    }

    /**
     * Scope untuk filter dokumen private
     */
    public function scopePrivate($query)
    {
        return $query->where('visibility', 'private');
    }

    // HELPER METHODS
    /**
     * Check if document is public
     */
    public function isPublic()
    {
        return $this->visibility === 'public';
    }

    /**
     * Check if document is private
     */
    public function isPrivate()
    {
        return $this->visibility === 'private';
    }

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

    /**
     * Get formatted file size (MB, KB, Bytes)
     */
    public function getFormattedFileSizeAttribute()
    {
        $bytes = $this->file_size;
        
        if ($bytes >= 1024 * 1024) {
            return round($bytes / (1024 * 1024), 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }
}