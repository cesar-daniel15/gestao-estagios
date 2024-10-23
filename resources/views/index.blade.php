@extends('layouts.default-page')

@section('title', 'Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="#section1" class="text-white md:text-gray-500 text-base font-bold">Sobre</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="#section2" class="text-white md:text-gray-500 text-base font-bold">Utilizadores</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="#section3" class="text-white md:text-gray-500 text-base font-bold">Vantagens</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-10">Entrar</a>
    </li>
@endsection

@section('content')

    <section id="section1">
        <!-- Block 1 -->
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Estágios descomplicados,<br>carreiras impulsionadas</div>
            <p class="text-white max-w-2xl text-center">
                <span class="text-base md:font-semibold">Gestão de Estágios</span> é uma aplicação web que simplifica o processo de atribuição, acompanhamento e avaliação de estágios. Facilita a interação entre alunos, coordenadores, empresas e responsáveis, garantindo transparência e acesso à informação em tempo real, reduzindo o uso de papel e automatizando tarefas essenciais.
            </p>
            <a href="{{ url('/login') }}" class="bg-white font-bold text-sky-400 p-2 rounded-xl px-10 mt-5 transition-transform transform hover:scale-105 duration-300 ease-in-out">Começar Agora</a>
        </div>
    </section>

    <section id="section2">
        <!-- Block 2 -->
        <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center text-center my-5">
            <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Tipos de Utilizadores</div>
            <p class="text-gray-400 font-bold max-w-2xl text-center mb-6 mx-auto">
                Selecione o seu tipo de utilizador para prosseguir para o próximo passo
            </p>
            
            <div class="flex flex-wrap justify-center md:justify-around overflow-x-auto my-10 mx-10 gap-4">
                <!-- Instituição Card -->
                <a href="" class="bg-gray-200 rounded-xl border border-sky-400 w-40 sm:w-48 md:w-1/5 mx-2 p-3 transition-transform transform hover:scale-95 duration-100 ease-in cursor-pointer">
                    <img src="{{ asset('images/icons/instituicao.png') }}" alt="Instituição" class="w-20 h-20 object-cover mx-auto mb-2"> 
                    <div class="text-lg font-bold text-sky-400 ">Instituição</div>
                </a>

                <!-- Empresa Card -->
                <a  href="" class="bg-gray-200 rounded-xl border border-sky-400 w-40 sm:w-48 md:w-1/5 mx-2 p-3 transition-transform transform hover:scale-95 duration-100 ease-in cursor-pointer"> 
                    <img src="{{ asset('images/icons/empresa.png') }}" alt="Empresa" class="w-20 h-20 object-cover mx-auto mb-2"> 
                    <div class="font-bold text-sky-400">Empresa</div>
                </a>

                <!-- Coordenadores Card -->
                <a href="" class="bg-gray-200 rounded-xl border border-sky-400 w-40 sm:w-48 md:w-1/5 mx-2 p-3 transition-transform transform hover:scale-95 duration-100 ease-in cursor-pointer">
                    <img src="{{ asset('images/icons/coordenadores.png') }}" alt="Coordenadores" class="w-20 h-20 object-cover mx-auto mb-2">
                    <div class="text-lg font-bold text-sky-400">Coordenadores</div>
                </a>

                <!-- Aluno Card -->
                <a href="" class="bg-gray-200 rounded-xl border border-sky-400 w-40 sm:w-48 md:w-1/5 mx-2 p-3 transition-transform transform hover:scale-95 duration-100 ease-in cursor-pointer">
                    <img src="{{ asset('images/icons/aluno.png') }}" alt="Aluno" class="w-20 h-20 object-cover mx-auto mb-2"> 
                    <div class="text-lg font-bold text-sky-400">Aluno</div>
                </a>
            </div>
        </div>
    </section>

    <section id="section3">
        <!-- Block 3 -->
        <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center text-center my-5">
            <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-8">Vantagens</div>

            <!-- Vantagem 1 -->
            <div class="flex items-center justify-center mb-8 mt-8">
                <!-- Ícone -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/icons/pc-mobile.png') }}" alt="Ícone" class="w-12 h-12"> 
                </div>
                
                <!-- Texto -->
                <div class="ml-4 text-left">
                    <p class="text-gray-400 font-bold">
                        <span class="text-sky-400 font-extrabold">Facilidade de Acesso:</span> Informação sobre estágios disponível em tempo real, acessível de qualquer lugar.
                    </p>
                </div>
            </div>

            <!-- Vantagem 2 -->
            <div class="flex items-center justify-center mb-8">
                <!-- Ícone -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/icons/automation.png') }}" alt="Ícone" class="w-12 h-12"> 
                </div>
                
                <!-- Texto -->
                <div class="ml-4 text-left">
                    <p class="text-gray-400 font-bold">
                        <span class="text-sky-400 font-extrabold">Automatização de Processos:</span> Reduz a carga administrativa, eliminando tarefas manuais e minimizando erros.
                    </p>
                </div>
            </div>

            <!-- Vantagem 3 -->
            <div class="flex items-center justify-center mb-8">
                <!-- Ícone -->
                <div class="flex-shrink-0">
                    <img src="{{ asset('images/icons/ficheiro.png') }}" alt="Ícone" class="w-12 h-12"> 
                </div>
                
                <!-- Texto -->
                <div class="ml-4 text-left">
                    <p class="text-gray-400 font-bold">
                        <span class="text-sky-400 font-extrabold">Redução de Papel:</span> Digitalização de documentos, relatórios e avaliações, promovendo um ambiente sustentável.
                    </p>
                </div>
            </div>
        </div>
    <section>

@endsection


