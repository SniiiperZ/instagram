<?php

namespace App\Http\Controllers;

use App\Models\Story;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'media' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Or accept video if you wish
        ]);

        $path = $request->file('media')->store('stories', 'public');
        
        Story::create([
            'user_id' => Auth::id(),
            'media_path' => $path,
            'expires_at' => Carbon::now()->addHours(24), // Story expires in 24 hours
        ]);

        return back()->with('success', 'Story posted!');
    }

    public function index()
{
    $stories = Story::with('user')->active()->get(); // or adjust as needed
    return view('stories.index', compact('stories'));
}


}