<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * User boleh update komentar
     * - pemilik komentar
     * - admin
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->role === 'admin';
    }

    /**
     * User boleh hapus komentar
     * - pemilik komentar
     * - admin
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->role === 'admin';
    }
}
