<!-- Navbar -->
<nav class="flex justify-between items-center">
    <!-- Nome da Página -->
    <div class="text-md font-bold text-gray-500">
        @yield('page-name')
    </div>

    <!-- User Info -->
    <div class="hidden md:flex items-center bg-white drop-shadow-md rounded-xl w-auto">
        <img src="{{ asset('images/icon.png') }}" alt="User Image" class="w-12 h-12 rounded-full mx-5 my-2"> 
        <span class="text-gray-500 font-semibold me-5">Instituição</span>
    </div>
</nav>