<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="flex flex-col items-center">
            <!-- Profile Photo -->
            <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default-avatar.png' }}" 
                 alt="Profile Photo" 
                 class="w-24 h-24 rounded-full mb-4">

            <!-- User Name and Bio -->
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-600 mb-4">{{ $user->bio }}</p>

            <!-- Follow/Unfollow Button -->
            <div class="mb-4">
                @if (auth()->user()->following->contains($user))
                    <form method="POST" action="{{ route('users.unfollow', $user) }}">
                        @csrf
                        <x-danger-button>Unfollow</x-danger-button>
                    </form>
                @else
                    <form method="POST" action="{{ route('users.follow', $user) }}">
                        @csrf
                        <x-primary-button>Follow</x-primary-button>
                    </form>
                @endif
            </div>
        </div>

        <!-- User Posts -->
        <div class="mt-8">
            <h3 class="text-lg font-bold text-center mb-6">Publications</h3>
            <div class="grid grid-cols-3 gap-4">
                @foreach ($posts as $post)
                    <div class="border rounded-lg overflow-hidden">
                        <a href="{{ route('posts.show', $post->id) }}">
                            <!-- Ensure all images are the same size using object-fit -->
                            <img src="{{ asset('storage/' . $post->image) }}" 
                                 alt="{{ $post->caption }}" 
                                 class="w-full h-48 object-cover">
                            <p class="p-2 text-center">{{ $post->caption }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
