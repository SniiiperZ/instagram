@props(['post'])

<div class="relative bg-white p-6 rounded-lg shadow-lg mb-6">
    {{-- Afficher le bouton de suppression si l'utilisateur est le propriétaire du post --}}
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

    {{-- Afficher les informations de l'utilisateur et la date de création du post --}}
    <div class="flex items-center space-x-4 mb-4">
        <img src="{{ $post->user->profile_photo ? asset('storage/' . $post->user->profile_photo) : 'default-avatar.jpg' }}" alt="Profile Photo" class="w-10 h-10 rounded-full">
        <h3 class="font-bold text-lg">
            <a href="{{ route('profile.show', $post->user) }}" class="text-blue-500 hover:underline">{{ $post->user->name }}</a>
        </h3>
        <span class="text-gray-400 text-sm">{{ $post->created_at->diffForHumans() }}</span>
    </div>

    {{-- Afficher l'image du post --}}
    <a href="{{ route('posts.show', $post) }}">
        <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="w-full h-80 object-cover rounded-lg mb-4">
    </a>

    {{-- Afficher la légende du post --}}
    <p class="text-gray-700 mb-4">{{ $post->caption }}</p>

    <hr class="my-4">

    {{-- Section pour les boutons de like et la liste des likes --}}
    <div x-data="{ open: false }">
        <x-like-button :post="$post" />
        <x-like-list-modal :post="$post" />
    </div>

    <hr class="my-4">

    {{-- Afficher les commentaires du post --}}
    <h3 class="text-lg font-bold">Commentaires</h3>
    @foreach ($post->comments as $comment)
        <div class="mt-4 border-t border-gray-200 pt-2">
            <a href="{{ route('profile.show', $comment->user) }}" class="text-blue-500 font-semibold">{{ $comment->user->name }}:</a>
            <p class="text-gray-600">{{ $comment->body }}</p>
        </div>
    @endforeach

    {{-- Formulaire pour ajouter un nouveau commentaire --}}
    <form method="POST" action="{{ route('comments.store', $post) }}" class="mt-4">
        @csrf
        <textarea 
            name="body" 
            class="w-full border-gray-300 rounded-md p-2 focus:border-blue-500 focus:ring-blue-500 transition mb-4" 
            rows="2" 
            placeholder="Ajouter un commentaire..."
        ></textarea>
        <x-primary-button type="submit">Commenter</x-primary-button>
    </form>
</div>
