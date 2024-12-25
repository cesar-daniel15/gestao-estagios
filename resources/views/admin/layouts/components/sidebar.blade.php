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
         <ul class="space-y-2 mt-5 xl:mt-10 xl:space-y-4">
            <!-- Home -->
            <li>
               <a href="{{ url('/admin/dashboard') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"  width="1.6em" height="1.6em" stroke="currentColor" class="ms-2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
               </svg>
               <span class="ms-5 text-base">Home</span>
               </a>
            </li>

            <!-- Utilizadores -->
            <li>
               <a href="{{ url('/admin/users') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.5em" height="1.5em" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="ms-2">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-3.31 0-10 1.67-10 5v2h20v-2c0-3.33-6.69-5-10-5z"/>
                  </svg>
                  <span class="ms-5 text-base">Utilizadores</span>
               </a>
            </li>

            <!-- Instituicoes -->
            <li class="relative">
               <details class="group">
                  <summary class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group cursor-pointer">
                     <!-- Icon -->
                     <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" alt="Instituição" viewBox="0 0 24 24" class="ms-2">
                        <path fill="currentColor" d="m12 21l-7-3.8v-6L1 9l11-6l11 6v8h-2v-6.9l-2 1.1v6zm0-8.3L18.85 9L12 5.3L5.15 9zm0 6.025l5-2.7V12.25L12 15l-5-2.75v3.775zm0-3.775"/>
                     </svg>
                     <span class="ms-5 text-base">Instituições</span>
                     <!-- Seta -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-gray-400 group-open:rotate-180 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z"/>
                     </svg>
                  </summary>
                  <ul class="ml-7 mt-2 rounded-md space-y-2">
                     <!-- Submenu para Instituições -->
                     <li>
                        <a href="{{ url('/admin/institutions/') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Instituições</span>
                        </a>
                     </li>
                     <!-- Submenu para Cursos -->
                     <li>
                        <a href="{{ url('/admin/courses') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Cursos</span>
                        </a>
                     </li>
                     <!-- Submenu para Unidades Curriculares -->
                     <li>
                        <a href="{{ url('/admin/units-curriculars') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Unidades Curriculares</span>
                        </a>
                     </li>
                  </ul>
               </details>
            </li>

            <!-- Coordenadores-->
            <li class="relative">
               <details class="group">
                  <summary class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group cursor-pointer">
                     <!-- Icon -->
                     <svg xmlns="http://www.w3.org/2000/svg"  width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2">
                        <path fill="currentColor" d="M20 17a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H9.46c.35.61.54 1.3.54 2h10v11h-9v2m4-10v2H9v13H7v-6H5v6H3v-8H1.5V9a2 2 0 0 1 2-2zM8 4a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2a2 2 0 0 1 2 2"/>
                     </svg>
                     <span class="ms-5 text-base">Coordenadores</span>
                     <!-- Seta -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-gray-500 group-open:rotate-180 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z"/>
                     </svg>
                  </summary>
                  <ul class="ml-7 mt-2 rounded-md space-y-2">
                     <!-- Submenu para Responsaveis UC -->
                     <li>
                        <a href="{{ url('/admin/uc-responsibles') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Responsáveis U.C</span>
                        </a>
                     </li>
                     <!-- Submenu para Notificacoes -->
                     <li>
                        <a href="{{ url('/admin/notifications') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Notificações</span>
                        </a>
                     </li>
                  </ul>
               </details>
            </li>

            <!-- Alunos -->
            <li class="relative">
               <details class="group">
                  <summary class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group cursor-pointer">
                     <!-- Icon -->
                     <svg xmlns="http://www.w3.org/2000/svg"  width="1.6em" height="1.6em" viewBox="0 0 256 256" class="ms-2">
                        <path fill="currentColor" d="m227.79 52.62l-96-32a11.85 11.85 0 0 0-7.58 0l-96 32A12 12 0 0 0 20 63.37a6 6 0 0 0 0 .63v80a12 12 0 0 0 24 0V80.65l23.71 7.9a67.92 67.92 0 0 0 18.42 85A100.36 100.36 0 0 0 46 209.44a12 12 0 1 0 20.1 13.11C80.37 200.59 103 188 128 188s47.63 12.59 61.95 34.55a12 12 0 1 0 20.1-13.11a100.36 100.36 0 0 0-40.18-35.92a67.92 67.92 0 0 0 18.42-85l39.5-13.17a12 12 0 0 0 0-22.76Zm-99.79-8L186.05 64L128 83.35L70 64ZM172 120a44 44 0 1 1-81.06-23.71l33.27 11.09a11.9 11.9 0 0 0 7.58 0l33.27-11.09A43.85 43.85 0 0 1 172 120"/>
                     </svg>
                     <span class="ms-5 text-base">Alunos</span>
                     <!-- Seta -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-gray-500 group-open:rotate-180 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z"/>
                     </svg>
                  </summary>
                  <ul class="ml-7 mt-2 rounded-md space-y-2">
                     <!-- Submenu para Alunos -->
                     <li>
                        <a href="{{ url('/admin/students') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Alunos</span>
                        </a>
                     </li>
                     <!-- Submenu para Notificacoes -->
                     <li>
                        <a href="{{ url('/admin/students/notifications') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Notificações</span>
                        </a>
                     </li>
                  </ul>
               </details>
            </li>

            <!-- Empresas -->
            <li>
               <a href="{{ url('/admin/companies') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
                  <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2">
                     <path fill="currentColor" d="M12 15.5q.825 0 1.413-.587T14 13.5t-.587-1.412T12 11.5t-1.412.588T10 13.5t.588 1.413T12 15.5M4 21q-.825 0-1.412-.587T2 19V8q0-.825.588-1.412T4 6h4V4q0-.825.588-1.412T10 2h4q.825 0 1.413.588T16 4v2h4q.825 0 1.413.588T22 8v11q0 .825-.587 1.413T20 21zm0-2h16V8H4zm6-13h4V4h-4zM4 19V8z"/>
                  </svg>
                  <span class="ms-5 text-base">Empresas</span>
               </a>
            </li>

            <!-- Estagios -->
            <li class="relative">
               <details class="group">
                  <summary class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group cursor-pointer">
                     <!-- Icon -->
                     <svg xmlns="http://www.w3.org/2000/svg"  width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2"><g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor">
                        <path d="M6.6 11.923c5.073-9.454 11.39-9.563 13.913-8.436c1.127 2.524 1.018 8.84-8.436 13.913c-.098-.564-.643-2.04-2.04-3.437s-2.873-1.942-3.437-2.04"/>
                        <path d="M13.35 16.95c1.839.9 2.035 2.514 2.29 4.05c0 0 3.85-2.846 1.387-6.75M7.05 10.727C6.15 8.888 4.536 8.692 3 8.437c0 0 2.847-3.85 6.75-1.387m-3.732 7.862c-.512.511-1.382 1.996-.768 3.838c1.843.614 3.327-.256 3.84-.767M17.3 8.45a1.75 1.75 0 1 0-3.5 0a1.75 1.75 0 0 0 3.5 0"/></g>
                     </svg>
                     <span class="ms-5 text-base">Estágios</span>
                     <!-- Seta -->
                     <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 ml-2 text-gray-500 group-open:rotate-180 transition-transform duration-300" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M7 10l5 5 5-5H7z"/>
                     </svg>
                  </summary>
                  <ul class="ml-7 mt-2 rounded-md space-y-2">
                     <!-- Submenu para Ofertas de Estagio -->
                     <li>
                        <a href="{{ url('/admin/internships-offers') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Ofertas</span>
                        </a>
                     </li>
                     <!-- Submenu para Planos de Estagio -->
                     <li>
                        <a href="{{ url('/admin/internships-plans') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Planos</span>
                        </a>
                     </li>
                     <!-- Submenu para Registo Diarios -->
                     <li>
                        <a href="{{ url('/admin/internships/attendance-records') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400">
                           <span class="ms-5 text-sm">Registos Diários</span>
                        </a>
                     </li>
                     <!-- Submenu para Relatorios Finais -->
                     <li>
                        <a href="{{ url('/admin/internships/final-reports') }}" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 ">
                           <span class="ms-5 text-sm">Relatórios Finais</span>
                        </a>
                     </li>
                  </ul>
               </details>
            </li>

         </ul>
      </div>
   
      <div id="navbar-default" class="flex flex-col px-3 justify-end xl:justify-center h-full"> 
         <ul class="space-y-2 mt-4 xl:mt-auto xl:space-y-4 "> 
            <li>
                  <a href="{{ url('/') }}" target="_blank" class="flex items-center p-2 text-gray-500 hover:text-white rounded-lg hover:bg-sky-400 group">
                     <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 9h3m-3 3h3m-3 3h3m-6 1c-.306-.613-.933-1-1.618-1H7.618c-.685 0-1.312.387-1.618 1M4 5h16a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1m7 5a2 2 0 1 1-4 0a2 2 0 0 1 4 0"/>
                     </svg>
                     <span class="ms-5">Sistema</span>
                  </a>
            </li>
               <form action="{{ route('logout') }}" method="POST" class="w-full">
                  @csrf
                  <button type="submit" class="flex items-center w-full p-2 text-gray-500 hover:text-white rounded-lg hover:bg-red-400 group">
                     <svg xmlns="http://www.w3.org/2000/svg" width="1.6em" height="1.6em" viewBox="0 0 24 24" class="ms-2">
                           <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 3H7a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h8m4-9l-4-4m4 4l-4 4m4-4H9"/>
                     </svg>
                     <span class="ms-5">Sair</span>
                  </button>
               </form>
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
