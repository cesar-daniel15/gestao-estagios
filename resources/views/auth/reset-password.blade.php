@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Redefinir Password')

@section('content') 

@include('layouts.components.alert')

<div class="flex min-h-screen items-center justify-center drop-shadow-2xl">
    <div class="mx-4 flex w-full max-w-5xl rounded-xl bg-white shadow-lg ">
    <!-- Left Side -->
    <div class="hidden w-1/2 flex-col items-center justify-center rounded-l-xl bg-sky-400 p-10 md:flex">
        <img src="{{ asset('images/white_icon.png') }}" class="my-5 h-16 md:h-20" alt="Gestão de Estágios Logo" />
        <div class="text-center font-extrabold text-white text-2xl">Redefina a sua password</div>
        <p class="text-center text-base text-white my-5">Insira a nova password nos campos para redefini-la.<br>Certifique-se de escolher uma password forte para proteger a sua conta.</p>
    </div>

    <!-- Right Side -->
    <div class="bg-white rounded-xl md:rounded-r-xl p-8 w-full md:w-1/2 flex flex-col justify-center items-center">
        <div class="text-xl font-extrabold text-center text-sky-400 mb-2 mt-10">Redefinir Password</div>
        <p class="text-gray-400 font-bold text-base text-center mb-10">Preencha os campos para redefinir sua password</p>
        
        <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        
        <!-- Email -->
        <div class="mb-7">
            <label for="email" class="sr-only">Email</label>
            <div class="flex items-center rounded-md border border-sky-400 bg-gray-100 p-2 shadow-sm">
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5">
                    <path fill="#9c9c9c" d="M22 6c0-1.1-.9-2-2-2H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2zm-2 0l-8 5l-8-5zm0 12H4V8l8 5l8-5z"/>
                </svg>

                <input type="email" id="email" name="email" placeholder="Email" class="block w-full border-0 bg-gray-100 text-sm focus:outline-none md:text-base" value="{{ $email ?? old('email') }}" required autofocus>
            </div>
        </div>

        <!-- Nova Password -->
        <div class="mb-7">
            <label for="password" class="sr-only">Nova Senha</label>
            <div class="flex items-center rounded-md border border-sky-400 bg-gray-100 p-2 shadow-sm">

                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5">
                    <g fill="none" stroke="#9c9c9c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/>
                        <circle cx="16.5" cy="7.5" r=".5" fill="#9c9c9c"/>
                    </g>
                </svg>

                <input type="password" id="password" name="password" placeholder="Nova Senha" class="block w-full border-0 bg-gray-100 text-sm focus:outline-none md:text-base" required>
            </div>
        </div>

        <!-- Confirmar Nova Password -->
        <div class="mb-7">
            <label for="password_confirmation" class="sr-only">Confirmar Nova Senha</label>
            <div class="flex items-center rounded-md border border-sky-400 bg-gray-100 p-2 shadow-sm">
                
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="1.6em" height="1.6em" class="mx-5">
                    <g fill="none" stroke="#9c9c9c" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"/>
                        <circle cx="16.5" cy="7.5" r=".5" fill="#9c9c9c"/>
                    </g>
                </svg>

                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmar Nova Senha" class="block w-full border-0 bg-gray-100 text-sm focus:outline-none md:text-base" required>
            </div>
        </div>
    
        <div class="flex justify-center">
            <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10" type="submit">Redefinir</button>
        </div>
        </form>

    </div>
    </div>
</div>

@endsection
