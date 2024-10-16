<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create a Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Image -->
                    <div class="mb-4">
                        <x-label for="image" :value="__('Image')" />
                        <input type="file" id="image" name="image" class="block mt-1 w-full" required />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>

                    <!-- Légende -->
                    <div class="mb-4">
                        <x-label for="caption" :value="__('Caption')" />
                        <textarea id="caption" name="caption" class="block mt-1 w-full" rows="3"></textarea>
                        <x-input-error class="mt-2" :messages="$errors->get('caption')" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-button class="ml-4">
                            {{ __('Post') }}
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
