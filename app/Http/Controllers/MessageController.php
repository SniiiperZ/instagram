<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class MessageController extends Controller
{
    /**
     * Affiche la liste des conversations de l'utilisateur connecté.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $userId = auth()->id();

        $conversations = Conversation::where('user_one_id', $userId)
            ->orWhere('user_two_id', $userId)
            ->with(['messages' => function($query) {
                $query->orderBy('created_at', 'asc');
            }, 'userOne', 'userTwo'])
            ->withCount('messages')
            ->get()
            ->sortByDesc(function ($conversation) {
                return $conversation->messages->last()->created_at ?? $conversation->created_at;
            });

        return view('messages.index', compact('conversations'));
    }

    /**
     * Affiche les messages d'une conversation spécifique.
     *
     * @param  \App\Models\Conversation  $conversation
     * @return \Illuminate\View\View
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function show(Conversation $conversation)
    {
        // Vérifie que l'utilisateur est bien participant à la conversation
        if ($conversation->user_one_id !== auth()->id() && $conversation->user_two_id !== auth()->id()) {
            abort(403);
        }

        // Récupère les messages de la conversation avec les informations de l'expéditeur
        $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

        return view('messages.show', compact('conversation', 'messages'));
    }

    /**
     * Affiche la conversation entre l'utilisateur connecté et un autre utilisateur.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function showChat(User $user)
    {
        $userId = Auth::id();

        // Recherche ou crée la conversation entre les deux utilisateurs
        $conversation = Conversation::where(function ($query) use ($userId, $user) {
            $query->where('user_one_id', $userId)
                  ->where('user_two_id', $user->id);
        })->orWhere(function ($query) use ($userId, $user) {
            $query->where('user_one_id', $user->id)
                  ->where('user_two_id', $userId);
        })->first();

        $messages = $conversation ? $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get() : collect();

        return view('messages.chat', compact('conversation', 'user', 'messages'));
    }

    /**
     * Envoie un message dans une conversation entre l'utilisateur connecté et un destinataire.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);

        $userId = Auth::id();

        // Recherche ou crée une conversation entre l'utilisateur connecté et le destinataire
        $conversation = Conversation::where(function ($query) use ($request, $userId) {
            $query->where('user_one_id', $userId)
                  ->where('user_two_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request, $userId) {
            $query->where('user_one_id', $request->receiver_id)
                  ->where('user_two_id', $userId);
        })->first();

        // Crée la conversation si elle n'existe pas encore
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => $userId,
                'user_two_id' => $request->receiver_id,
            ]);
        }

        // Crée le message dans la conversation
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => $userId,
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);

        return back();
    }
}
