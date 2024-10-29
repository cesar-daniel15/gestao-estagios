@extends('layouts.default-page')

@section('title', 'Aluno - Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-gray-500 text-base font-bold">Empresa</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/coordenadores') }}" class="text-white md:text-gray-500 text-base font-bold">Coordenadores</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white md:text-gray-500 text-base font-bold">Instituição</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-10">Começar Agora</a>
    </li>
@endsection


@section('content')
    <!-- Seção Sobre -->
    <section id="sobre">
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Aluno</div>
            <p class="text-white max-w-2xl text-justify">
                Esta plataforma auxilia o aluno na gestão do estágio, permitindo registrar atividades diárias, acompanhar a carga horária, e submeter documentos de forma rápida e organizada. Com uma interface intuitiva, facilita a comunicação com a empresa e com os orientadores acadêmicos, centralizando toda a documentação e registros necessários.
            </p>
        </div>
    </section>


    <!-- Seção Principais Funcionalidades -->
    <section id="funcionalidades">
        <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Principais Funcionalidades</div>

                <!-- Vantagem 1 -->
                <div class="flex items-center justify-center mb-8 mt-8">
                    <!-- Ícone -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/icons/pc-mobile.png') }}" alt="Ícone" class="w-12 h-12"> 
                    </div>
                    
                    <!-- Texto -->
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Candidatar Oferta Estágio:</span> Fazer a candidatura a uma oferta de estágio que esteja disponível no sistema.
                        </p>
                    </div>
                </div>

                <!-- Vantagem 2 -->
                <div class="flex items-center justify-center mb-8">
                    <!-- Ícone -->
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/icons/pc-mobile.png') }}" alt="Ícone" class="w-12 h-12"> 
                    </div>
                    
                    <!-- Texto -->
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Registar Atividades Dia a Dia:</span> O aluno deverá registar as atividades que faz no seu dia a dia. 
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
                            <span class="text-sky-400 font-extrabold">Marcação da Assiduidade:</span> O aluno deverá marcar as horas que entrou, bem como as horas que deu saída, para a empresa saber.
                        </p>
                    </div>
                </div>

                    <!-- Vantagem 2 -->
                    <div class="flex items-center justify-center mb-8">
                        <!-- Ícone -->
                        <div class="flex-shrink-0">
                            <img src="{{ asset('images/icons/pc-mobile.png') }}" alt="Ícone" class="w-12 h-12"> 
                        </div>
                        
                        <!-- Texto -->
                        <div class="ml-4 text-left">
                            <p class="text-gray-400 font-bold">
                                <span class="text-sky-400 font-extrabold">Submissão Relatório Final:</span> O aluno deverá submeter o relatório final realizado ao longo do estágio. 
                    </div>
                </div>
            </div>
        </section>

    <!-- Seção Passos a Seguir -->
    <section id="passos" class="scroll-mt-24">
        <div class="w-full h-auto p-10 bg-white flex flex-col justify-center items-center text-center">
            <!-- Título da Seção -->
            <div class="text-2xl md:text-3xl font-bold text-sky-400 mb-10">Passos a Seguir</div>
            
            <!-- Grid para organizar os itens em duas colunas com espaçamento aumentado -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-20 gap-11 max-w-3xl">
                <!-- Passo 2 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">1</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Acedar ao Sistema</div>
                </div>

                <!-- Passo 3 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">2</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Visualizar Ofertas de Estágio</div>
                </div>

                <!-- Passo 4 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Atividades do Dia a Dia</div>
                </div>

                <!-- Passo 5 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Assiduidade</div>
                </div>

                <!-- Passo 6 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Submeter Relatório Final</div>
                </div>
            </div>
        </div>
    </section>

@endsection