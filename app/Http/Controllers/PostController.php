<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        // Récupère les posts dans l'ordre le plus récent
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        // Renvoie la vue avec les posts
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
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
    public function destroy(Post $post)
    {
        // Suppression de l'image du post
        $post->delete();

        return redirect()->route('posts.index')->with('status', 'Post deleted successfully!');
    }

    public function like(Post $post)
    {
        // Ajoute l'utilisateur authentifié à la liste des utilisateurs aimant le post
        $post->likes()->attach(auth()->id());

        return back();
    }

    public function unlike(Post $post)
    {
        // Retire l'utilisateur authentifié de la liste des utilisateurs aimant le post
        $post->likes()->detach(auth()->id());

        return back();
    }

}
