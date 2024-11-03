<x-app-layout>
    {{-- Début de la section d'en-tête --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Créer une publication') }}
        </h2>
    </x-slot>
    {{-- Fin de la section d'en-tête --}}

    {{-- Conteneur principal --}}
    <div class="max-w-4xl mx-auto py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                {{-- Formulaire de création de publication --}}
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf {{-- Protection contre les attaques CSRF --}}

                    {{-- Champ de téléchargement d'image --}}
                    <div class="mb-6 text-center">
                        <x-input-label for="image" :value="__('Image')" />
                        <input type="file" id="image" name="image" class="block mt-1 w-full" accept="image/*" required onchange="previewImage(event)" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />

                        {{-- Prévisualisation de l'image téléchargée --}}
                        <div class="mt-4">
                            <img id="imagePreview" class="hidden mx-auto max-w-xs h-48 object-cover rounded-lg" />
                        </div>
                    </div>

                    {{-- Champ de texte pour la légende --}}
                    <div class="mb-4">
                        <x-input-label for="caption" :value="__('Légende')" />
                        <textarea id="caption" name="caption" class="block mt-1 w-full rounded-md border-gray-300" rows="3" placeholder="Ecrire une légende..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('caption')" />
                    </div>

                    {{-- Bouton de soumission du formulaire --}}
                    <div class="flex items-center justify-center mt-6">
                        <x-primary-button>
                            {{ __('Publier') }}
                        </x-primary-button>
                    </div>
                </form>
                {{-- Fin du formulaire --}}
            </div>
        </div>
    </div>
    {{-- Fin du conteneur principal --}}

    {{-- Script pour la prévisualisation de l'image --}}
    <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('imagePreview');
                output.src = reader.result;
                output.classList.remove('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</x-app-layout>
