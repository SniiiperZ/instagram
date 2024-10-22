<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Recherche d'utilisateurs par nom ou bio
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('bio', 'LIKE', "%{$query}%")
                    ->get();

        // Recherche de posts par légende
        $posts = Post::where('caption', 'LIKE', "%{$query}%")
                    ->get();

        return view('search.results', compact('users', 'posts', 'query'));
    }
}

