@extends('layouts.default-page', ['showNavbar' => false, 'showFooter' => false])

@section('title', 'Gestão de Estágios | Verificar conta')

@section('content') 
<div class="flex min-h-screen items-center justify-center drop-shadow-2xl">
  <div class="mx-4 flex w-full max-w-5xl rounded-xl bg-white shadow-lg">
    <!-- Left Side (Visible only on larger screens) -->
    <div class="hidden w-1/2 flex-col items-center justify-center rounded-l-xl bg-sky-400 p-10 md:flex">
      <!-- Oculta em telas menores -->
      <img src="{{ asset('images/white_icon.png') }}" class="my-5 h-24" alt="Gestão de Estágios Logo" />
      <div class="my-5 text-3xl font-extrabold text-white">Falta Pouco para Concluir! </div>
      <p class="text-center text-base text-white">Enviamos um código de verificação de 5 dígitos para o seu e-mail. Se não encontrar o e-mail na sua caixa de entrada, verifique a pasta de spam ou lixo eletrônico.</p>
    </div>
    <!-- Right Side -->
    <div class="flex w-full flex-col justify-center rounded-r-xl bg-white p-10 md:w-1/2">
      <!-- Mudando a largura para 100% em telas pequenas -->
      <div class="mb-5 text-center text-2xl font-extrabold text-sky-400">Verificar conta</div>
      <p class="mb-5 text-center text-gray-400">Introduza o código que recebeu</p>

      <div class="mb-10 flex justify-center space-x-4">
        <!-- Inputs para os 5 dígitos -->
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" id="digit-1" class="digit-input h-12 w-12 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none" />
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" id="digit-2" class="digit-input h-12 w-12 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none" />
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" id="digit-3" class="digit-input h-12 w-12 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none" />
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" id="digit-4" class="digit-input h-12 w-12 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none" />
        <input type="text" maxlength="1" inputmode="numeric" pattern="[0-9]*" id="digit-5" class="digit-input h-12 w-12 rounded-md border-2 border-sky-400 text-center text-xl focus:border-sky-500 focus:outline-none" />
      </div>

      <div class="flex justify-center">
        <button class="transform rounded-md bg-sky-400 px-10 py-3 font-bold text-white transition-transform duration-300 ease-in-out hover:scale-105">Confirmar</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Script para focar automaticamente no próximo campo ao digitar
  const inputs = document.querySelectorAll('.digit-input');

  inputs.forEach((input, index) => {
      input.addEventListener('input', (e) => {
          const value = e.target.value;

          // Permitir apenas números de 0 a 9
          if (!/^\d$/.test(value)) {
              e.target.value = '';  // Limpa o valor se não for número de 0 a 9
              return;
          }

          // Move para o próximo campo se tiver um valor e não for o último input
          if (value.length === 1 && index < inputs.length - 1) {
              inputs[index + 1].focus();
          }
      });

      input.addEventListener('keydown', (e) => {
          // Volta para o campo anterior ao pressionar "Backspace"
          if (e.key === 'Backspace' && !e.target.value && index > 0) {
              inputs[index - 1].focus();
          }
      });
  });
</script>
@endsection
