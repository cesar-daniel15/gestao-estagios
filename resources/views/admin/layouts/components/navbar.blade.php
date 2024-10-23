<!-- Navbar -->
<nav class="flex justify-between items-center">
    <!-- Nome da Página -->
    <div class="text-md font-bold text-gray-500">
        @yield('page-name')
    </div>

    <!-- User Info -->
    <div class="hidden md:flex items-center bg-white drop-shadow-md rounded-xl ">
        <img src="https://imgs.search.brave.com/y1gYLarPEvQ9DyNwccWpA3Gcqv58-FlP87GCGjGmFcY/rs:fit:860:0:0:0/g:ce/aHR0cHM6Ly9zdGF0/aWMtMDAuaWNvbmR1/Y2suY29tL2Fzc2V0/cy4wMC9sYXJhdmVs/LWljb24tMjQ4eDI1/Ni02dGR1cGg2Zy5w/bmc" 
            alt="User Image" class="w-12 h-12 rounded-full mx-5 my-2"> 
        <span class="text-gray-500 font-semibold me-5">My Nick Name</span>
    </div>
</nav>