@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Verificar Conta')

@section('content') 

@include('layouts.components.alert')

    <div class="flex justify-center items-center min-h-screen drop-shadow-2xl">
        <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-lg mx-4"> 
            <!-- Left Side -->
            <div class="bg-sky-400 rounded-l-xl p-8 w-1/2 hidden md:flex flex-col justify-center items-center">
                <img src="{{ asset('images/white_icon.png') }}" class="h-20 my-5" alt="Gestão de Estágios Logo" />
                <div class="text-2xl font-extrabold text-white my-5">Bem-vindo de volta!</div>
                <p class="text-white text-base mb-8 text-center">Já possui uma conta no sistema? <br> Entre agora mesmo nela</p>
                <div class="mt-10">
                    <a href="{{ url('/login') }}" class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-6 transition-transform transform hover:scale-105 duration-300 ease-in-out">Entrar</a>
                </div>
            </div>

            <!-- Right Side -->
            <div class="bg-white rounded-xl md:rounded-r-xl p-8 w-full md:w-1/2 flex flex-col">
                <div class="text-xl font-extrabold text-center text-sky-400 mb-2 mt-5">Cria a minha conta</div>
                <p class="text-gray-400 font-bold text-base text-center mb-5">Preencha os seus dados</p>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Nome -->
                    <div class="mb-8 mt-3">
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"  width="1.6em" height="1.6em" class="mx-5"><g fill="none" stroke="#9c9c9c" stroke-linecap="round" stroke-linejoin="round" stroke-width="3"><circle cx="12" cy="8" r="5"/>
                                <path d="M20 21a8 8 0 0 0-16 0"/></g>
                            </svg>
                            
                            <!-- Input -->
                            <input type="name" id="name" name="name"  value="{{ old('name') }}" placeholder="Nome" class="block w-full bg-gray-100 border-0 focus:outline-none" required>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-8 mt-5">
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5">
                                <path fill="#9c9c9c" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"/>
                            </svg>
                            
                            <!-- Input -->
                            <input type="email" id="email" name="email"  value="{{ old('email') }}" placeholder="Email" class="block w-full bg-gray-100 border-0 focus:outline-none" required>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-8 mt-5">
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5"><g fill="none" stroke="#9c9c9c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/><circle cx="16.5" cy="7.5" r=".5" fill="#9c9c9c"/></g>
                            </svg>
                            
                            <!-- Input -->
                            <input type="password" id="password" name="password" placeholder="Password" class="block w-full bg-gray-100 border-0 focus:outline-none " required>
                        </div>
                    </div>

                    <!-- Perfil -->
                    <div class="mb-10">
                        <div class="flex items-center border border-sky-400 rounded-md shadow-sm p-2 bg-gray-100">
                            <!-- Ícone -->
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32" width="1.6em" height="1.6em" class="mx-5">
                                <path fill="#9c9c9c" d="M19 13h7v2h-7zm0-5h11v2H19zm0-5h11v2H19zm-8 27H7a2.006 2.006 0 0 1-2-2v-7a2.006 2.006 0 0 1-2-2v-6a2.947 2.947 0 0 1 3-3h6a2.947 2.947 0 0 1 3 3v6a2.006 2.006 0 0 1-2 2v7a2.006 2.006 0 0 1-2 2M6 12a.945.945 0 0 0-1 1v6h2v9h4v-9h2v-6a.945.945 0 0 0-1-1zm3-3a4 4 0 1 1 4-4a4.01 4.01 0 0 1-4 4m0-6a2 2 0 1 0 2 2a2.006 2.006 0 0 0-2-2"/>
                            </svg>
                            
                                <!-- Select -->
                                <select id="profile" name="profile" class="block w-full bg-gray-100 border-0 focus:outline-none text-gray-400 focus:text-black">
                                    <option value="" disabled selected class="text-gray-400">Selecione o seu perfil</option>
                                    <!-- <option value="Institution" class="text-black">Instituição</option> -->
                                    <option value="Company" class="text-black">Empresa</option>
                                    <!-- <option value="Responsible" class="text-black">Coordenador da Unidade Curricular</option> -->
                                    <!-- <option value="Student" class="text-black">Aluno</option> -->
                                </select>

                        </div>
                    </div>

                    <!-- Submit --> 
                    <div class="flex justify-center">
                        <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10" type="submit">Registar</button>
                    </div>
                    <div class="md:hidden flex justify-center mt-5">
                        <a href="{{ url('/login') }}" class="text-gray-400 text-md text-base"><u>Já tem conta?</u></a>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection


