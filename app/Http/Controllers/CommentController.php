<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id',
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
}
