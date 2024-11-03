<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    /**
     * Affiche les posts des utilisateurs suivis et les posts populaires.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();

        // Récupère les posts des utilisateurs suivis
        $followedUsers = $user->following->pluck('id');
        $followedPosts = Post::whereIn('user_id', $followedUsers)
                            ->orderBy('created_at', 'desc')
                            ->get();

        // Récupère les posts les plus likés
        $topLikedPosts = Post::withCount('likes')
                            ->orderBy('likes_count', 'desc')
                            ->take(10)
                            ->get();

        return view('feed.index', compact('followedPosts', 'topLikedPosts'));
    }
}
