<x-app-layout>
    {{-- Titre de la page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Top publications') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        {{-- Section de recherche --}}
        <x-search-bar placeholder="Rechercher des utilisateurs ou des publications" />

        {{-- Section pour les publications des personnes suivies --}}
        <div class="space-y-6">
            <h3 class="font-bold text-lg text-green-500 mb-4 text-center">Publications des personnes que vous suivez</h3>
            @if($followedPosts->isEmpty())
                {{-- Message si l'utilisateur ne suit encore personne --}}
                <p class="text-gray-500 text-center">Vous ne suivez encore personne.</p>
            @else
                {{-- Affichage des publications des personnes suivies --}}
                @foreach ($followedPosts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            @endif

            {{-- Section pour les publications les plus appréciées --}}
            <h3 class="font-bold text-lg text-blue-500 mb-4 text-center">Publications les plus appréciées</h3>
            @foreach ($topLikedPosts as $post)
                <x-post-card :post="$post" />
            @endforeach
        </div>
    </div>
</x-app-layout>
