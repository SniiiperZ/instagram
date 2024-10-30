<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ $user->name }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <div class="flex flex-col items-center">
    <!-- Profile Photo -->
    <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'default-avatar.jpg' }}" alt="Profile Photo" class="w-24 h-24 rounded-full mb-4">
    <!-- User Name and Bio -->
    <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
    <p class="text-gray-600 mb-4">{{ $user->bio }}</p>
    
    <div x-data="{ openFollowers: false, openFollowing: false }" class="flex mb-4">
    <!-- Following Count -->
    <p class="flex items-center mr-6"> <!-- Add margin-right here -->
        <span>
            <span @click="openFollowing = true" class="cursor-pointer text-blue-500">
                {{ $user->following()->count() }} Following
            </span>
            <div x-show="openFollowing" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" style="display: none;">
                <div @click.away="openFollowing = false" class="bg-white rounded-lg shadow-lg w-1/3 p-4">
                    <h2 class="text-lg font-semibold mb-4">Following</h2>
                    <ul>
                        @foreach ($user->following as $following)
                            <li class="mb-2">
                                <a href="{{ route('profile.show', $following) }}" class="text-blue-500">{{ $following->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <x-danger-button @click="openFollowing = false">Fermer</x-danger-button>
                </div>
            </div>
        </span>
    </p>

    <!-- Follower Count -->
    <p class="flex items-center">
        <span>
            <span @click="openFollowers = true" class="cursor-pointer text-blue-500">
                {{ $user->followers()->count() }} Follower{{ $user->followers()->count() !== 1 ? 's' : '' }}
            </span>
            <div x-show="openFollowers" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50" style="display: none;">
                <div @click.away="openFollowers = false" class="bg-white rounded-lg shadow-lg w-1/3 p-4">
                    <h2 class="text-lg font-semibold mb-4">Followers</h2>
                    <ul>
                        @foreach ($user->followers as $follower)
                            <li class="mb-2">
                                <a href="{{ route('profile.show', $follower) }}" class="text-blue-500">{{ $follower->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                    <x-danger-button @click="openFollowers = false" >Fermer</x-danger-button>
                </div>
            </div>
        </span>
    </p>
</div>


<!-- Follow/Unfollow and Message Buttons -->
<div class="flex space-x-4 mb-4">
    <!-- Follow/Unfollow Button -->
    <div>
        @if (auth()->id() !== $user->id)
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
        @endif
    </div>

    <!-- Message Button -->
    <div>
        @if (auth()->id() !== $user->id)
            <a href="{{ route('messages.chat', ['user' => $user->id]) }}">
                <x-primary-button>Message</x-primary-button>
            </a>
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
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->caption }}" class="w-full h-48 object-cover">
                            <p class="p-2 text-center">{{ $post->caption }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
