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
     * - Owner bisa edit dokumentnya sendiri
     * - Super-admin bisa edit semua dokumen
     * - Admin biasa hanya bisa edit dokumen miliknya sendiri
     */
    public function update(User $user, Document $document): bool
    {
        // Owner dokumen bisa edit
        if ($user->id === $document->user_id) {
            return true;
        }

        // Hanya super-admin yang bisa edit dokumen orang lain
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can delete the model.
     * - Owner bisa hapus dokumentnya sendiri
     * - Super-admin bisa hapus semua dokumen
     * - Admin biasa hanya bisa hapus dokumen miliknya sendiri
     */
    public function delete(User $user, Document $document): bool
    {
        // Owner dokumen bisa hapus
        if ($user->id === $document->user_id) {
            return true;
        }

        // Hanya super-admin yang bisa hapus dokumen orang lain
        return $user->hasRole('super-admin');
    }
}
