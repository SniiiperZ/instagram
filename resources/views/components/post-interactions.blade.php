{{-- resources/views/components/post-interactions.blade.php --}}
<div x-data="{ open: false }">
    {{-- Bouton pour voir le nombre de likes et modal pour voir les utilisateurs ayant aimé --}}
    <div class="flex items-center space-x-4 mb-4">
        <p class="text-gray-600 font-bold cursor-pointer" @click="open = true">
            {{ $post->likes()->count() }} Likes
        </p>

        {{-- Bouton like/unlike --}}
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
        <form method="POST" action="{{ route('posts.share', $post) }}">
    @csrf
    <x-secondary-button onclick="return confirm('Tu es sûre de vouloir partager cette publication?')">
        {{ __('Partage') }}
    </x-secondary-button>
</form>
    </div>

    {{-- Modal affichant les utilisateurs ayant aimé la publication --}}
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
            <x-danger-button @click="open = false">Fermer</x-danger-button>
        </div>
    </div>
</div>
