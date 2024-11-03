<x-app-layout>
    {{-- Définition de l'en-tête de la page --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Accueil') }}
        </h2>
    </x-slot>

    {{-- Contenu principal de la page --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Carte blanche avec ombre et coins arrondis --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Message de confirmation de connexion --}}
                <div class="p-6 text-gray-900">
                    {{ __("Vous êtes connecté") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
