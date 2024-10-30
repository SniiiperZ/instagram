<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Publication') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
    <!-- Formulaire de recherche -->
    <div class="bg-white p-6 rounded-lg shadow-md mb-8">
        <form action="{{ route('search') }}" method="GET" class="flex items-center space-x-2">
            <input 
                type="text" 
                name="query" 
                placeholder="Rechercher des utilisateurs ou des publications" 
                class="border-gray-300 rounded-md p-2 w-full focus:border-blue-500 focus:ring-blue-500 transition"
            >
            <button 
                type="submit" 
                class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
            >
                Rechercher
            </button>
        </form>
    </div>

    <!-- Section des posts -->
    <div class="space-y-6">
        @foreach ($posts as $post)
            <div class="bg-white p-6 rounded-lg shadow-lg mb-6 relative"> <!-- Add relative class here -->
                @if (auth()->id() === $post->user_id)
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" onsubmit="return confirm('Tu es sûre de vouloir supprimer cette publication?');" class="absolute top-4 right-4">
    @csrf
    @method('DELETE')
    <button type="submit" class="text-red-500 hover:text-red-700">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
</form>

                @endif
                <!-- Rest of the post content goes here -->

                    <!-- Informations de l'utilisateur et date -->
                    <div class="flex items-center space-x-4 mb-4">
                        <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'default-avatar.jpg' }}" alt="Profile Photo" class="w-10 h-10 rounded-full">
                        <h3 class="font-bold text-lg">
                            <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500 hover:underline">{{ $post->user->name }}</a>
                        </h3>
                        <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                    </div>

                    <!-- Image du post -->
                    <a href="{{ route('posts.show', $post) }}">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-80 object-cover rounded-lg mb-4">
                    </a>

                    <!-- Caption du post -->
                    @if ($post->caption)
                        <a href="{{ route('posts.show', $post) }}">
                            <p class="text-gray-700 mb-4">{{ $post->caption }}</p>
                        </a>
                    @endif

<div x-data="{ open: false }"> <!-- Initialisation de Alpine.js -->
    <!-- Likes et bouton de like/dislike -->
    <div class="flex items-center space-x-4 mb-4">
        <!-- Compteur de likes avec un clic pour afficher la modale -->
        <p class="text-gray-600 font-bold cursor-pointer" @click="open = true">
            {{ $post->likes()->count() }} Likes
        </p>

        <!-- Bouton de like/dislike -->
        @if ($post->likes()->where('user_id', auth()->id())->exists())
            <form method="POST" action="{{ route('posts.unlike', $post) }}">
                @csrf
                <x-danger-button>
                    {{ __('Dislike') }}
                </x-danger-button>
            </form>
        @else
            <form method="POST" action="{{ route('posts.like', $post) }}">
                @csrf
                <x-primary-button>
                    {{ __('Like') }}
                </x-primary-button>
            </form>
        @endif
    </div>

    <!-- Modale cachée par défaut, visible quand `open` est vrai -->
    <div x-show="open" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" @click.away="open = false" style="display: none;">
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




                    <!-- Commentaires du post -->
                    @foreach ($post->comments as $comment)
                        <div class="mt-4 border-t border-gray-200 pt-2">
                            <a href="{{ route('profile.show', $comment->user) }}" class="text-blue-500 font-semibold">{{ $comment->user->name }}:</a>
                            <p class="text-gray-600">{{ $comment->body }}</p>
                        </div>
                    @endforeach

                    <!-- Formulaire pour ajouter un commentaire -->
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4">
                        @csrf
                        <textarea 
                            name="body" 
                            class="w-full border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring-blue-500 transition mb-4" 
                            rows="2" 
                            placeholder="Ajouter un commentaire..."
                        ></textarea>
                        <x-primary-button 
                            type="submit" 
                            
                        >
                            Commenter
                        </x-primary-button>
                    </form>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
