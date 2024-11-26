@extends('layouts.default-page')

@section('title', 'Empresa - Gestão de Estágios')
@section('navbar-items')
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/') }}" class="text-white md:text-gray-500  text-base font-extrabold">Home</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white md:text-gray-500 text-base font-bold">Instituição</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-sky-400 text-base font-bold">Empresa</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/coordenadores') }}" class="text-white md:text-gray-500 text-base font-bold">Coordenadores</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/aluno') }}" class="text-white md:text-gray-500 text-base font-bold">Aluno</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out my-5 md:mb-0 md:mt-0">
        <a href="{{ url('/register') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-6">Começar Agora</a>
    </li>
@endsection

@section('content')

    <!-- Seção Sobre -->
    <section id="sobre">
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col md:flex-row justify-center items-center text-center md:text-left">

            <div class="w-full md:w-1/3 flex justify-center items-center mt-6 md:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="7em" height="7em" viewBox="0 0 24 24">
                    <path fill="white" d="M12 15.5q.825 0 1.413-.587T14 13.5t-.587-1.412T12 11.5t-1.412.588T10 13.5t.588 1.413T12 15.5M4 21q-.825 0-1.412-.587T2 19V8q0-.825.588-1.412T4 6h4V4q0-.825.588-1.412T10 2h4q.825 0 1.413.588T16 4v2h4q.825 0 1.413.588T22 8v11q0 .825-.587 1.413T20 21zm0-2h16V8H4zm6-13h4V4h-4zM4 19V8z"/>
                </svg>
            </div>

            <div class="w-full md:w-1/3 max-w-2xl text-center md:text-left my-5">
                <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 text-center">Responsável Empresa</div>
                    <p class="text-white text-justify">
                        A nossa plataforma serve para a criação de estágios, no qual permita acompanhar o progresso dos estagiários, aprovar  e avaliar desempenhos de forma rápida e organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
                    </p>
            </div>

        </div>
    </section>


    <!-- Seção Principais Funcionalidades -->
    <section id="funcionalidades" class="p-6 md:p-10 my-12 bg-gray-100 flex flex-col justify-center items-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-8">Principais Funcionalidades</div>

            <!-- Vantagem 1 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="#00b0eb" d="M21 14v5a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5v2H5v14h14v-5z"/><path fill="#00b0eb" d="M21 7h-4V3h-2v4h-4v2h4v4h2V9h4z"/>
                        </svg>                    
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Criar Estágios:</span> Permite às empresas registrar novas ofertas de estágio, especificando detalhes como área de atuação, duração e requisitos.
                        </p>
                    </div>
                </div>

            <!-- Vantagem 2 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 48 48">
                            <g fill="none" stroke="#00b0eb" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"><path d="M42 20v19a3 3 0 0 1-3 3H9a3 3 0 0 1-3-3V9a3 3 0 0 1 3-3h21"/><path d="m16 20l10 8L41 7"/></g>
                        </svg>                   
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Confirmar a assiduidade do aluno:</span> A empresa pode verificar e aprovar os relatórios de assiduidade submetidos pelos alunos durante o estágio.
                    </div>
                </div>

            <!-- Vantagem 3 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 48 48">
                            <path fill="none" stroke="#00b0eb" stroke-linecap="round" stroke-width="3" stroke-linejoin="round" d="m30.348 11.35l-3.6-3.6h-20.2v35.8h29.6v-18.7"/><path fill="none" stroke-width="3" stroke="#00b0eb" stroke-linecap="round" stroke-linejoin="round" d="m30.948 10.55l-13 18.2l-1.5 12.6l11.5-5.3l13.3-18.4a.98.98 0 0 0-.2-1.4l-8.4-6a1.27 1.27 0 0 0-1.7.3"/><path fill="none"  stroke-width="1" stroke="#00b0eb" stroke-linecap="round" stroke-linejoin="round" d="M16.948 36.85a4.4 4.4 0 0 1 3.5 2.6m-2.5-10.7l10 7.3m1.2-22.9l10 7.4m-11.4-5.6l10.1 7.4m-26.6-1.8v-9.5c0-1.4 2.5-1.3 2.5 0v10.7c0 2.5-4.7 2.5-4.7 0V7.45c0-4 5.6-4 5.9 0"/>
                        </svg>                    
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Efetuar a avaliação do aluno após o estágio:</span> No final do estágio, a empresa pode fazer a avaliação final do desempenho do aluno, com base no trabalho realizado.
                        </p>
                    </div>
            </div>
        </section>

    <!-- Seção Passos a Seguir -->
    <section id="passos" class="scroll-mt-24">
        <div class="w-full h-auto p-10 bg-white flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-bold text-sky-400 my-12">Passos a Seguir</div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 sm:gap-x-20 gap-y-6 sm:gap-y-11 max-w-lg md:max-w-3xl">
            <!-- Passo 1 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">1</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Autenticar no Sistema</div>
                </div>

                <!-- Passo 2 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">2</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Criar Oferta de Estágio</div>
                </div>

                <!-- Passo 3 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Anexar Plano de Estágio</div>
                </div>

                <!-- Passo 4 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left"> Aprovar Assiduidade</div>
                </div>

                <!-- Passo 5 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Avaliação Final</div>
                </div>

                <!-- Passo 6 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">6</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Encerrar Estágio</div>
                </div>
            </div>
        </div>
    </section>

@endsection