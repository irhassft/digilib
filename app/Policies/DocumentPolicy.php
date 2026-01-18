<?php

namespace App\Policies;

use App\Models\Document;
use App\Models\User;

class DocumentPolicy
{
    /**
     * Determine whether the user can view the model.
     * Public documents dapat dilihat siapa saja
     * Private documents hanya bisa dilihat owner atau admin
     */
    public function view(?User $user, Document $document): bool
    {
        // Public documents bisa dilihat siapa saja (termasuk yang belum login)
        if ($document->isPublic()) {
            return true;
        }

        // Private documents hanya bisa dilihat jika sudah login dan owner
        if ($user === null) {
            return false; // Belum login, akses ditolak
        }

        // Owner atau admin bisa lihat dokumen private miliknya
        return $user->id === $document->user_id || $user->hasRole('admin|super-admin');
    }

    /**
     * Determine whether the user can download the model.
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
