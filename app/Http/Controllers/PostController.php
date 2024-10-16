<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function create()
{
    return view('posts.create');
}
public function store(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'caption' => 'nullable|string|max:255',
    ]);

    // Sauvegarde de l'image dans le dossier storage
    $imagePath = $request->file('image')->store('posts', 'public');

    // Création du post
    Post::create([
        'user_id' => auth()->id(),
        'image' => $imagePath,
        'caption' => $request->caption,
    ]);

    return redirect()->route('posts.index')->with('status', 'Post created successfully!');
}

}
