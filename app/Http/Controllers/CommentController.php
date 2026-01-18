<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'content' => 'required'
        ]);

        Comment::create([
            'product_id' => $request->product_id,
            'user_id' => auth()->id(),
            'parent_id' => $request->parent_id,
            'content' => $request->content
        ]);

        return back();
    }

    public function update(Request $request, Comment $comment)
    {
        $this->authorize('update', $comment);

        $request->validate([
            'content' => 'required'
        ]);

        $comment->update([
            'content' => $request->content
        ]);

        return back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();
        return back();
    }

    public function like(Comment $comment)
    {
        $comment->increment('likes');
        return back();
    }

    public function dislike(Comment $comment)
    {
        $comment->increment('dislikes');
        return back();
    }
}
