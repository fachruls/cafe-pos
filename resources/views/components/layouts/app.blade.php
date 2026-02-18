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

    {{ $slot }}

</body>
</html>