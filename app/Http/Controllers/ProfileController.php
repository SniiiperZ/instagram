<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function show(User $user)
{
    $posts = Post::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('profile.show', compact('user', 'posts'));
}




    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        // Remplir les données validées de l'utilisateur
        $request->user()->fill($request->validated());

        // Si l'email est modifié, réinitialiser la vérification de l'email
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        // Ajouter la bio si elle est présente dans la requête
        if ($request->filled('bio')) {
            $request->user()->bio = $request->input('bio');
        }

        // Gérer l'upload de la photo de profil
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $request->user()->profile_photo = $path;
        }

        // Sauvegarder l'utilisateur
        $request->user()->save();

        // Redirection avec message de succès
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function follow(User $user)
    {
        if (!auth()->user()->following()->where('following_id', $user->id)->exists()) {
            auth()->user()->following()->attach($user->id);
        }
    
        return redirect()->back();
    }
    
    public function unfollow(User $user)
    {
        if (auth()->user()->following()->where('following_id', $user->id)->exists()) {
            auth()->user()->following()->detach($user->id);
        }
    
        return redirect()->back();
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
