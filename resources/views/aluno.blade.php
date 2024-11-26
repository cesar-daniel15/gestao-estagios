@extends('layouts.default-page')

@section('title', 'Aluno - Gestão de Estágios')

@section('navbar-items')
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/') }}" class="text-white md:text-gray-500  text-base font-extrabold">Home</a>
    </li>
    <li class="my-3  md:mb-0 md:mt-0">
        <a href="{{ url('/instituicao') }}" class="text-white md:text-gray-500 text-base font-bold">Instituição</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/empresa') }}" class="text-white md:text-gray-500 text-base font-bold">Empresa</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/coordenadores') }}" class="text-white md:text-gray-500 text-base font-bold">Coordenadores</a>
    </li>
    <li class="my-3 md:mb-0 md:mt-0">
        <a href="{{ url('/aluno') }}" class="text-white md:text-sky-400 text-base font-bold">Aluno</a>
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
            <svg xmlns="http://www.w3.org/2000/svg" width="7em" height="7em" viewBox="0 0 256 256">
                <path fill="white" d="m226.53 56.41l-96-32a8 8 0 0 0-5.06 0l-96 32A8 8 0 0 0 24 64v80a8 8 0 0 0 16 0V75.1l33.59 11.19a64 64 0 0 0 20.65 88.05c-18 7.06-33.56 19.83-44.94 37.29a8 8 0 1 0 13.4 8.74C77.77 197.25 101.57 184 128 184s50.23 13.25 65.3 36.37a8 8 0 0 0 13.4-8.74c-11.38-17.46-27-30.23-44.94-37.29a64 64 0 0 0 20.65-88l44.12-14.7a8 8 0 0 0 0-15.18ZM176 120a48 48 0 1 1-86.65-28.45l36.12 12a8 8 0 0 0 5.06 0l36.12-12A47.9 47.9 0 0 1 176 120m-48-32.43L57.3 64L128 40.43L198.7 64Z"/>
            </svg>      
        </div>
    
        <div class="w-full md:w-1/3 max-w-2xl md:text-left my-5">
            <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 text-center">Aluno</div>
                <p class="text-white text-justify">
                    Esta plataforma auxilia o aluno na gestão do estágio, permitindo registrar atividades diárias, acompanhar a carga horária, e submeter documentos de forma rápida e organizada. Com uma interface intuitiva, facilita a comunicação com a empresa e com os orientadores acadêmicos, centralizando toda a documentação e registros necessários.
                </p>
            </div>
        </div>

    </section>


    <!-- Seção Principais Funcionalidades -->
    <section id="funcionalidades">
        <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center my-12 items-center text-center">
            <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-8">Principais Funcionalidades</div>

                <!-- Vantagem 1 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="#00b0eb" d="M5 21q-.825 0-1.412-.587T3 19V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v14q0 .825-.587 1.413T19 21zm0-4.05V19h14v-8.75L13.05 17L9 12.95zm0-2.85l4-4l3.95 3.95L19 7.25V5H5zm0-3.85v-3v6.8v-3.95v6.85v-4V17zm0 3.85V5v9.05v-3.95zm0 2.85v-4V17v-6.75V19z"/>
                        </svg>                    
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Candidatar Oferta Estágio:</span> Fazer a candidatura a uma oferta de estágio que esteja disponível no sistema.
                        </p>
                    </div>
                </div>

                <!-- Vantagem 2 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 24 24">
                            <path fill="#00b0eb" d="M20.71 7.04c.39-.39.39-1.04 0-1.41l-2.34-2.34c-.37-.39-1.02-.39-1.41 0l-1.84 1.83l3.75 3.75M3 17.25V21h3.75L17.81 9.93l-3.75-3.75z"/>
                        </svg>                    
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Registar Atividades Dia a Dia:</span> O aluno deverá registar as atividades que faz no seu dia a dia. 
                    </div>
                </div>

                <!-- Vantagem 3 -->
                <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                    <div class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 48 48">
                            <path fill="#00b0eb" fill-rule="evenodd" stroke="#00b0eb" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m4 24l5-5l10 10L39 9l5 5l-25 25z" clip-rule="evenodd"/>
                        </svg>                   
                    </div>
                    
                    <div class="ml-4 text-left">
                        <p class="text-gray-400 font-bold">
                            <span class="text-sky-400 font-extrabold">Marcação da Assiduidade:</span> O aluno deverá marcar as horas que entrou, bem como as horas que deu saída, para a empresa saber.
                        </p>
                    </div>
                </div>

                    <!-- Vantagem 4 -->
                    <div class="flex items-center justify-center mb-6 sm:mb-8 mt-6 sm:mt-8 max-w-md md:max-w-2xl">

                        <div class="flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="3em" height="3em" viewBox="0 0 16 16">
                                <path fill="none" stroke="#00b0eb" stroke-linejoin="round" d="M7.563 1.545H2.5v10.91h9V5.364M7.563 1.545L11.5 5.364M7.563 1.545v3.819H11.5m-7 9.136h9v-7M4 7.5h6M4 5h2m-2 5h6"/>
                            </svg>                        
                        </div>
                        
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
            <div class="text-2xl md:text-3xl font-bold text-sky-400 mb-10">Passos a Seguir</div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-20 gap-11 max-w-3xl">

                <!-- Passo 2 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">1</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Aceder ao Sistema</div>
                </div>

                <!-- Passo 3 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">2</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Visualizar Ofertas de Estágio</div>
                </div>

                
                <!-- Passo 4 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Candidatar a Oferta de Estágio</div>
                </div>

                <!-- Passo 4 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Atividades do Dia a Dia</div>
                </div>

                <!-- Passo 5 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Registar Assiduidade</div>
                </div>

                <!-- Passo 6 -->
                <div class="flex items-center space-x-3">
                    <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">6</div>
                    <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Submeter Relatório Final</div>
                </div>
            </div>
        </div>
    </section>
    
@endsection