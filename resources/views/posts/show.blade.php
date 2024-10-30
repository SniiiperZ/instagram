<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ $post->caption }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md">
            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto rounded-t-lg">
            
            <div class="p-4">
                <h3 class="font-bold text-lg">
                    <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500">{{ $post->user->name }}</a>
                </h3>
                <p class="text-gray-600">{{ $post->caption }}</p>
                @if (auth()->id() === $post->user_id)
                    <form method="POST" action="{{ route('posts.destroy', $post) }}">
                        @csrf
                        @method('DELETE')
                        <x-danger-button onclick="return confirm('Tu es sûre de vouloir supprimer cette publication?')">
                            {{ __('Supprimer') }}
                        </x-danger-button>
                    </form>
                @endif

                <hr class="my-4">

@if ($post->likes->isNotEmpty())
    <div>
    <!-- Envelopper avec Alpine.js -->
<div x-data="{ open: false }">
    <!-- Compteur de likes avec un clic pour afficher la modale -->
    <p class="mb-4">
        <span @click="open = true" class="text-gray-600 font-bold cursor-pointer">
            {{ $post->likes()->count() }} J'aimes
        </span>
    </p>

    <!-- Modale cachée par défaut, visible quand `open` est vrai -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
        <!-- Ajout de @click.away ici -->
        <div @click.away="open = false" class="bg-white rounded-lg shadow-lg w-1/3 p-4">
            <h2 class="text-lg font-semibold mb-4">Aimé par</h2>
            <ul>
                @foreach ($post->likes as $like)
                    <li class="mb-2">
                        <a href="{{ route('profile.show', $like) }}" class="text-blue-500">{{ $like->name }}</a>
                    </li>
                @endforeach
            </ul>
            <x-danger-button @click="open = false" >Fermer</x-danger-button>
        </div>
    </div>
</div>

@endif

<div class="flex space-x-4">
<!-- Vérifier si l'utilisateur a déjà liké la publication -->
@if ($post->likes()->where('user_id', auth()->id())->exists())
    <!-- Dislike Button -->
    <form method="POST" action="{{ route('posts.unlike', $post) }}">
        @csrf
        <x-danger-button>
            {{ __('Dislike') }}
        </x-danger-button>
    </form>
@else
    <!-- Like Button -->
    <form method="POST" action="{{ route('posts.like', $post) }}">
        @csrf
        <x-primary-button>
            {{ __('Like') }}
        </x-primary-button>
    </form>
@endif
                </form>
                <form method="POST" action="{{ route('posts.share', $post) }}">
    @csrf
    <x-primary-button>
        {{ __('Partage') }}
    </x-primary-button>
</form>
            </div>


                <hr class="my-4">

                <!-- Section des commentaires -->
                <h3 class="text-lg font-bold">Commentaires</h3>
                @forelse ($post->comments as $comment)
    <div class="my-2">
        <a href="{{ route('profile.show', ['user' => $comment->user]) }}" class="text-blue-500">{{ $comment->user->name }}</a>
        <p>{{ $comment->body }}</p>
    </div>
@empty
    <p>Aucun commentaire pour l'instant.</p>
@endforelse

                <!-- Formulaire pour ajouter un commentaire -->
                <form method="POST" action="{{ route('comments.store', $post) }}">
                            @csrf
                                <textarea name="body" class="w-full border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring-blue-500 transition mb-4" rows="3" placeholder="Ajouter un commentaire..."></textarea>
                                <x-primary-button type="submit" >Commenter</x-primary-button>
                        </form>
            </div>
        </div>
    </div>
</x-app-layout>
