<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Ajoute un commentaire à un post spécifique.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Post $post)
    {
        // Valide le contenu du commentaire
        $request->validate([
            'body' => 'required|max:500',
        ]);

        // Crée le commentaire associé au post
        $post->comments()->create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body' => $request->body,
        ]);

        return redirect()->back()->with('status', 'Comment added successfully!');
    }
}
