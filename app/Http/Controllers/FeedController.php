<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Utiliser la relation 'following' du modèle User
        $followedUsers = $user->following->pluck('id');

        // Récupérer les posts des utilisateurs suivis
        $followedPosts = Post::whereIn('user_id', $followedUsers)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Récupérer les posts les plus likés
        $topLikedPosts = Post::withCount('likes')
                            ->orderBy('likes_count', 'desc')
                            ->take(10)
                            ->get();

        return view('feed.index', compact('followedPosts', 'topLikedPosts'));
    }
}


