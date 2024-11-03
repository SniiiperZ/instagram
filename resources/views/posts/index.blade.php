<x-app-layout>
    {{-- Titre de la page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Publication') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        {{-- Section de recherche --}}
        <x-search-bar placeholder="Rechercher des utilisateurs ou des publications" />

        {{-- Liste des publications --}}
        <div class="space-y-6">
            @foreach ($posts as $post)
                <x-post-card :post="$post">
                </x-post-card>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
