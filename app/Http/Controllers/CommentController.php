<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate; // Wajib di-import untuk Laravel 12

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru (atau balasan jika ada parent_id).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'content' => 'required'
        ]);

        Comment::create([
            'product_id' => $request->product_id,
            'user_id'    => auth()->id(),
            'parent_id'  => $request->parent_id, // Bisa null jika komentar utama
            'content'    => $request->content
        ]);

        return back()->with('success', 'Komentar berhasil dikirim!');
    }

    /**
     * Memperbarui isi komentar.
     */
    public function update(Request $request, Comment $comment)
    {
        // Menggunakan Gate untuk otorisasi di Laravel 12
        Gate::authorize('update', $comment);

        $request->validate([
            'content' => 'required'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back()->with('success', 'Komentar berhasil diperbarui!');
    }

    /**
     * Menghapus komentar.
     */
    public function destroy(Comment $comment)
    {
        // Menggunakan Gate untuk otorisasi di Laravel 12
        Gate::authorize('delete', $comment);

        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus!');
    }

    /**
     * Menambah jumlah Like.
     */
    public function like(Comment $comment)
    {
        $comment->increment('likes');
        return back();
    }

    /**
     * Menambah jumlah Dislike.
     */
    public function dislike(Comment $comment)
    {
        $comment->increment('dislikes');
        return back();
    }
}