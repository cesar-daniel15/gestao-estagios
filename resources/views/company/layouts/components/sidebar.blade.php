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
               <a href="{{ url('/company') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"  width="1.6em" height="1.6em" stroke="currentColor" class="ms-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
               </svg>
               <span class="ms-5 text-base">Home</span>
               </a>
            </li>


            <!-- Estágio -->
            <li>
               <a href="{{ url('/company/internships') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 48 48" class="ms-2"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><circle cx="24" cy="11" r="7"/>
                  <path d="M4 41c0-8.837 8.059-16 18-16m5 6h14v10H27zm10 0v-3a3 3 0 1 0-6 0v3"/></g>
               </svg>
                  <span class="ms-5 text-base">Estágios</span>
               </a>
            </li>


            <!-- Avaliações -->
            <li>
               <a href="{{ url('/company/evaluations') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg"  width="1.6em" height="1.6em" viewBox="0 0 256 256" class="ms-2">
                    <path fill="currentColor" d="m227.79 52.62l-96-32a11.85 11.85 0 0 0-7.58 0l-96 32A12 12 0 0 0 20 63.37a6 6 0 0 0 0 .63v80a12 12 0 0 0 24 0V80.65l23.71 7.9a67.92 67.92 0 0 0 18.42 85A100.36 100.36 0 0 0 46 209.44a12 12 0 1 0 20.1 13.11C80.37 200.59 103 188 128 188s47.63 12.59 61.95 34.55a12 12 0 1 0 20.1-13.11a100.36 100.36 0 0 0-40.18-35.92a67.92 67.92 0 0 0 18.42-85l39.5-13.17a12 12 0 0 0 0-22.76Zm-99.79-8L186.05 64L128 83.35L70 64ZM172 120a44 44 0 1 1-81.06-23.71l33.27 11.09a11.9 11.9 0 0 0 7.58 0l33.27-11.09A43.85 43.85 0 0 1 172 120"/>
               </svg>
                  <span class="ms-5 text-base">Avaliações</span>
               </a>
            </li>


            <!-- Assiduidade -->
            <li>
               <a href="{{ url('/company/attendance') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2"><g fill="none" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 19v-9a6 6 0 0 1 6-6v0a6 6 0 0 1 6 6v9M6 19h12M6 19H4m14 0h2m-9 3h2"/><circle cx="12" cy="3" r="1"/></g>
                </svg>
                  <span class="ms-5 text-base">Assiduidade</span>
               </a>
            </li>


         <div id="navbar-default" class="flex flex-col px-3 justify-end mt-auto">
         <ul class="space-y-2 xl:space-y-4">
         <li>
               <a href="{{ url('/company/auth') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24"  class="ms-2">
                     <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1m7 5a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/>
                  </svg>
                  <span class="ms-5 text-base">Perfil</span>
               </a>
            </li>

            <li>
               <a href="{{ url('/') }}"  target="_blank" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-red-500s group">
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