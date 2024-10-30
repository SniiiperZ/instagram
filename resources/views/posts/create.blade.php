<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Créer une publication') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto py-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Image Upload with Preview -->
                    <div class="mb-6 text-center">
                        <x-input-label for="image" :value="__('Image')" />
                        <input type="file" id="image" name="image" class="block mt-1 w-full" accept="image/*" required onchange="previewImage(event)" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />

                        <!-- Image Preview -->
                        <div class="mt-4">
                            <img id="imagePreview" class="hidden mx-auto max-w-xs h-48 object-cover rounded-lg" />
                        </div>
                    </div>

                    <!-- Caption -->
                    <div class="mb-4">
                        <x-input-label for="caption" :value="__('Légende')" />
                        <textarea id="caption" name="caption" class="block mt-1 w-full rounded-md border-gray-300" rows="3" placeholder="Ecrire une légende..."></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('caption')" />
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center justify-center mt-6">
                        <x-primary-button>
                            {{ __('Publier') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- JavaScript to handle image preview -->
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
