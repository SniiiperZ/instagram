<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ $post->caption }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-4">
        <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md">
            {{-- Image de la publication --}}
            <x-post-image :image="$post->image" />

            <div class="p-4">
                {{-- Informations sur l'utilisateur et la description --}}
                <x-post-header :user="$post->user" :caption="$post->caption" />

                {{-- Bouton de suppression (si l'utilisateur est propriétaire de la publication) --}}
                @if (auth()->id() === $post->user_id)
                    <x-delete-post-button :post="$post" />
                @endif

                <hr class="my-4">

                {{-- Boutons "Like", "Dislike" et "Partage" --}}
                <x-post-interactions :post="$post" />

                <hr class="my-4">

                {{-- Liste des commentaires --}}
                <h3 class="text-lg font-bold">Commentaires</h3>
                <x-comments-list :comments="$post->comments" />

                {{-- Formulaire d'ajout de commentaire --}}
                <x-add-comment-form :post="$post" />
            </div>
        </div>
    </div>
</x-app-layout>
