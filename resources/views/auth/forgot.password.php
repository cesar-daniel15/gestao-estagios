@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Recuperar Password')

@section('content')
<div class="flex min-h-screen items-center justify-center bg-gray-100">
  <div class="mx-4 flex flex-col lg:flex-row w-full max-w-5xl rounded-2xl bg-white shadow-lg">
    <!-- Left Side -->
    <div class="flex flex-col items-center justify-center w-full lg:w-1/2 rounded-t-2xl lg:rounded-l-2xl lg:rounded-r-none bg-sky-400 p-10">
      <img src="{{ asset('images/white_icon.png') }}" class="my-5 h-20 md:h-24" alt="Gestão de Estágios Logo" />
      <div class="my-5 text-xl md:text-3xl font-bold text-white text-center">Problemas com a Password?</div>
      <p class="text-center text-sm md:text-lg font-semibold text-white">Insira o endereço de e-mail que você usou quando se inscreveu e nós lhe enviaremos instruções para redefinir sua senha.</p>
    </div>

    <!-- Right Side -->
    <div class="flex flex-col justify-center w-full lg:w-1/2 rounded-b-2xl lg:rounded-r-2xl lg:rounded-l-none bg-white p-10">
      <div class="mb-5 text-center text-xl md:text-3xl font-bold text-sky-400">Recuperar password</div>
      <p class="mb-5 text-center text-gray-400 text-sm md:text-lg font-semibold">Preencha com o seu email</p>

      <form>
        <div class="mb-8">
          <label for="email" class="sr-only">Email</label>
          <div class="flex items-center rounded-md border border-sky-400 bg-gray-100 p-3 shadow-sm">
            <!-- Ícone de email -->
            <img src="{{ asset('images/icons/email.png') }}" alt="Email Icon" class="mx-5 h-5 w-5 md:h-6 md:w-6" />
            <!-- Input -->
            <input type="email" id="email" placeholder="Email" class="block w-full border-0 bg-gray-100 text-base md:text-lg font-semibold focus:outline-none" required />
          </div>
        </div>

        <!-- Submit button -->
        <div class="flex justify-center">
          <button class="transform rounded-md border border-white bg-sky-400 px-10 py-3 md:px-12 md:py-4 font-bold text-white transition-transform duration-300 ease-in-out hover:scale-105">Enviar</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
