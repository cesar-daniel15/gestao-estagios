<!-- Navbar -->
<nav class="bg-gray-100  top-0 z-50 border-b border-sky-400">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-5 sticky-top">
        <a href="{{ url('/') }}" class="flex items-center space-x-3 rtl:space-x-reverse mb-3 mb:mb-0">
            <img src="{{ asset('images/icon.png') }}" class="h-20" alt="Gestão de Estágios Logo" />
        </a>
        <button data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:text-sky-400" aria-controls="navbar-default" aria-expanded="false">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
        <div  id="navbar-default" class="fixed top-20 mt-5 left-0 right-0 z-50 md:static md:top-0 md:mt-0 md:left-0 md:right-0 md:z-0 hidden w-full md:block md:w-auto bg-sky-400 md:bg-gray-100 rounded-xl">
            <ul class="flex flex-col md:flex-row flex-nowrap items-center md:space-x-8 p-4 mt-4 ">
                @yield('navbar-items')
            </ul>
        </div>
    </div>
</nav>


<script>
    // Menu Mobile
    document.addEventListener('DOMContentLoaded', function () {
        const button = document.querySelector('[data-collapse-toggle="navbar-default"]');
        const menu = document.querySelector('#navbar-default');
        const navItems = document.querySelectorAll('#navbar-default ul li a'); 

        button.addEventListener('click', function () {
            menu.classList.toggle('hidden');
            menu.classList.toggle('md:flex');
        });

        navItems.forEach(item => {
            item.addEventListener('click', function () {
                if (window.innerWidth < 768) { 
                    menu.classList.add('hidden'); 
                    menu.classList.remove('md:flex'); 
                }
            });
        });
    });
</script>

