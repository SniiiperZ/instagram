<section>
    <header>
        {{-- Titre de la section --}}
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Informations sur le profil') }}
        </h2>

        {{-- Description de la section --}}
        <p class="mt-1 text-sm text-gray-600">
            {{ __("Mettez à jour les informations de profil et l'adresse électronique de votre compte.") }}
        </p>
    </header>

    {{-- Formulaire pour envoyer la vérification de l'email --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    {{-- Formulaire pour mettre à jour le profil --}}
    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        {{-- Champ pour le nom --}}
        <div>
            <x-input-label for="name" :value="__('Nom')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Champ pour l'email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Vérification de l'email --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Votre adresse email n\'est pas vérifiée.') }}

                        {{-- Bouton pour renvoyer l'email de vérification --}}
                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Cliquez ici pour renvoyer l\'email de vérification.') }}
                        </button>
                    </p>

                    {{-- Message de confirmation de l'envoi du lien de vérification --}}
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Un nouveau lien de vérification a été envoyé à votre adresse email.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Champ pour la bio --}}
        <div>
            <x-input-label for="bio" :value="__('Bio')" />
            <textarea id="bio" name="bio" class="mt-1 block w-full" rows="3">{{ old('bio', $user->bio) }}</textarea>
            <x-input-error class="mt-2" :messages="$errors->get('bio')" />
        </div>

        {{-- Champ pour la photo de profil --}}
        <div>
            <x-input-label for="profile_photo" :value="__('Photo de profil')" />
            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" class="mt-1 block w-full" />

            {{-- Affichage de la photo de profil actuelle --}}
            @if ($user->profile_photo)
                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil" class="mt-2 w-20 h-20 rounded-full">
            @endif
            <x-input-error class="mt-2" :messages="$errors->get('profile_photo')" />
        </div>

        {{-- Bouton de sauvegarde et message de confirmation --}}
        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Enregistrer') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Enregistré.') }}</p>
            @endif
        </div>
    </form>
</section>
