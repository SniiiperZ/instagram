<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
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

                <hr class="my-4">

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
                </form>

                <hr class="my-4">

                <!-- Section des commentaires -->
                <h3 class="text-lg font-bold">Commentaires</h3>
                @forelse ($post->comments as $comment)
                    <div class="my-2">
                        <a href="{{ route('profile.show', $comment->user) }}" class="text-blue-500">{{ $comment->user->name }}</a>
                        <p>{{ $comment->body }}</p>
                    </div>
                @empty
                    <p>Aucun commentaire pour l'instant.</p>
                @endforelse

                <!-- Formulaire pour ajouter un commentaire -->
                <form method="POST" action="{{ route('comments.store', $post) }}">
                            @csrf
                                <textarea name="body" class="w-full" rows="3" placeholder="Add a comment..."></textarea>
                                <button type="submit" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Comment</button>
                        </form>
            </div>
        </div>
    </div>
</x-app-layout>
