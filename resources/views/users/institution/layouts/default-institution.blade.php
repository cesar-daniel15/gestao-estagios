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

    <body class="bg-gray-100 relative overflow-auto">
        <!-- Sidebar -->
        @if ($showSidebar ?? true)
            @include('users.institution.layouts.components.sidebar')
        @endif   
        <!-- Conteudo -->
        <main class="m-7 mt-[80px] md:m-10 md:ps-10 md:ml-64">
            <!-- Navbar -->
            @if ($showNavbar ?? true)
                @include('users.institution.layouts.components.navbar')
            @endif 
            
            @yield('content')
        </main>    
    </body>
</html>

