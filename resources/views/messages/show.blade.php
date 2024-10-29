<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Conversation avec {{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8 px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <div class="p-4 border-b flex justify-between">
                <a href="{{ route('profile.show', $conversation->userOne->id === auth()->id() ? $conversation->userTwo->id : $conversation->userOne->id) }}" class="text-blue-500">{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}</a>
                <a href="{{ route('messages.index') }}" class="text-blue-500">Retour</a>
            </div>
            <div class="max-h-96 overflow-y-auto p-4">
                @forelse ($messages as $message)
                    <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }} mb-4">
                        <div class="{{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }} inline-block rounded-lg p-2">
                            <p>{{ $message->message }}</p>
                        </div>
                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    <p class="text-center text-gray-500">Aucun message</p>
                @endforelse
            </div>

            <div class="p-4 border-t">
                <form method="POST" action="{{ route('messages.send') }}" class="flex">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->id : $conversation->userOne->id }}">
                    <input type="text" name="message" placeholder="Écrire un message..." class="flex-grow border rounded-lg p-2 mr-2" required>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Envoyer</button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
