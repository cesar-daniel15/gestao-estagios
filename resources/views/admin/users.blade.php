@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Utilizadores /')

@section('content')
    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Utilizadores Existentes
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome</th>
                        <th class="p-4 border-b text-gray-600">Perfil</th>
                        <th class="p-4 border-b text-gray-600">Email</th>
                        <th class="p-4 border-b text-gray-600">Password</th>
                        <th class="p-4 border-b text-gray-600">Conta Verificada</th>
                        <th class="p-4 border-b text-gray-600">Último Login</th>
                        <th class="p-4 border-b text-gray-600">Data de Criação</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-600">1</td>
                        <td class="p-4 text-gray-600">Dj8 CR8</td>
                        <td class="p-4 text-gray-600">Aluno</td>
                        <td class="p-4 text-gray-600">dj8cr8@gmail.com</td>
                        <td class="p-4 text-gray-600">arroz.dj8</td>
                        <td class="p-4 text-gray-600">Sim</td>
                        <td class="p-4 text-gray-600">2024-10-15 14:32</td>
                        <td class="p-4 text-gray-600">2023-09-01</td>
                        <td class="p-4 text-gray-600">
                            <div class="flex space-x-2 justify-center">
                                <!-- Button Editar -->
                                <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                    </svg>
                                </a>

                                <!-- Button Apagar -->
                                <form action="#" method="">
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7h16m-10 4v6m4-6v6M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2l1-12M9 7V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v3"/>
                                        </svg>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection

