<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $user->name }}
        </h2>
    </x-slot>

<div class="container mx-auto py-4">
    <div class="flex items-center">
        <!-- Photo de profil -->
        <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default-avatar.png' }}" alt="Profile Photo" class="w-16 h-16 rounded-full">
        <div class="ml-4">
            <!-- Nom et bio de l'utilisateur -->
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->bio }}</p>

            <!-- Bouton suivre / désabonner -->
            @if (auth()->user()->following->contains($user))
                <form method="POST" action="{{ route('users.unfollow', $user) }}">
                    @csrf
                    <button type="submit" class="text-red-500">Unfollow</button>
                </form>
            @else
                <form method="POST" action="{{ route('users.follow', $user) }}">
                    @csrf
                    <button type="submit" class="text-blue-500">Follow</button>
                </form>
            @endif
        </div>
    </div>

    <!-- Publications de l'utilisateur -->
    <div class="mt-6">
        <h3 class="text-lg font-bold">Publications</h3>
        <div class="grid grid-cols-3 gap-4">
            @foreach ($posts as $post)
                <div class="border rounded-lg p-4">
                    <a href="{{ route('posts.show', $post->id) }}">
                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}">
                        <p>{{ $post->caption }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
</x-app-layout>
