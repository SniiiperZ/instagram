<section class="space-y-6">
    <header>
        {{-- Titre de la section --}}
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Supprimer le compte') }}
        </h2>

        {{-- Description de la section --}}
        <p class="mt-1 text-sm text-gray-600">
            {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou informations que vous souhaitez conserver.') }}
        </p>
    </header>

    {{-- Bouton pour ouvrir le modal de confirmation de suppression --}}
    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Supprimer le compte') }}</x-danger-button>

    {{-- Modal de confirmation de suppression --}}
    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            {{-- Titre du modal --}}
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Êtes-vous sûr de vouloir supprimer votre compte ?') }}
            </h2>

            {{-- Description du modal --}}
            <p class="mt-1 text-sm text-gray-600">
                {{ __('Une fois votre compte supprimé, toutes ses ressources et données seront définitivement effacées. Veuillez saisir votre mot de passe pour confirmer que vous souhaitez supprimer définitivement votre compte.') }}
            </p>

            {{-- Champ de saisie du mot de passe --}}
            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Mot de passe') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-3/4"
                    placeholder="{{ __('Mot de passe') }}"
                />

                {{-- Affichage des erreurs de validation pour le mot de passe --}}
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            {{-- Boutons d'action --}}
            <div class="mt-6 flex justify-end">
                {{-- Bouton pour fermer le modal --}}
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Annuler') }}
                </x-secondary-button>

                {{-- Bouton pour confirmer la suppression du compte --}}
                <x-danger-button class="ms-3">
                    {{ __('Supprimer le compte') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
