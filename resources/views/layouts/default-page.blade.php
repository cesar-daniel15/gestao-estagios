<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @vite('resources/css/app.css')

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

        <!-- Styles -->

    </head>

    <body class="bg-gray-100 min-h-screen flex flex-col">  
        <!-- Navbar -->
        @if ($showNavbar ?? true)
            @include('layouts.components.navbar')
        @endif 
        <!-- Conteudo -->           
        <main class="flex-grow">
            @yield('content')
        </main> 
        <!-- Footer -->
        @if ($showFooter ?? true)
            @include('layouts.components.footer')
        @endif    
    </body>
</html>
