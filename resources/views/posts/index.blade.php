<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-lg text-gray-800 leading-tight">
            {{ __('Feed') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-2">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">
            <form action="{{ route('search') }}" method="GET" class="flex items-center mb-4">
                <input type="text" name="query" placeholder="Rechercher des utilisateurs ou des publications" class="border rounded-md p-2 flex-grow">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Rechercher</button>
            </form>
            
            @foreach ($posts as $post)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-bold text-lg mb-2">
                            <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500">{{ $post->user->name }}</a>
                        </h3>
                        <p class="text-gray-500 mb-4">{{ $post->created_at->diffForHumans() }}</p>

                        <div class="mt-4">
                            <a href="{{ route('posts.show', $post) }}">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-80 object-cover rounded-lg mb-2">
                            </a>
                        </div>
                        
                        @if ($post->caption)
                            <a href="{{ route('posts.show', $post) }}">
                                <p>{{ $post->caption }}</p>
                            </a>
                        @endif
                        
                        <!-- Afficher le nombre de likes -->
                        <p class="font-bold mb-2">{{ $post->likes()->count() }} Likes</p>

                        <!-- Vérifier si l'utilisateur a déjà liké la publication -->
                        @if ($post->likes()->where('user_id', auth()->id())->exists())
                            <!-- Dislike Button -->
                            <form method="POST" action="{{ route('posts.unlike', $post) }}" class="mb-4">
                                @csrf
                                <x-danger-button>
                                    {{ __('Dislike') }}
                                </x-danger-button>
                            </form>
                        @else
                            <!-- Like Button -->
                            <form method="POST" action="{{ route('posts.like', $post) }}" class="mb-4">
                                @csrf
                                <x-primary-button>
                                    {{ __('Like') }}
                                </x-primary-button>
                            </form>
                        @endif

                        <!-- Afficher les commentaires -->
                        @foreach ($post->comments as $comment)
                            <div class="mt-4">
                                <a href="{{ route('profile.show', $comment->user) }}" class="text-blue-500">{{ $comment->user->name }}</a>
                                <p>{{ $comment->body }}</p>
                            </div>
                        @endforeach

                        <!-- Formulaire pour ajouter un commentaire -->
                        <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4">
                            @csrf
                            <textarea name="body" class="w-full" rows="3" placeholder="Add a comment..."></textarea>
                            <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Comment</button>
                        </form>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="mt-4">
                {{ $posts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
