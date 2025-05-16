<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Inicio')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- @livewireStyles --}}
</head>
<body class="bg-gradient-to-r from-cyan-500 to-blue-500 min-h-screen">

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-cyan-600/10 to-blue-600/10 text-white shadow-lg" x-data="{ open: false }">
        <div class="container mx-auto p-4 flex justify-between items-center">
            <a href="{{ route('welcome') }}" class="font-bold text-lg">Ignacio Lopez Rayon</a>
            <button class="md:hidden text-2xl focus:outline-none" @click="open = !open">☰</button>

            <div class="hidden md:flex items-center space-x-6">
                @auth
                    <span>Hola, {{ auth()->user()->name }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="underline hover:text-white/50">Cerrar sesión</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:underline">Iniciar sesión</a>
                @endauth
            </div>
        </div>

        {{-- Menú móvil --}}
        <div class="md:hidden px-4 pb-4" x-show="open" x-transition>
            @auth
                <p class="mb-2">Hola, {{ auth()->user()->name }}</p>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="underline hover:text-white/50">Cerrar sesión</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="hover:underline">Iniciar sesión</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>
{{-- @livewireScripts --}}
</body>
</html>
