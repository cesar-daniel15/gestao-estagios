@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Utilizadores /')

@section('content')
    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Utilizadores Existentes
        </div>
        <div class="my-5">
            <!-- Barra de pesquisa -->
            <form class="flex justify-center md:justify-start">
                <div class="relative w-auto">
                    <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Procurar Utilizadores" required />
                </div>
                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-sky-400 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Procurar</span>
                </button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome</th>
                        <th class="p-4 border-b text-gray-600">Perfil</th>
                        <th class="p-4 border-b text-gray-600">Email</th>
                        <th class="p-4 border-b text-gray-600">Conta Verificada</th>
                        <th class="p-4 border-b text-gray-600">Último Login</th>
                        <th class="p-4 border-b text-gray-600">Data de Criação</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($allUsers as $user) 
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-600">{{ $user['id'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['name'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['profile'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['email'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['account_is_verified'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['last_login'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['created_at'] }}</td>
                        <td class="p-4 text-gray-600">
                            <div class="flex space-x-2 justify-center">
                                <!-- Button Ver -->
                                <a href="#" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                    </svg>
                                </a>

                                <!-- Botão Editar -->
                                <a href="" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path fill="currentColor" d="m12.9 6.855l4.242 4.242l-9.9 9.9H3v-4.243zm1.414-1.415l2.121-2.121a1 1 0 0 1 1.414 0l2.829 2.828a1 1 0 0 1 0 1.415l-2.122 2.121z"/>
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
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

