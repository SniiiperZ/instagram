<x-app-layout>
    {{-- Début de la section d'en-tête --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Stories') }}
        </h2>
    </x-slot>
    {{-- Fin de la section d'en-tête --}}

    <div class="max-w-4xl mx-auto py-6">
        {{-- Formulaire pour ajouter une nouvelle storie --}}
        <div class="bg-white p-6 rounded-lg shadow-md mb-8 text-center max-w-md mx-auto md:max-w-lg py-6">
            <form action="{{ route('stories.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center space-y-4">
                @csrf
                {{-- Champ pour télécharger une image --}}
                <input type="file" name="media" accept="image/*" required class="block w-full text-sm text-gray-600 bg-gray-100 border border-gray-300 rounded-md p-2 cursor-pointer">
                {{-- Bouton pour soumettre le formulaire --}}
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600 transition-colors duration-200">
                    Ajouter une storie
                </button>
            </form>
        </div>
        {{-- Fin du formulaire --}}

        {{-- Section pour afficher les stories --}}
        <div class="container mx-auto py-8 px-4">
            @if($stories->isEmpty())
                {{-- Message si aucune storie n'est disponible --}}
                <p class="text-center text-gray-500">Aucune storie disponible</p>
            @else
                {{-- Liste des stories --}}
                <div class="flex space-x-4 overflow-x-auto pb-4 mb-8 max-w-full">
                    @foreach($stories->sortByDesc('created_at') as $story)
                        {{-- Image de la storie avec un événement onclick pour ouvrir le modal --}}
                        <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story image"
                             class="w-24 h-24 sm:w-28 sm:h-28 md:w-32 md:h-32 lg:w-40 lg:h-40 object-cover rounded-full border-2 border-blue-500 cursor-pointer"
                             onclick="openModal('{{ asset('storage/' . $story->media_path) }}', '{{ $story->user->name }}', '{{ $story->created_at->diffForHumans() }}')">
                    @endforeach
                </div>
            @endif
        </div>
        {{-- Fin de la section des stories --}}

        {{-- Modal pour afficher les détails de la storie --}}
        <div id="storyModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden" onclick="closeModal()">
            <div class="bg-white p-6 rounded-lg relative max-w-xs w-full sm:max-w-md md:max-w-lg lg:max-w-xl mx-auto" onclick="event.stopPropagation()">
                {{-- Bouton pour fermer le modal --}}
                <button onclick="closeModal()" class="absolute top-2 right-2 hover:text-red-700 transition duration-200">X</button>
                {{-- Image de la storie dans le modal --}}
                <img id="modalImage" src="" alt="Story image" class="w-full h-auto mb-4 max-h-72 object-contain rounded-md">
                {{-- Nom de l'utilisateur ayant posté la storie --}}
                <p id="modalUser" class="text-center text-gray-800 font-semibold text-lg"></p>
                {{-- Date de création de la storie --}}
                <p id="modalCreated" class="text-center text-gray-500 text-sm mt-1"></p>
            </div>
        </div>
        {{-- Fin du modal --}}
    </div>

    {{-- Scripts JavaScript pour gérer l'ouverture et la fermeture du modal --}}
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
