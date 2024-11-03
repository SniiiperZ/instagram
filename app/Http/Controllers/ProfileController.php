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
     * Affiche la vue d'édition du profil.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Affiche le profil d'un utilisateur et ses publications.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user): View
    {
        $posts = Post::where('user_id', $user->id)
                    ->orderBy('created_at', 'desc')
                    ->get();

        return view('profile.show', compact('user', 'posts'));
    }

    /**
     * Met à jour les informations du profil de l'utilisateur.
     *
     * @param  \App\Http\Requests\ProfileUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Met à jour les champs validés du profil
        $user->fill($request->validated());

        // Réinitialise la vérification de l'email si modifié
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Met à jour la biographie si fournie
        if ($request->filled('bio')) {
            $user->bio = $request->input('bio');
        }

        // Met à jour la photo de profil si une nouvelle image est fournie
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('profile_photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Permet à l'utilisateur connecté de suivre un autre utilisateur.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function follow(User $user): RedirectResponse
    {
        // Assure que l'utilisateur ne peut pas se suivre lui-même
        if ($user->id !== auth()->id() && !auth()->user()->following()->where('following_id', $user->id)->exists()) {
            auth()->user()->following()->attach($user->id);
        }

        return redirect()->back();
    }

    /**
     * Permet à l'utilisateur connecté de se désabonner d'un autre utilisateur.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unfollow(User $user): RedirectResponse
    {
        if ($user->id !== auth()->id() && auth()->user()->following()->where('following_id', $user->id)->exists()) {
            auth()->user()->following()->detach($user->id);
        }

        return redirect()->back();
    }

    /**
     * Supprime le compte utilisateur après vérification du mot de passe.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        // Déconnecte l'utilisateur avant de supprimer le compte
        Auth::logout();

        // Supprime l'utilisateur de la base de données
        $user->delete();

        // Invalide et régénère la session pour la sécurité
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
