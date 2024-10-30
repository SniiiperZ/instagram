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
    public function index()
    {
        $conversations = Conversation::where('user_one_id', auth()->id())
            ->orWhere('user_two_id', auth()->id())
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



    public function show(Conversation $conversation)
{
    if ($conversation->user_one_id !== auth()->id() && $conversation->user_two_id !== auth()->id()) {
        abort(403);
    }

    $messages = $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get();

    return view('messages.show', compact('conversation', 'messages'));
}







    public function showChat(User $user)
    {
        $conversation = Conversation::where(function ($query) use ($user) {
            $query->where('user_one_id', Auth::id())
                  ->where('user_two_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('user_one_id', $user->id)
                  ->where('user_two_id', Auth::id());
        })->first();

        $messages = $conversation ? $conversation->messages()->with('sender')->orderBy('created_at', 'asc')->get() : collect();

        return view('messages.chat', compact('conversation', 'user', 'messages'));
    }


    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'receiver_id' => 'required|exists:users,id',
        ]);
    
        $conversation = Conversation::where(function ($query) use ($request) {
            $query->where('user_one_id', Auth::id())
                  ->where('user_two_id', $request->receiver_id);
        })->orWhere(function ($query) use ($request) {
            $query->where('user_one_id', $request->receiver_id)
                  ->where('user_two_id', Auth::id());
        })->first();
    
        if (!$conversation) {
            $conversation = Conversation::create([
                'user_one_id' => Auth::id(),
                'user_two_id' => $request->receiver_id,
            ]);
        }
    
        Message::create([
            'conversation_id' => $conversation->id,
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
        ]);
    
        return back();
    }


}
