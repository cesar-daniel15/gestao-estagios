@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Registar')

@section('content') 
    <div class="flex justify-center items-center min-h-screen drop-shadow-2xl">
        <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-lg mx-4"> 
            <!-- Left Side -->
            <div class="bg-sky-400 rounded-l-xl p-8 w-1/2 hidden md:flex flex-col justify-center items-center">
                <img src="{{ asset('images/white_icon.png') }}" class="h-20 my-5" alt="Gestão de Estágios Logo" />
                <div class="text-2xl font-extrabold text-white my-5">Bem-vindo de volta!</div>
                <p class="text-white text-base mb-8 text-center">Entre agora mesmo na sua conta</p>
                <div class="mt-10">
                    <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-6 transition-transform transform hover:scale-105 duration-300 ease-in-out"><a href="{{ url('/login') }}">Entrar</a></button>
                </div>
            </div>

            <!-- Right Side -->
            <div class="bg-white rounded-xl md:rounded-r-xl p-8 w-full md:w-1/2 flex flex-col">
                <div class="text-xl font-extrabold text-center text-sky-400 mb-2 mt-10">Cria a minha conta</div>
                <p class="text-gray-400 font-bold text-base text-center mb-10">Preencha os seus dados</p>
                <form>
                    <!-- Nome -->
                    <div class="mb-8 mt-5">
                        <label for="name" class="sr-only">Nome</label>
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <img src="{{ asset('images/icons/user.png') }}" alt="Name Icon" class="w-4 h-4 mx-5"> 
                            
                            <!-- Input -->
                            <input type="name" id="name" placeholder="Nome" class="block w-full bg-gray-100 border-0 focus:outline-none" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-8 mt-5">
                        <label for="email" class="sr-only">Email</label>
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <img src="{{ asset('images/icons/email.png') }}" alt="Email Icon" class="w-5 h-5 mx-5"> 
                            
                            <!-- Input -->
                            <input type="email" id="email" placeholder="Email" class="block w-full bg-gray-100 border-0 focus:outline-none" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="sr-only">Password</label>
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <img src="{{ asset('images/icons/key.png') }}" alt="Password Icon" class="w-4 h-4 mx-5"> 
                            
                            <!-- Input -->
                            <input type="password" id="password" placeholder="Password" class="block w-full bg-gray-100 border-0 focus:outline-none" required>
                        </div>
                    </div>
                    <!-- Submit --> 
                    <div class="flex justify-center">
                        <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-10 transition-transform transform hover:scale-105 duration-300 ease-in-out" type="submit">Registar</button>
                    </div>
                    <div class="md:hidden flex justify-center">
                        <a href="{{ url('/login') }}" class="text-gray-400 text-md text-base"><u>Já tem conta?</u></a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
