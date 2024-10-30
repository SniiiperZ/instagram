<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $followedUsers = $user->following->pluck('id');

        $followedPosts = Post::whereIn('user_id', $followedUsers)
                            ->orderBy('created_at', 'desc')
                            ->get();

        $topLikedPosts = Post::withCount('likes')
                            ->orderBy('likes_count', 'desc')
                            ->take(10)
                            ->get();

        return view('feed.index', compact('followedPosts', 'topLikedPosts'));
    }
}


