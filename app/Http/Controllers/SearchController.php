<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Effectue une recherche parmi les utilisateurs et les publications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Recherche des utilisateurs par nom ou biographie
        $users = User::where('name', 'LIKE', "%{$query}%")
                    ->orWhere('bio', 'LIKE', "%{$query}%")
                    ->get();

        // Recherche des publications par légende
        $posts = Post::where('caption', 'LIKE', "%{$query}%")
                    ->get();

        return view('search.results', compact('users', 'posts', 'query'));
    }
}
