<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Stories') }}
        </h2>
    </x-slot>

    <!-- Story Upload Form -->
    <div class="max-w-4xl mx-auto py-6">
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 text-center max-w-md mx-auto md:max-w-lg py-6">
            <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center space-y-4">
                @csrf
                <input type="file" name="media" required class="block w-full text-sm text-gray-600 bg-gray-100 border border-gray-300 rounded-md p-2 cursor-pointer">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors duration-200">
                    Ajouter une storie
                </button>
            </form>
        </div>

        <!-- Story Display Section -->
        <div class="container mx-auto py-8 px-4">
            @if($stories->isEmpty())
            <p class="text-center text-gray-500">No stories available</p>
            @else
            <div class="flex space-x-4 overflow-x-auto pb-4 mb-8 max-w-full">
                @foreach($stories->sortByDesc('created_at') as $story)
                <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story image"
                     class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-40 lg:h-40 object-cover rounded-full border-2 border-blue-500 cursor-pointer"
                     onclick="openModal('{{ asset('storage/' . $story->media_path) }}', '{{ $story->user->name }}', '{{ $story->created_at->diffForHumans() }}')">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Modal -->
        <div id="storyModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden" onclick="closeModal()">
            <div class="bg-white p-6 rounded-lg relative max-w-xs w-full sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto" onclick="event.stopPropagation()">
            <button onclick="closeModal()" class="absolute top-2 right-2  hover:text-red-700 transition duration-200">X</button>
            <img id="modalImage" src="" alt="Story image" class="w-full h-auto mb-4 max-h-72 object-contain rounded-md">
            <p id="modalUser" class="text-center text-gray-800 font-semibold text-lg"></p>
            <p id="modalCreated" class="text-center text-gray-500 text-sm mt-1"></p>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        function openModal(imageSrc, userName, createdAt) {
            document.getElementById('modalImage').src = imageSrc;
            document.getElementById('modalUser').innerText = userName;
            document.getElementById('modalCreated').innerText = createdAt;
            document.getElementById('storyModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('storyModal').classList.add('hidden');
        }
    </script>
</x-app-layout>
