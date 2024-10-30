<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')->orderBy('created_at', 'desc')->paginate(10);

        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }


    public function show(Post $post)
{
    $post->load('user', 'likes', 'comments.user');
    return view('posts.show', compact('post'));
}



    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);

        $imagePath = $request->file('image')->store('posts', 'public');

        Post::create([
            'user_id' => auth()->id(),
            'image' => $imagePath,
            'caption' => $request->caption,
        ]);

        return redirect()->route('posts.index')->with('status', 'Post created successfully!');
    }

    public function share(Post $post)
    {
        Post::create([
            'user_id' => auth()->id(),
            'image' => $post->image,
            'caption' => 'Partagé: ' . $post->caption,
        ]);

        return redirect()->route('posts.index')->with('status', 'Post shared successfully!');
    }

    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort(403);
        }

        if ($post->image) {
            Storage::delete('public/' . $post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }


    public function like(Post $post)
    {
        $post->likes()->attach(auth()->id());

        return back();
    }

    public function unlike(Post $post)
    {
        $post->likes()->detach(auth()->id());

        return back();
    }

}
