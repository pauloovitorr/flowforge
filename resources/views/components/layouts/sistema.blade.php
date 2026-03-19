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
        <x-sistema.nav-sistema></x-sistema.nav-sistema>
    </header>

    <main class="border-2 border-red-500">
        <x-sistema.aside></x-sistema.aside>
        {{ $slot }}
    </main>

  

</body>