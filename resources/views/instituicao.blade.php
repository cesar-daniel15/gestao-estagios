@extends('layouts.default-page')

@section('title', 'Instituição - Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="#sobre" class="text-white md:text-gray-500 text-base font-bold">Sobre</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="#funcionalidades" class="text-white md:text-gray-500 text-base font-bold">Principais Funcionalidades</a>
    </li>
    <li class="mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="#passos" class="text-white md:text-gray-500 text-base font-bold">Passos a Seguir</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-10">Começar Agora</a>
    </li>
@endsection

@section('content')

<!-- Seção Sobre -->
<section id="sobre">
    <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Responsável da Instituição</div>
        <p class="text-white max-w-2xl text-center">
            A nossa plataforma simplifica a gestão de estagiários, permitindo acompanhar o progresso, aprovar planos e avaliar desempenhos de forma rápida e organizada. Com uma interface intuitiva, facilita a comunicação com responsáveis acadêmicos e centraliza toda a documentação necessária.
        </p>
    </div>
</section>

<!-- Seção Principais Funcionalidades -->
<section id="funcionalidades">
    <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center items-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Principais Funcionalidades</div>

        <div class="flex flex-col items-center mb-6 max-w-md">
            <div class="text-sky-400 font-extrabold text-lg">Criar Estágios</div>
            <p class="text-gray-500">Permite às empresas registrar novas ofertas de estágio, especificando detalhes como área de atuação, duração e requisitos.</p>
        </div>

        <div class="flex flex-col items-center mb-6 max-w-md">
            <div class="text-sky-400 font-extrabold text-lg">Confirmar a Assiduidade do Aluno</div>
            <p class="text-gray-500">A empresa pode verificar e aprovar os registros de assiduidade submetidos pelos alunos durante o estágio.</p>
        </div>

        <div class="flex flex-col items-center mb-6 max-w-md">
            <div class="text-sky-400 font-extrabold text-lg">Efetuar a Avaliação do Aluno Após o Estágio</div>
            <p class="text-gray-500">No final do estágio, o responsável pode submeter a avaliação final do desempenho do aluno, com base no trabalho realizado.</p>
        </div>
    </div>
</section>

<!-- Seção Passos a Seguir -->
<section id="passos" class="scroll-mt-24">
    <div class="w-full h-auto p-10 bg-white flex flex-col justify-center items-center text-center">
        <!-- Título da Seção -->
        <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-10">Passos a Seguir</div>
        
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
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Criar uma Oferta de Estágio</div>
            </div>

            <!-- Passo 3 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">3</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Aprovar Assiduidade</div>
            </div>

            <!-- Passo 4 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">4</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Anexar Plano de Estágio</div>
            </div>

            <!-- Passo 5 -->
            <div class="flex items-center space-x-3">
                <div class="flex justify-center items-center bg-sky-400 text-white font-bold w-10 h-10 rounded-full text-center">5</div>
                <div class="bg-sky-400 text-white font-bold px-3 py-2 rounded-lg w-full text-left">Fazer Avaliação Final</div>
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
