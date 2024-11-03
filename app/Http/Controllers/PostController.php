<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Affiche la liste des publications, paginée par 10.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    /**
     * Affiche le formulaire de création d'une publication.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Affiche les détails d'une publication spécifique, avec ses relations.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\View\View
     */
    public function show(Post $post)
    {
        $post->load('user', 'likes', 'comments.user');

        return view('posts.show', compact('post'));
    }

    /**
     * Stocke une nouvelle publication dans la base de données.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        // Enregistre l'image dans le stockage public
        $imagePath = $request->file('image')->store('posts', 'public');

        // Crée le post avec les informations d'utilisateur et d'image
        Post::create([
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('posts.index')->with('status', 'Post created successfully!');
    }

    /**
     * Permet à l'utilisateur de partager une publication.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function share(Post $post)
    {
        // Crée un nouveau post avec les détails du post partagé
        Post::create([
            'user_id' => auth()->id(),
            'image' => $post->image,
            'caption' => 'Partagé: ' . $post->caption,
        ]);

        return redirect()->route('posts.index')->with('status', 'Post shared successfully!');
    }

    /**
     * Supprime une publication si l'utilisateur est le propriétaire.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Post $post)
    {
        // Vérifie que l'utilisateur actuel est bien le propriétaire du post
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        // Supprime l'image associée au post dans le stockage
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    /**
     * Permet à l'utilisateur de liker une publication.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function like(Post $post)
    {
        $post->likes()->attach(auth()->id());

        return back();
    }

    /**
     * Permet à l'utilisateur d'annuler son like sur une publication.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unlike(Post $post)
    {
        $post->likes()->detach(auth()->id());

        return back();
    }
}
