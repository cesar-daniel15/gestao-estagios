@extends('layouts.default-page')

@section('title', 'Instituição - Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white text-gray-500 md:text-sky-400 text-base font-bold">Instituição</a>
    </li>
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-gray-500 text-sm sm:text-base font-bold">Empresa</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/coordenadores') }}" class="text-white md:text-gray-500 text-sm sm:text-base font-bold">Coordenadores</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/aluno') }}" class="text-white md:text-gray-500 text-sm sm:text-base font-bold">Aluno</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-sm sm:text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-6 sm:px-6">Começar Agora</a>
    </li>
@endsection

@section('content')
        <!-- Seção Sobre -->
        <section id="sobre">
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col md:flex-row justify-center items-center text-center md:text-left">

        <!-- Imagem do Coordenador (Centralizado Verticalmente) -->
        <div class="w-full md:w-1/2 flex justify-center items-center mt-6 md:mt-0">
            <svg xmlns="http://www.w3.org/2000/svg" width="7em" height="7em" viewBox="0 0 48 48">
                <g fill="none" stroke="white" stroke-linejoin="round" stroke-width="4"><path d="M2 17.4L23.022 9l21.022 8.4l-21.022 8.4z"/><path stroke-linecap="round" d="M44.044 17.51v9.223m-32.488-4.908v12.442S16.366 39 23.022 39c6.657 0 11.467-4.733 11.467-4.733V21.825"/></g>
            </svg>       
        </div>

    <!-- Texto de Apresentação (Alinhado à Esquerda) -->
    <div class="w-full md:w-1/2 max-w-2xl md:text-left md:mr-8">
        <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 text-center">Responsável da Instituição</div>
            <p class="text-white text-justify">
            A nossa plataforma simplifica a gestão de estagiários, permitindo acompanhar o progresso, aprovar planos e avaliar desempenhos de forma rápida e organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
        </p>
    </section>


    <!-- Seção Principais Funcionalidades -->
    <section id="funcionalidades" class="p-6 md:p-10 bg-gray-100 flex flex-col justify-center items-center text-center">
        <div class="text-xl sm:text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Principais Funcionalidades</div>
        
        <!-- Vantagem 1 -->
        <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-lg">
            <!-- Ícone -->
            <div class="flex-shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 32 32"><path fill="#00b0eb" d="m25.586 8l3-3L30 6.411l-3 3.001zM16 20.5l-5-4.961l1.59-1.57l3.41 3.38L23.41 10L25 11.579z"/>
                    <path fill="#00b0eb" d="M4 28v-2.587L10.414 19L9 17.585l-5 5V2H2v26a2 2 0 0 0 2 2h26v-2Z"/>
                </svg>
            </div>
            
            <!-- Texto -->
            <div class="ml-3 sm:ml-4 text-left">
                <p class="text-gray-400 text-xs sm:text-sm md:text-base font-bold leading-snug">
                    <span class="text-sky-400 font-extrabold">Nota final:</span> Atribuição da nota final do aluno após a realização do estágio.
                </p>
            </div>
        </div>
    </section>

    <!-- Seção Passos a Seguir -->
    <section id="passos" class="scroll-mt-24 p-6 md:p-10 bg-white flex flex-col justify-center items-center text-center">
        <!-- Título da Seção -->
        <div class="text-xl sm:text-2xl md:text-3xl font-bold text-sky-400 mb-6 sm:mb-10">Passos a Seguir</div>
        
        <!-- Grid para organizar os itens em duas colunas com espaçamento aumentado -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-12 sm:gap-x-20 gap-y-6 sm:gap-y-11 max-w-lg md:max-w-3xl">
            <!-- Passo 1 -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <!-- Círculo do número -->
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-8 h-8 sm:w-10 sm:h-10 rounded-full">1</div>
                <!-- Retângulo com a frase -->
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left text-sm sm:text-base">Fazer o Registro no Sistema</div>
            </div>

            <!-- Passo 2 -->
            <div class="flex items-center space-x-2 sm:space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-8 h-8 sm:w-10 sm:h-10 rounded-full">2</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left text-sm sm:text-base">Atribuir Nota Final</div>
            </div>
        </div>
    </section>

@endsection