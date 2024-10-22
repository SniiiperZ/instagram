<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $request->validate([
        'body' => 'required|max:500',
    ]);

    $post->comments()->create([
        'user_id' => auth()->id(),
        'post_id' => $post->id,
        'body' => $request->body,
    ]);

    return redirect()->back();
}

}
