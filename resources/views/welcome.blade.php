<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Titre de la page --}}
    <title>Bienvenue</title>

    {{-- Inclusion de la police Figtree --}}
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    
    {{-- Inclusion du fichier CSS compilé par Vite --}}
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center min-h-screen">
        {{-- Logo de l'application --}}
        <div class="mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="Mon Logo" class="h-20 w-auto">
        </div>

        {{-- Vérification de l'existence de la route de connexion --}}
        @if (Route::has('login'))
            <div class="flex flex-col space-y-4 text-center">
                {{-- Si l'utilisateur est authentifié --}}
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 transition">
                        Accueil
                    </a>
                {{-- Si l'utilisateur n'est pas authentifié --}}
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring focus:ring-green-300 transition">
                        Se connecter
                    </a>
                    <a href="{{ route('posts.index') }}" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring focus:ring-gray-300 transition">
                        Continuer en tant qu'invité
                    </a>
                    {{-- Vérification de l'existence de la route d'inscription --}}
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-gray-700 focus:ring focus:ring-gray-300 transition">
                            S'inscrire
                        </a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</body>
</html>
