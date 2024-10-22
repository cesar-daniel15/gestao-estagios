<!-- Button Mobile -->
<button id="menu-toggle" type="button" class="fixed top-5 left-5 inline-flex items-center w-10 h-10 justify-center text-gray-500 rounded-lg md:hidden hover:text-sky-400 z-50" aria-controls="navbar-default" aria-expanded="false">
   <svg class="menu-icon w-5 h-5 transition-colors duration-300 ease-in-out" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
      <path class="top transition-transform duration-300 ease-in-out" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15"/>
      <path class="middle transition-opacity duration-300 ease-in-out" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 7h15"/>
      <path class="bottom transition-transform duration-300 ease-in-out" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 13h15"/>
   </svg>
</button>

<!-- Sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen bg-white rounded-r-lg drop-shadow-2xl transition-transform transform -translate-x-full md:translate-x-0" aria-label="Sidebar">
   <div class="flex flex-col h-full px-3 py-10 overflow-y-auto">
      <a class="flex flex-col items-center justify-center mb-10">
         <img src="{{ asset('images/icon.png') }}" alt="Gestão de Estágios Logo" class="h-[70px] mb-2"/>
         <span class="hidden md:flex self-center text-xl font-extrabold text-sky-400">Gestão Estágios</span>
      </a>

      <div id="navbar-default" class="flex-grow px-5"> 
         <ul class="space-y-4">
            <li>
               <a href="{{ url('/admin') }}" class="flex items-center p-2 text-gray-500 hover:text-white font-semibold rounded-lg hover:bg-sky-400 group text-md">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6 ms-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
               </svg>
                  <span class="ms-5">Home</span>
               </a>
            </li>
            <li>
               <a href="#" class="flex items-center p-2 text-gray-500 hover:text-white font-semibold rounded-lg hover:bg-sky-400 group text-md">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="ms-2">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                  </svg>
                  <span class="ms-5 text-base">Utilizadores</span>
               </a>
            </li>
            <li>
               <a href="#" class="flex items-center p-2 text-gray-500 hover:text-white font-semibold rounded-lg hover:bg-sky-400 group text-md">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" alt="Instituição" viewBox="0 0 24 24" class="ms-2">
                     <path fill="currentColor" d="m12 21l-7-3.8v-6L1 9l11-6l11 6v8h-2v-6.9l-2 1.1v6zm0-8.3L18.85 9L12 5.3L5.15 9zm0 6.025l5-2.7V12.25L12 15l-5-2.75v3.775zm0-3.775"/>
                  </svg>
                  <span class="ms-5 text-base">Entidades</span>
               </a>
            </li>
         </ul>
      </div>

      <div id="navbar-default" class="flex flex-col px-5 justify-end h-full"> 
         <ul class="space-y-4 mt-auto">
            <li>
               <a href="#" class="flex items-center p-2 text-gray-500 hover:text-white font-semibold rounded-lg hover:bg-yellow-400 group text-md">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24"  class="ms-2">
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1m7 5a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/>
                  </svg>
                  <span class="ms-5">Perfil</span>
               </a>
            </li>
            <li>
               <a href="#" class="flex items-center p-2 text-gray-500 hover:text-white font-semibold rounded-lg hover:bg-red-400 group text-md">
                  <svg xmlns="http://www.w3.org/2000/svg"  width="1.6em" height="1.6em" viewBox="0 0 24 24"  class="ms-2">
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 4.001H5v14a2 2 0 0 0 2 2h8m1-5l3-3m0 0l-3-3m3 3H9"/>
                  </svg>
                  <span class="ms-5 text-base">Logout</span>
               </a>
            </li>
         </ul>
      </div>

   </div>
</aside>

<script>
   document.addEventListener('DOMContentLoaded', function () {
      const button = document.querySelector('#menu-toggle');
      const sidebar = document.querySelector('#logo-sidebar');
      const iconTop = document.querySelector('.top');
      const iconMiddle = document.querySelector('.middle');
      const iconBottom = document.querySelector('.bottom');

      button.addEventListener('click', function () {
         sidebar.classList.toggle('-translate-x-full'); 
      });
   });
</script>
