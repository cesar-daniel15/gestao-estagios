@php
    $responsible = Auth::user()->responsible;
@endphp

<!-- Navbar -->
<nav class="flex justify-between items-center">
    <!-- Nome da Página -->
    <div class="text-md font-bold text-gray-500">
        @yield('page-name')
    </div>

    <!-- User Info -->
    <div class="hidden md:flex items-center bg-white drop-shadow-md rounded-xl w-auto">

        @if ($responsible && $responsible->picture) 
            <img src="{{ asset('storage/' . $responsible->picture) }}" alt="Responsible Picture" class="w-12 h-12 rounded-full mx-5 my-2">
        @else
            <img src="{{ asset('images/uploads/default-user.png') }}" alt="Default User Image" class="w-12 h-12 rounded-full mx-5 my-2">
        @endif

        <span class="text-gray-500 font-semibold me-5">{{ Auth::user()->name ?? 'Utilizador' }}</span>
    </div>
</nav>