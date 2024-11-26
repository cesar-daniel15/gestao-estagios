@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false]) 

@section('title', 'Gestão de Estágios | Recuperar Password') 

@section('content')

@include('layouts.components.alert')

    <div class="flex justify-center items-center min-h-screen drop-shadow-2xl">
        <div class="flex w-full max-w-4xl bg-white rounded-xl shadow-lg mx-4"> 

            <!-- Left Side -->
            <div class="hidden md:flex flex-col items-center justify-start bg-sky-400 p-8 w-1/2 rounded-l-xl">
                <img src="{{ asset('images/white_icon.png') }}" class="my-5 h-16 md:h-20" alt="Gestão de Estágios Logo" />
                <div class="my-5 text-center font-extrabold text-white text-2xl">Problemas com a Password?</div>
                <p class="text-center text-white text-base">Insira o endereço de e-mail que você usou quando se inscreveu e nós lhe enviaremos instruções para redefinir sua senha.</p>
            </div>

            <!-- Right Side -->
            <div class="bg-white rounded-xl md:rounded-r-xl p-8 w-full md:w-1/2 flex flex-col">
                <div class="text-xl font-extrabold text-center text-sky-400 mb-2 mt-10">Recuperar Password</div>
                <p class="text-gray-400 font-bold text-base text-center mb-10">Preencha com o seu email</p>

                <form method="POST" action="{{ route('forgot-password') }}">
                    @csrf
                    <label for="email" class="sr-only">Email</label>
                    <div class="flex items-center rounded-md border border-sky-400 bg-gray-100 p-2 shadow-sm">

                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5">
                            <path fill="#9c9c9c" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"/>
                        </svg>

                        <input type="email" id="email" name="email" placeholder="Email" class="block w-full border-0 bg-gray-100 text-sm focus:outline-none md:text-base" required />
                    </div>

                    <!-- Submit button -->
                    <div class="flex justify-center">
                        <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-10 transition-transform transform hover:scale-105 duration-300 ease-in-out" type="submit">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection