@extends('users.company.layouts.default-company')

@section('title', 'Gestão Estágios | Company Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-semibold text-sky-500 mb-6">
            Concluir Perfil
        </div>

        <!-- Formulário para preencher o perfil -->
        <form action="{{ route('company.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Lado Esquerdo -->
                <div class="flex-1 text-sm border border-gray rounded-lg p-5">
                    
                    <div class="mb-4">
                        <label for="name" class="block text-gray-600 mb-1">Nome</label>
                        <input type="text" id="name" name="name" value="{{ $user->name }}" class="border border-gray-300 rounded-lg w-full p-2" readonly>
                        </div>
                    
                    <div class="mb-4">
                        <label for="email" class="block text-gray-600 mb-1">Email</label>
                        <input type="email" id="email" name="email" value="{{ $user->email }}"  class="border border-gray-300 rounded-lg w-full p-2" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="phone" class="block text-gray-600 mb-1">Contato</label>
                        <input type="text" id="phone" name="phone" value="{{ $company->phone ?? ' ' }}"  class="border border-gray-300 rounded-lg w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label for="industry" class="block text-gray-600 mb-1">Industria</label>
                        <input type="text" id="industry" name="industry" value="{{ $company->industry ?? ' ' }}" class="border border-gray-300 rounded-lg w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label for="brief_description" class="block text-gray-600 mb-1">Breve Descrição</label>
                        <textarea id="brief_description" name="brief_description" class="border border-gray-300 rounded-lg w-full p-2">{{ $company->brief_description ?? '' }}</textarea>                    </div>

                    <div class="mb-4">
                        <label for="foundation_date" class="block text-gray-600 mb-1">Data de Fundação</label>
                        <input type="date" id="foundation_date" name="foundation_date" value="{{ $company->foundation_date ?? ' ' }}" class="border border-gray-300 rounded-lg w-full p-2">
                    </div>

                    <div class="mb-4">
                        <label for="address" class="block text-gray-600 mb-1">Morada</label>
                        <input type="text" id="address" name="address" value="{{ $company->address ?? ' ' }}" class="border border-gray-300 rounded-lg w-full p-2">
                    </div>

                </div>

                <!-- Lado Direito -->
                <div class="flex-1 flex flex-col items-center justify-center border border-gray rounded-lg text-sm p-5">
                    <label for="logo" class="block text-gray-600 mb-4">Logotipo</label>
                    <div class="w-48 h-48 border border-gray-300 rounded-lg flex items-center justify-center mb-4">
                        @if ($company->logo ?? false)
                            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logotipo Atual" class="w-full h-full object-contain rounded-lg">
                        @else
                            <span class="text-gray-400">Sem logo</span>
                        @endif
                    </div>

                    <div class="flex justify-center mb-4">
                        <input type="file" id="logo" name="logo" accept="image/*" class="block w-full text-sm text-gray-600">
                    </div>

                </div>
            </div>

            <!-- Botão de enviar -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-6 rounded-lg text-sm">
                    Atualizar Perfil
                </button>
            </div>
        </form>
    </div>

@endsection
