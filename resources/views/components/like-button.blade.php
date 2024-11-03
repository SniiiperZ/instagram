<div class="flex items-center space-x-4 mb-4">
    <!-- Affiche le nombre de likes et ouvre une modal au clic -->
    <p class="text-gray-600 font-bold cursor-pointer" @click="open = true">
        {{ $post->likes()->count() }} Likes
    </p>
    
    <!-- Vérifie si l'utilisateur actuel a déjà liké le post -->
    @if ($post->likes()->where('user_id', auth()->id())->exists())
        <!-- Formulaire pour dislike le post -->
        <form method="POST" action="{{ route('posts.unlike', $post) }}">
            @csrf
            <x-danger-button>Dislike</x-danger-button>
        </form>
    @else
        <!-- Formulaire pour liker le post -->
        <form method="POST" action="{{ route('posts.like', $post) }}">
            @csrf
            <x-primary-button>Like</x-primary-button>
        </form>
    @endif
</div>
