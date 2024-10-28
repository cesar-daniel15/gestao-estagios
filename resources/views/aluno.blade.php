@extends('layouts.default-page')

@section('title', 'Instituição - Gestão de Estágios')

@section('content')

<section>
    <div class="w-full h-auto p-10 bg-gradient-to-r from-sky-400 to-blue-600 flex flex-col justify-center items-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-white mb-4 my-5">Responsável da Instituição</div>
        <p class="text-white max-w-2xl text-center">
            A nossa plataforma simplifica a gestão de estágios, permitindo acompanhar os alunos, aprovar planos e avaliar o desempenho de forma rápida e segura. Com uma interface intuitiva, facilita a comunicação com supervisores acadêmicos e centraliza toda a documentação necessária.
        </p>
    </div>
</section>

<section>
    <div class="w-full h-auto p-10 bg-gray-100 flex flex-col justify-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Principais Funcionalidades</div>

        <div class="flex flex-col items-center mb-6">
            <div class="text-sky-400 font-extrabold">Criar Estágios</div>
            <p class="text-gray-500">Permite às empresas registrar novas ofertas de estágio, especificando detalhes como área de atuação, duração e requisitos.</p>
        </div>

        <div class="flex flex-col items-center mb-6">
            <div class="text-sky-400 font-extrabold">Confirmar a assiduidade do aluno</div>
            <p class="text-gray-500">A empresa pode verificar e aprovar os relatórios de assiduidade submetidos pelos alunos durante o estágio.</p>
        </div>

        <div class="flex flex-col items-center mb-6">
            <div class="text-sky-400 font-extrabold">Efetuar a avaliação do aluno após o estágio</div>
            <p class="text-gray-500">No final do estágio, a empresa pode fazer a avaliação final do desempenho do aluno, com base no trabalho realizado.</p>
        </div>
    </div>
</section>

<section>
    <div class="w-full h-auto p-10 bg-white flex flex-col justify-center text-center">
        <div class="text-2xl md:text-3xl font-extrabold text-sky-400 mb-4">Passos a Seguir</div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">1. Fazer o Registro no Sistema</div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">2. Criar uma Oferta de Estágio</div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">3. Aprovar Assiduidade</div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">4. Anexar Plano de Estágio</div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">5. Fazer Avaliação Final</div>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg">
                <div class="font-bold text-sky-400">6. Encerrar Estágio</div>
            </div>

        </div>
    </div>
</section>

@endsection
