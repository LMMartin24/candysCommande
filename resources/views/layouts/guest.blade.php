<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Candys – Connexion</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Archivo+Black&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-page font-sans">
    <div class="w-full max-w-sm px-4">
        <div class="text-center mb-8">
            <h1 class="font-titan font-black uppercase tracking-widest text-dark"
                style="font-size: clamp(2rem, 10vw, 3rem);">Candys</h1>
            <p class="text-xs font-black uppercase tracking-[0.3em] text-gray-400 mt-1">Point de vente</p>
        </div>
        <div class="bg-white border-4 border-dark rounded-3xl shadow-[6px_6px_0_#231F20] p-8">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
