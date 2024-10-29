
@extends('layouts.default-page')

@section('title', 'Instituição - Gestão de Estágios')

@section('navbar-items')
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
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-sm sm:text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-6 sm:px-10">Começar Agora</a>
    </li>
@endsection

@section('content')

    <!-- Seção Sobre -->
    <section id="sobre" class="p-6 md:p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
        <div class="text-xl sm:text-2xl md:text-3xl font-extrabold text-white mb-3 sm:mb-4 md:mb-5">Responsável da Instituição</div>
        <p class="text-white max-w-lg sm:max-w-2xl text-sm sm:text-base md:text-lg text-justify leading-relaxed px-4">
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
                <img src="{{ asset('images/icons/pc-mobile.png') }}" alt="Ícone" class="w-10 h-10 sm:w-12 sm:h-12">
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
