<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Kafe POS System' }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
    
    @if (session()->has('success'))
        <div class="bg-green-500 text-white text-center p-3 fixed top-0 w-full z-50">
            {{ session('success') }}
        </div>
    @endif

    
    @auth
    <nav class="bg-gray-800 shadow-md text-white">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between h-16 items-center">
                
                <div class="flex space-x-6 items-center">
                    <span class="font-bold text-xl text-blue-400">POS Master</span>
                    <a href="{{ route('pos.index') }}" class="hover:text-blue-300 font-medium transition">💻 Layar Kasir</a>
                    
                    
                    @if(auth()->user()->username === 'admin')
                        <a href="{{ route('products.index') }}" class="hover:text-blue-300 font-medium transition">📦 Gudang Menu</a>
                    @endif
                </div>

                
                <div class="flex items-center space-x-4">
                    <span class="text-sm text-gray-300">👋 Halo, {{ auth()->user()->name }}</span>
                    <a href="{{ route('logout') }}" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-bold shadow transition">Keluar Sistem</a>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    
    <main class="py-4">
        {{ $slot }}
    </main>

</body>
</html>