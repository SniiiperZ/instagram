<x-app-layout>
    {{-- Définition de l'en-tête de la page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Conversation avec <a href="{{ route('profile.show', $user->id) }}" class="text-blue-500">{{ $user->name }}</a>
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="bg-white rounded-lg shadow-lg p-4 mb-4 max-w-lg mx-auto">
            {{-- Section des messages --}}
            <div class="overflow-y-auto h-96 p-2 border-b">
                @foreach ($messages as $message)
                    <div class="{{ $message->sender_id == auth()->id() ? 'text-right' : '' }} mb-4">
                        <div class="inline-block px-4 py-2 rounded {{ $message->sender_id == auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-800' }}">
                            {{ $message->message }}
                        </div>
                        <small class="block text-gray-500">{{ $message->created_at->format('H:i') }}</small>
                    </div>
                @endforeach
            </div>

            {{-- Formulaire d'envoi de message --}}
            <form method="POST" action="{{ route('messages.send') }}" class="mt-4 flex space-x-2">
                @csrf
                {{-- Champ caché pour l'identifiant du destinataire --}}
                <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                {{-- Champ de saisie du message --}}
                <input type="text" name="message" placeholder="Ecrire un message..." class="flex-grow border rounded px-4 py-2">
                {{-- Bouton d'envoi --}}
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Envoyer</button>
            </form>
        </div>
    </div>
</x-app-layout>
