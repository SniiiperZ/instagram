<x-app-layout>
    {{-- Début de la section d'en-tête --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Mon profil') }}
        </h2>
    </x-slot>
    {{-- Fin de la section d'en-tête --}}

    {{-- Début de la section principale --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            {{-- Formulaire de mise à jour des informations du profil --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Formulaire de mise à jour du mot de passe --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Formulaire de suppression de l'utilisateur --}}
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
    {{-- Fin de la section principale --}}
</x-app-layout>
