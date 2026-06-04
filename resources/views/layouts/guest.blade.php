<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-700 antialiased bg-gray-50">
<x-navbar />

<main class="mx-auto w-full max-w-6xl px-6 sm:px-10 py-8">
    {{ $slot }}
</main>

<div id="lb-overlay"
     class="hidden fixed inset-0 z-[100] bg-black/80 backdrop-blur-sm flex items-center justify-center p-3">
    <div class="relative max-h-[90vh] max-w-[95vw]">
        <img id="lb-img" alt=""
             class="max-h-[90vh] max-w-[95vw] object-contain rounded-lg shadow-2xl">
        <button id="lb-close" type="button"
                class="absolute top-3 right-3 rounded-full bg-white/90 px-3 py-1 text-sm">
            Zavrieť
        </button>
    </div>
</div>

<script src="{{ asset('js/lightbox.js') }}" defer></script>
</body>
</html>
