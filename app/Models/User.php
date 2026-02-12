<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles; // <--- 1. Import Trait Spatie
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles; // <--- 2. Pasang Trait di sini

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    /**
     * Set password attribute - otomatis hash jika belum ter-hash
     */
    protected function setPasswordAttribute(string $value): void
    {
        // Cek apakah password sudah ter-hash (dimulai dengan $2y$, $2a$, atau $2b$)
        if (preg_match('/^\$2[aby]\$/', $value)) {
            // Password sudah di-hash, gunakan langsung
            $this->attributes['password'] = $value;
        } else {
            // Password belum di-hash, hash sekarang
            $this->attributes['password'] = Hash::make($value);
        }
    }

    // Relasi tambahan: User memiliki banyak dokumen yang diupload
    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    // Favorites (bookmarks) - dokumen yang ditandai user
    public function favorites()
    {
        return $this->belongsToMany(\App\Models\Document::class, 'bookmarks')->withTimestamps();
    }
}