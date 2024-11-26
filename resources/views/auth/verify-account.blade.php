@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Verificar conta')

@section('content') 

@include('layouts.components.alert')

  <div class="flex min-h-screen items-center justify-center drop-shadow-2xl">
    <div class="mx-4 flex w-full max-w-5xl rounded-xl bg-white shadow-lg ">
      <!-- Left Side -->
      <div class="hidden w-1/2 flex-col items-center justify-center rounded-l-xl bg-sky-400 p-10 md:flex">
        <img src="{{ asset('images/white_icon.png') }}" class="my-5 h-16 md:h-20" alt="Gestão de Estágios Logo" />
        <div class="text-center font-extrabold text-white text-2xl">Verifique o seu email</div>
        <p class="text-center text-base text-white my-5">Enviamos um código de verificação de 5 dígitos para o seu e-mail. Se não encontrar o e-mail na sua caixa de entrada, verifique a pasta de spam ou lixo eletrônico.</p>
      </div>

      <!-- Right Side -->
      <div class="bg-white rounded-xl md:rounded-r-xl p-8 w-full md:w-1/2 flex flex-col justify-center items-center">
        <div class="text-xl font-extrabold text-center text-sky-400 mb-2 mt-10">Verificar conta</div>
        <p class="text-gray-400 font-bold text-base text-center mb-10">Introduza o código que recebeu</p>
        
        <form method="POST" action="{{ route('verify.account') }}">
          @csrf
          <div class="flex justify-center items-center">
            <input type="text" id="token" name="token" maxlength="5" inputmode="numeric" pattern="[0-9]*" class="h-12 w-60 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none tracking-[0.5em]">
          </div>
          
          <div class="flex justify-center">
            <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-10" type="submit">Confirmar</button>
          </div>
        </form>

      </div>
    </div>
  </div>

@endsection
