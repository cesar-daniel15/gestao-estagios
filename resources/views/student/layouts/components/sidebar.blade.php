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
   <div class="flex flex-col h-full px-3 py-5 xl:py-10 overflow-y-auto">
      <a class="flex flex-col items-center justify-center mb-1">
         <img src="{{ asset('images/icon.png') }}" alt="Gestão de Estágios Logo" class="h-[70px] mb-2"/>
         <span class="hidden xl:flex self-center text-xl font-extrabold text-sky-400">Gestão Estágios</span>
      </a>

      <div id="navbar-default" class="flex-grow px-2">
         <ul class="space-y-4 mt-5 xl:mt-10 xl:space-y-6">
            <!-- Home -->
            <li>
               <a href="{{ url('/student') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"  width="1.6em" height="1.6em" stroke="currentColor" class="ms-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
               </svg>
               <span class="ms-5 text-base">Home</span>
               </a>
            </li>


            <!-- Estágio -->
            <li>
               <a href="{{ url('/student/internships') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 48 48" class="ms-2"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><circle cx="24" cy="11" r="7"/>
                  <path d="M4 41c0-8.837 8.059-16 18-16m5 6h14v10H27zm10 0v-3a3 3 0 1 0-6 0v3"/></g>
               </svg>
                  <span class="ms-5 text-base">Estágios</span>
               </a>
            </li>


            <!-- Registo -->
            <li>
               <a href="{{ url('/student/register') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5">
                  <path d="M7 18h7m-7-4h1m-1-4h3M7 2h9.5L21 6.5V19"/><path d="M3 20.5v-14A1.5 1.5 0 0 1 4.5 5h9.752a.6.6 0 0 1 .424.176l3.148 3.148A.6.6 0 0 1 18 8.75V20.5a1.5 1.5 0 0 1-1.5 1.5h-12A1.5 1.5 0 0 1 3 20.5"/><path d="M14 5v3.4a.6.6 0 0 0 .6.6H18"/></g>
               </svg>
                  <span class="ms-5 text-base">Registos</span>
               </a>
            </li>


            <!-- Relatório -->
            <li>
               <a href="{{ url('/student/report') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2"><g fill="none">
                  <path d="m12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035q-.016-.005-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427q-.004-.016-.017-.018m.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093q.019.005.029-.008l.004-.014l-.034-.614q-.005-.018-.02-.022m-.715.002a.02.02 0 0 0-.027.006l-.006.014l-.034.614q.001.018.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01z"/><path fill="currentColor" d="M13.586 2A2 2 0 0 1 15 2.586L19.414 7A2 2 0 0 1 20 8.414V20a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2ZM12 4H6v16h12V10h-4.5A1.5 1.5 0 0 1 12 8.5zm3 10a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2zm-5-4a1 1 0 1 1 0 2H9a1 1 0 1 1 0-2Zm4-5.586V8h3.586z"/></g>
               </svg>
                  <span class="ms-5 text-base">Relatório</span>
               </a>
            </li>


         <div id="navbar-default" class="flex flex-col px-3 justify-end mt-auto">
         <ul class="space-y-2 xl:space-y-4">
         <li>
               <a href="{{ url('/student/auth') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24"  class="ms-2">
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1m7 5a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/>
                  </svg>
                  <span class="ms-5 text-base">Perfil</span>
               </a>
            </li>

            <li>
               <a href="{{ url('/') }}"  target="_blank" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-red-500 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2">
                  <path fill="currentColor" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h7v2H5v14h7v2zm11-4l-1.375-1.45l2.55-2.55H9v-2h8.175l-2.55-2.55L16 7l5 5z"/>
               </svg>
                  <span class="ms-5">Logout</span>
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