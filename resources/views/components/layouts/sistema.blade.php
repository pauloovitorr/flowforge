<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>


    <main class="min-h-screen bg-gray-100">
        <!-- Sidebar fixo à esquerda -->
        <x-sistema.aside/>

        <!-- Conteúdo principal com margem esquerda -->
        <div class="ml-56 overflow-auto">
            <x-sistema.nav-sistema></x-sistema.nav-sistema>
            
            <div class="w-[96%] p-6 max-w-7xl mx-auto bg-white rounded-lg">
                {{ $slot }}
            </div>

        </div>
    </main>



    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>