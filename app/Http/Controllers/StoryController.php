<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoryController extends Controller
{
    /**
     * Crée et enregistre une nouvelle story.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valide le fichier média
        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Enregistre le fichier et crée la story
        $path = $request->file('media')->store('stories', 'public');
        
        Story::create([
            'user_id' => Auth::id(),
            'media_path' => $path,
            'expires_at' => Carbon::now()->addHours(24),
        ]);

        return back()->with('success', 'Story posted!');
    }

    /**
     * Affiche les stories actives.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Récupère les stories actives en utilisant une portée personnalisée 'active'
        $stories = Story::with('user')->active()->get();
        
        return view('stories.index', compact('stories'));
    }
}
