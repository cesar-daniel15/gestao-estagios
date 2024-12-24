@extends('users.student.layouts.default-student')

@section('title', 'Gestão Estágios | Student Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-semibold text-sky-500 mb-6">
            Concluir Perfil
        </div>

        <!-- Formulário para preencher o perfil -->
        <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label for="institution" class="block text-gray-600 mb-1">Instituição</label>
                        <input type="text" id="institution" name="institution" value="{{ $student && $student->ucs->isNotEmpty() ? $student->ucs->first()->course->institution->acronym : 'Não disponível' }}" class="border border-gray-300 rounded-lg w-full p-2" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="course" class="block text-gray-600 mb-1">Curso</label>
                        <input type="text" id="course" name="course" value="{{ $student && $student->ucs->isNotEmpty() ? $student->ucs->first()->course->name : 'Não disponível' }}" class="border border-gray-300 rounded-lg w-full p-2" readonly>
                    </div>
                    
                    <div class="mb-4">
                        <label for="phone" class="block text-gray-600 mb-1">Contato</label>
                        <input type="text" id="phone" name="phone" value="{{ $student->phone ?? ' ' }}"  class="border border-gray-300 rounded-lg w-full p-2">
                    </div>

                </div>

                <!-- Lado Direito -->
                <div class="flex-1 flex flex-col items-center justify-center border border-gray rounded-lg text-sm p-5">
                    <label for="picture" class="block text-gray-600 mb-4">Foto de Estudante</label>
                    <div class="w-48 h-48 border border-gray-300 rounded-lg flex items-center justify-center mb-4">
                        @if ($student->picture ?? false)
                            <img src="{{ asset('storage/' . $student->picture) }}" alt="Foto Atual" class="w-full h-full object-cover rounded-lg">
                        @else
                            <span class="text-gray-400">Sem Foto</span>
                        @endif
                    </div>

                    <div class="flex justify-center mb-4">
                        <input type="file" id="picture" name="picture" accept="image/*" class="block w-full text-sm text-gray-600">
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
