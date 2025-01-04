@extends('layouts.default-page')

@section('title', 'Gestão de Estágios')

@section('navbar-items')
    <li class="mb-5 mt-2 md:mb-0 md:mt-0">
        <a href="{{ url('/') }}" class="text-white md:text-gray-500 text-base font-bold">Home</a>
    </li>
    <li class="inline-block transition-transform transform hover:scale-105 duration-300 ease-in-out mb-5 mt-5 md:mb-0 md:mt-0">
        <a href="{{ url('/login') }}" class="bg-white md:bg-sky-400 text-base font-bold md:text-white text-sky-400 p-2 rounded-xl px-10">Entrar</a>
    </li>
@endsection

@section('content')

@include('layouts.components.alert')

<div class="bg-gray-100 py-10">
    <div class="max-w-4xl mx-auto bg-white drop-shadow-md rounded-xl p-10">
        <h2 class="text-xl font-bold text-gray-700 mb-6 text-center">Pedido para Criação de Conta</h2>
        
        <form action="{{ route('contact.store') }}" method="POST">
            @csrf
            <!-- Nome -->
            <div class="mb-6">
                <label for="name" class="block text-gray-600 mb-2">Nome</label>
                <input type="text" name="name" id="name" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-sky-400 focus:outline-none" />
            </div>

            <!-- Email -->
            <div class="mb-6">
                <label for="email" class="block text-gray-600 mb-2">E-mail</label>
                <input type="email" name="email" id="email" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-sky-400 focus:outline-none" />
            </div>

            <!-- Perfil -->
            <div class="mb-6">
                <label for="profile" class="block text-gray-600 mb-2">Perfil</label>
                <select name="profile" id="profile" required
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-sky-400 focus:outline-none">
                    <option value="">Selecione o perfil</option>
                    <option value="Institution">Instituição</option>
                    <option value="Company">Empresa</option>
                    <option value="Responsible">Responsável</option>
                    <option value="Student">Estudante</option>
                </select>
            </div>

            <!-- Mensagem -->
            <div class="mb-6">
                <label for="message" class="block text-gray-600 mb-2">Mensagem</label>
                <textarea name="message" id="message" rows="2" 
                    class="w-full p-3 border border-gray-300 rounded-lg focus:ring focus:ring-sky-400 focus:outline-none"></textarea>
            </div>

            <!-- Botão de Enviar -->
            <div class="text-center">
                <button type="submit"
                    class="bg-sky-400 text-white py-2 px-10 rounded-xl transition-transform transform hover:scale-105 duration-300 ease-in-out">
                    Enviar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
