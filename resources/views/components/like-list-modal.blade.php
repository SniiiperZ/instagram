<!-- Modal pour affichage des likes -->
<div 
    x-show="open" 
    class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50" 
    @click.away="open = false" 
    style="display: none;"
>
    <div 
        @click.away="open = false" 
        class="bg-white rounded-lg shadow-lg w-1/3 p-4"
    >
        <h2 class="text-lg font-semibold mb-4">Aimé par</h2>
        
        <!-- List des utilisateurs qui ont liké le post -->
        <ul>
            @foreach ($post->likes as $like)
                <li class="mb-2">
                    <a href="{{ route('profile.show', $like) }}" class="text-blue-500">{{ $like->name }}</a>
                </li>
            @endforeach
        </ul>

        <x-danger-button @click="open = false">Fermer</x-danger-button>
    </div>
</div>
