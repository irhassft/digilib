<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view the model.
     * - Public documents: Siapa saja bisa lihat (login atau tidak)
     * - Private documents: Hanya user yang sudah login yang bisa lihat
     */
    public function view(?User $user, Document $document): bool
    {
        // Public documents - siapa saja bisa lihat
        if ($document->isPublic()) {
            return true;
        }

        // Private documents - hanya user yang sudah login
        if ($user === null) {
            return false; // Belum login, akses ditolak
        }

        // Semua user yang sudah login bisa akses private documents
        return true;
    }

    /**
     * Determine whether the user can download the model.
     * Same as view - public docs for everyone, private docs for authenticated users only
     */
    public function download(?User $user, Document $document): bool
    {
        return $this->view($user, $document);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Document $document): bool
    {
        return $user->id === $document->user_id || $user->hasRole('admin|super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Document $document): bool
    {
        return $user->id === $document->user_id || $user->hasRole('admin|super-admin');
    }
}
