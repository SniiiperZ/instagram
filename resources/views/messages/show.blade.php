<x-app-layout>
    {{-- Début de la section d'en-tête --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{-- Affichage du nom de l'utilisateur avec qui la conversation est en cours --}}
            Conversation avec {{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
        </h2>
    </x-slot>
    {{-- Fin de la section d'en-tête --}}

    <div class="container mx-auto py-8 px-4">
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            {{-- Début de la section de navigation --}}
            <div class="p-4 border-b flex justify-between">
                {{-- Lien vers le profil de l'utilisateur avec qui la conversation est en cours --}}
                <a href="{{ route('profile.show', $conversation->userOne->id === auth()->id() ? $conversation->userTwo->id : $conversation->userOne->id) }}" class="text-blue-500">
                    {{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->name : $conversation->userOne->name }}
                </a>
                {{-- Lien pour retourner à la liste des messages --}}
                <a href="{{ route('messages.index') }}" class="text-blue-500">Retour</a>
            </div>
            {{-- Fin de la section de navigation --}}

            {{-- Début de la section des messages --}}
            <div class="max-h-96 overflow-y-auto p-4">
                @forelse ($messages as $message)
                    {{-- Affichage des messages avec alignement à droite ou à gauche selon l'expéditeur --}}
                    <div class="{{ $message->sender_id === auth()->id() ? 'text-right' : 'text-left' }} mb-4">
                        <div class="{{ $message->sender_id === auth()->id() ? 'bg-blue-500 text-white' : 'bg-gray-200' }} inline-block rounded-lg p-2">
                            <p>{{ $message->message }}</p>
                        </div>
                        {{-- Affichage de la date d'envoi du message --}}
                        <span class="text-xs text-gray-500">{{ $message->created_at->diffForHumans() }}</span>
                    </div>
                @empty
                    {{-- Message affiché lorsqu'il n'y a aucun message dans la conversation --}}
                    <p class="text-center text-gray-500">Aucun message</p>
                @endforelse
            </div>
            {{-- Fin de la section des messages --}}

            {{-- Début de la section d'envoi de message --}}
            <div class="p-4 border-t">
                <form method="POST" action="{{ route('messages.send') }}" class="flex">
                    @csrf
                    {{-- Champ caché pour l'identifiant du destinataire --}}
                    <input type="hidden" name="receiver_id" value="{{ $conversation->userOne->id === auth()->id() ? $conversation->userTwo->id : $conversation->userOne->id }}">
                    {{-- Champ de saisie pour le message --}}
                    <input type="text" name="message" placeholder="Écrire un message..." class="flex-grow border rounded-lg p-2 mr-2" required>
                    {{-- Bouton pour envoyer le message --}}
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Envoyer</button>
                </form>
            </div>
            {{-- Fin de la section d'envoi de message --}}
        </div>
    </div>
</x-app-layout>
