<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>

    <header class="h-20 shadow-sm bg-white flex items-center">
        <x-nav></x-nav>
    </header>

    <main class="w-[98%] max-w-7xl mx-auto">
        {{ $slot }}
    </main>

  

</body>