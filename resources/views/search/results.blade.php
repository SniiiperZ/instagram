<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Résultats de recherche pour "{{ $query }}"
        </h2>
    </x-slot>


<div class="container mx-auto py-4">
    <div class="py-12">
        <h2 class="text-xl font-bold">Résultats de recherche pour "{{ $query }}"</h2>
        <form action="{{ route('search') }}" method="GET" class="flex items-center">
        <input type="text" name="query" placeholder="Rechercher des utilisateurs ou des publications" class="border rounded-md p-2">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Rechercher</button>
    </form>

    <div class="mt-6">
        <h3 class="text-lg font-bold">Utilisateurs</h3>
        <div class="grid grid-cols-3 gap-4">
            @forelse ($users as $user)
                <div class="border rounded-lg p-4">
                    <a href="{{ route('profile.show', $user->id) }}">
                        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default-avatar.png' }}" alt="{{ $user->name }}" class="w-16 h-16 rounded-full">
                        <p>{{ $user->name }}</p>
                    </a>
                </div>
            @empty
                <p>Aucun utilisateur trouvé.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">
        <h3 class="text-lg font-bold">Publications</h3>
        <div class="grid grid-cols-3 gap-4">
            @forelse ($posts as $post)
                <div class="border rounded-lg p-4">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <h2 class="text-lg font-bold">{{ $post->user->name }}</h2>
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}">
                        <p>{{ $post->caption }}</p>
                    </a>
                </div>
            @empty
                <p>Aucun post trouvé.</p>
            @endforelse
        </div>
    </div>
</div>
</x-app-layout>