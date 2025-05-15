<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    {{-- Layout con Sidebar --}}
    <div x-data="{ sidebarOpen: window.innerWidth >= 768 }" class="flex flex-col md:flex-row min-h-screen">
        {{-- Sidebar dinámico --}}
        <aside class="w-full md:w-1/4 lg:w-1/5 border-r p-6 "
            x-show="sidebarOpen"
            @resize.window="sidebarOpen = window.innerWidth >= 768"
            x-transition>
            {{-- Contenido dinámico --}}
            @yield('sidebar')
        </aside>

        {{-- Botón para móvil --}}
        <div class="md:hidden p-4">
            <button @click="sidebarOpen = !sidebarOpen" class="bg-blue-600 text-white px-4 py-2 rounded shadow">
                <span x-show="!sidebarOpen">📂 Ver Menú</span>
                <span x-show="sidebarOpen">❌ Cerrar</span>
            </button>
        </div>

        {{-- Contenido --}}
        <main class="flex-1 p-6 bg-white/50">
            @yield('content')
        </main>
    </div>

</body>
</html>
