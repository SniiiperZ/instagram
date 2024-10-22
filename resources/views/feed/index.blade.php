<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Your Feed') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-10">
                <form action="{{ route('search') }}" method="GET" class="flex items-center">
                <input type="text" name="query" placeholder="Rechercher des utilisateurs ou des publications" class="border rounded-md p-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Rechercher</button>
            </form>
            <!-- Section des publications des utilisateurs suivis -->
            <h3 class="font-bold text-lg mb-4">Posts from people you follow</h3>
            @if($followedPosts->isEmpty())
                <p>You are not following anyone yet.</p>
            @else
                @foreach ($followedPosts as $post)
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="font-bold text-lg">
                                <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500">{{ $post->user->name }}</a>
                            </h3>
                            <p class="text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            <a href="{{ route('posts.show', $post) }}">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto rounded-lg">
                            </a>
                            <a href="{{ route('posts.show', $post) }}">
                                <p>{{ $post->caption }}</p>
                            </a>
                            <!-- Afficher le nombre de likes -->
<p>{{ $post->likes()->count() }} Likes</p>

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
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Section des posts les plus likés -->
            <h3 class="font-bold text-lg mb-4">Most liked posts</h3>
            @foreach ($topLikedPosts as $post)
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="font-bold text-lg">
                            <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500">{{ $post->user->name }}</a>
                        </h3>
                        <p class="text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                        <a href="{{ route('posts.show', $post) }}">
                            <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-auto rounded-lg">
                        </a>
                        <a href="{{ route('posts.show', $post) }}">
                            <p>{{ $post->caption }}</p>
                        </a>
                        <!-- Afficher le nombre de likes -->
<p>{{ $post->likes()->count() }} Likes</p>

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
<!-- Afficher les commentaires -->
                            @foreach ($post->comments as $comment)
                                <div class="mt-4">
                                    <p class="font-bold">{{ $comment->user->name }}:</p>
                                    <p>{{ $comment->body }}</p>
                                </div>
                            @endforeach
                        <!-- Formulaire pour ajouter un commentaire -->
                        <form method="POST" action="{{ route('comments.store', $post) }}">
                            @csrf
                                <textarea name="body" class="w-full" rows="3" placeholder="Add a comment..."></textarea>
                                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Comment</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
