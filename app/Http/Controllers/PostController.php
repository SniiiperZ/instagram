<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    // Load only `user` for the post and `user` for each like
    $post->load('user', 'likes', 'comments.user');
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

    public function share(Post $post)
    {
        // Crée un nouveau post avec les mêmes données que le post original
        Post::create([
            'user_id' => auth()->id(),
            'image' => $post->image,
            'caption' => 'Partagé: ' . $post->caption,
        ]);

        return redirect()->route('posts.index')->with('status', 'Post shared successfully!');
    }

    public function destroy(Post $post)
    {
        // Vérifiez que seul l'auteur peut supprimer la publication
        if (auth()->id() !== $post->user_id) {
            abort(403); // Refuse l'accès si l'utilisateur n'est pas l'auteur
        }

        // Supprime l'image du stockage
        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        // Supprime la publication
        $post->delete();

        // Redirige l'utilisateur avec un message de succès
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
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
