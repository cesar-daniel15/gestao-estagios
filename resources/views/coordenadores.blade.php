@extends('layouts.default-page')

@section('title', 'Coordenadores - Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-gray-500 text-base font-bold">Empresa</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white md:text-gray-500 text-base font-bold">Instituição</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/aluno') }}" class="text-white md:text-gray-500 text-base font-bold">Aluno</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-10">Começar Agora</a>
    </li>
@endsection


@section('content')

<<<<<<< HEAD
<!-- Seção Sobre -->
<section id="sobre">
    <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Responsável da Unidade Curricular</div>
        <p class="text-white max-w-2xl text-justify">
            O uso desta plataforma simplifica a gestão dos coordenadores, dando aos alunos a hipótese de estagiar, realizando várias tarefas,mas sempre de forma organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
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
                        <span class="text-sky-400 font-extrabold">Controlo de Acesso:</span> Adicionar os alunos que irão realizar estágio e posteriormente atribuição de estágio.
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
                        <span class="text-sky-400 font-extrabold">Notificação de tarefas:</span> Simplifica o controlo de tarefas a realizar pelos alunos.
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
                        <span class="text-sky-400 font-extrabold">Exportação da documentação:</span> Exportação de diferentes tipos de documentação relativa ao aluno durante o estágio.
                    </p>
=======
    <!-- Seção Sobre -->
    <section id="sobre">
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Responsável da Unidade Curricular</div>
            <p class="text-white max-w-2xl text-justify">
                O uso desta plataforma simplifica a gestão dos coordenadores, dando aos alunos a hipótese de estagiar, realizando várias tarefas,mas sempre de forma organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
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
                            <span class="text-sky-400 font-extrabold">Controlo de Acesso:</span> Adicionar os alunos que irão realizar estágio e posteriormente atribuição de estágio.
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
                            <span class="text-sky-400 font-extrabold">Notificação de tarefas:</span> Simplifica o controlo de tarefas a realizar pelos alunos.
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
                            <span class="text-sky-400 font-extrabold">Exportação da documentação:</span> Exportação de diferentes tipos de documentação relativa ao aluno durante o estágio.
                        </p>
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
                <!-- Passo 1 -->
                <div class="flex items-center space-x-3">
                    <!-- Círculo do número -->
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">1</div>
                    <!-- Retângulo com a frase -->
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Fazer o Registro no Sistema</div>
                </div>

                <!-- Passo 2 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">2</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Alunos no Sistema</div>
                </div>

                <!-- Passo 3 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Concordar com Plano de Estágio</div>
                </div>

                <!-- Passo 4 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left"> Atribuir Estágio a Aluno</div>
                </div>

                <!-- Passo 5 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Enviar Alertas</div>
                </div>

                <!-- Passo 6 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">6</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Exportas Documentos</div>
>>>>>>> 43091eae3410411d12143835a74df128f5166bd7
                </div>
            </div>
        </div>
    </section>

<<<<<<< HEAD
<!-- Seção Passos a Seguir -->
<section id="passos" class="scroll-mt-24">
    <div class="w-full h-auto p-10 bg-white flex flex-col justify-center items-center text-center">
        <!-- Título da Seção -->
        <div class="text-2xl md:text-3xl font-bold text-sky-400 mb-10">Passos a Seguir</div>
        
        <!-- Grid para organizar os itens em duas colunas com espaçamento aumentado -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-20 gap-11 max-w-3xl">
            <!-- Passo 1 -->
            <div class="flex items-center space-x-3">
                <!-- Círculo do número -->
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">1</div>
                <!-- Retângulo com a frase -->
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Fazer o Registro no Sistema</div>
            </div>

            <!-- Passo 2 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">2</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Alunos no Sistema</div>
            </div>

            <!-- Passo 3 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Concordar com Plano de Estágio</div>
            </div>

            <!-- Passo 4 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left"> Atribuir Estágio a Aluno</div>
            </div>

            <!-- Passo 5 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Enviar Alertas</div>
            </div>

            <!-- Passo 6 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">6</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Exportas Documentos</div>
            </div>
        </div>
    </div>
</section>


@endsection
=======
@endsection
>>>>>>> 43091eae3410411d12143835a74df128f5166bd7
