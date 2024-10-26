<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Bienvenue</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 dark:bg-gray-900">
    <div class="flex flex-col items-center justify-center min-h-screen">
        <!-- Logo -->
        <div class="mb-12">
            <img src="{{ asset('images/logo.png') }}" alt="Mon Logo" class="h-20 w-auto">
        </div>

        <!-- Boutons d'action -->
        @if (Route::has('login'))
            <div class="space-x-4">
                @auth
                    <a href="{{ url('/dashboard') }}" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring focus:ring-blue-300 transition">
                        Accueil
                    </a>
                @else
                    <a href="{{ route('login') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring focus:ring-green-300 transition">
                        Se connecter
                    </a>
                    
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 focus:ring focus:ring-gray-300 transition">
                            S'inscrire
                        </a>
                    @endif
                @endauth
            </div>
        @endif

    </div>
</body>
</html>
