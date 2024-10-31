@extends('layouts.default-page')

@section('title', 'Coordenadores - Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white md:text-gray-500 text-base font-bold">Instituição</a>
    </li>
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-gray-500 text-base font-bold">Empresa</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/coordenadores') }}" class="text-white  md:text-sky-400 text-base font-bold">Coordenadores</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/aluno') }}" class="text-white md:text-gray-500 text-base font-bold">Aluno</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-6">Começar Agora</a>
    </li>
@endsection

@section('content')

    <!-- Seção Sobre -->
    <section id="sobre">
        <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col md:flex-row justify-center items-center text-center md:text-left">

            <!-- Imagem do Coordenador (Centralizado Verticalmente) -->
            <div class="w-full md:w-1/2 flex justify-center items-center mt-6 md:mt-0">
                <svg xmlns="http://www.w3.org/2000/svg" width="7em" height="7em" viewBox="0 0 24 24">
                    <path fill="white" d="M20 17a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H9.46c.35.61.54 1.3.54 2h10v11h-9v2m4-10v2H9v13H7v-6H5v6H3v-8H1.5V9a2 2 0 0 1 2-2zM8 4a2 2 0 0 1-2 2a2 2 0 0 1-2-2a2 2 0 0 1 2-2a2 2 0 0 1 2 2"/>
                </svg>        
            </div>

            <!-- Texto de Apresentação (Alinhado à Esquerda) -->
            <div class="w-full md:w-1/2 max-w-2xl md:text-left md:mr-8">
                <div class="text-2xl md:text-3xl font-extrabold text-white mb-4">Responsável da Unidade Curricular</div>
                <p class="text-white text-justify">
                    O uso desta plataforma simplifica a gestão dos coordenadores, dando aos alunos a hipótese de estagiar, realizando várias tarefas de forma organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
                </p>
            </div>
            
        </div>
    </section>

    <!-- Seção Principais Funcionalidades -->
    <section id="funcionalidades">
        <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Principais Funcionalidades</div>

                <!-- Vantagem 1 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">
                    <!-- Ícone -->
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="#00b0eb" fill-rule="evenodd" d="M7 7c0-2.762 2.238-5 5-5s5 2.238 5 5v3h.4c.88 0 1.6.72 1.6 1.6v7c0 1.32-1.08 2.4-2.4 2.4H7.4C6.08 21 5 19.92 5 18.6v-7c0-.88.72-1.6 1.6-1.6H7zm8 0v3H9V7c0-1.658 1.342-3 3-3s3 1.342 3 3m-3 5.25a1.75 1.75 0 0 0-.75 3.332V18a.75.75 0 0 0 1.5 0v-2.418A1.75 1.75 0 0 0 12 12.25" clip-rule="evenodd"/>
                        </svg>
                    </div>
                    
                    <!-- Texto -->
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Controlo de Acesso:</span> Adicionar os alunos que irão realizar estágio e posteriormente atribuição de estágio.
                        </p>
                    </div>
                </div>

                <!-- Vantagem 2 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">
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
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">
                    <!-- Ícone -->
                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 2048 2048">
                            <path fill="#00b0eb" d="M1920 512v1408H768v-256H512v-256H256V0h731l256 256h421v256zm-896-128h165l-165-165zm256 896V512H896V128H384v1152zm256 256V384h-128v1024H640v128zm257-896h-129v1024H896v128h897z"/>
                        </svg>
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
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Autenticar no Sistema</div>
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