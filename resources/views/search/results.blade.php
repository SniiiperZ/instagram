<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            Résultats de recherche pour "{{ $query }}"
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-6">

            <!-- Search Bar -->
            <form action="{{ route('search') }}" method="GET" class="flex items-center justify-center mb-8">
                <input type="text" name="query" value="{{ $query }}" placeholder="Rechercher des utilisateurs ou des publications"
                       class="border rounded-md p-2 w-1/2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md ml-2">Rechercher</button>
            </form>

            <!-- Users Results -->
            <div class="mt-6">
                <h3 class="text-lg font-bold text-center mb-4">Utilisateurs</h3>
                <div class="grid grid-cols-3 gap-4">
                    @forelse ($users as $user)
                        <div class="border rounded-lg p-4 flex flex-col items-center">
                            <a href="{{ route('profile.show', $user->id) }}" class="text-center">
                                <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default-avatar.png' }}"
                                     alt="{{ $user->name }}"
                                     class="w-24 h-24 rounded-full mb-2 object-cover">
                                <p class="font-bold">{{ $user->name }}</p>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-3 text-center">Aucun utilisateur trouvé.</p>
                    @endforelse
                </div>
            </div>

            <!-- Posts Results -->
            <div class="mt-6">
                <h3 class="text-lg font-bold text-center mb-4">Publications</h3>
                <div class="grid grid-cols-3 gap-4">
                    @forelse ($posts as $post)
                        <div class="border rounded-lg overflow-hidden">
                            <a href="{{ route('posts.show', $post->id) }}">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}"
                                     class="w-full h-48 object-cover mb-2">
                                <div class="p-2 text-center">
                                    <h2 class="text-lg font-bold">{{ $post->user->name }}</h2>
                                    <p>{{ $post->caption }}</p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="col-span-3 text-center">Aucun post trouvé.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
