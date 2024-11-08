<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex">
                {{-- Logo de l'application --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('posts.index') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                {{-- Liens de navigation principaux --}}
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    @auth
                        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                            {{ __('Publications') }}
                        </x-nav-link>
                        <x-nav-link :href="route('feed.index')" :active="request()->routeIs('feed.index')">
                            {{ __('Top publications') }}
                        </x-nav-link>
                        <x-nav-link :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                            {{ __('Créer une publication') }}
                        </x-nav-link>
                        <x-nav-link :href="route('stories.index')" :active="request()->routeIs('stories.index')">
                            {{ __('Stories') }}
                        </x-nav-link>
                    @else
                        <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                            {{ __('Publications') }}
                        </x-nav-link>
                    @endauth
                </div>
            </div>

            {{-- Menu déroulant utilisateur --}}
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            @auth
                                <div>{{ Auth::user()->name }}</div>
                            @else
                                <div>{{ __('Guest') }}</div>
                            @endauth
                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @auth
                            <x-dropdown-link :href="route('profile.show', Auth::user()->id)">
                                {{ __('Mon profil') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('messages.index')">
                                {{ __('Messages') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Paramètres') }}
                            </x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Déconnexion') }}
                                </x-dropdown-link>
                            </form>
                        @else
                            <x-dropdown-link :href="route('login')">
                                {{ __('Se connecter') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('register')">
                                {{ __('S\'inscrire') }}
                            </x-dropdown-link>
                        @endauth
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Bouton de menu pour les petits écrans --}}
            <div class="sm:hidden flex items-center">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu déroulant pour les petits écrans --}}
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @auth
                <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                    {{ __('Publications') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('feed.index')" :active="request()->routeIs('feed.index')">
                    {{ __('Top publications') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('posts.create')" :active="request()->routeIs('posts.create')">
                    {{ __('Créer une publication') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('stories.index')" :active="request()->routeIs('stories.index')">
                    {{ __('Stories') }}
                </x-responsive-nav-link>
            @else
                <x-responsive-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.index')">
                    {{ __('Publications') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        {{-- Informations utilisateur et liens supplémentaires --}}
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                @auth
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                @else
                    <div class="font-medium text-base text-gray-800">{{ __('Guest') }}</div>
                @endauth
            </div>

            <div class="mt-3 space-y-1">
                @auth
                    <x-responsive-nav-link :href="route('profile.show', Auth::user()->id)">
                        {{ __('Mon profil') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Paramètres') }}
                    </x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Déconnexion') }}
                        </x-responsive-nav-link>
                    </form>
                @else
                    <x-responsive-nav-link :href="route('login')">
                        {{ __('Se connecter') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('register')">
                        {{ __('S\'inscrire') }}
                    </x-responsive-nav-link>
                @endauth
            </div>
        </div>
    </div>
</nav>
