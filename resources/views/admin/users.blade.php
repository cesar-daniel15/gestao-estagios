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
                <div class="flex">
                    <div class="relative w-full">
                        <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2.5 text-start" 
                            placeholder="Procurar por Utilizador" oninput="searchUser()" />
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                            <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                        </svg>
                    </div>
                </div>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl" id="userTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome</th>
                        <th class="p-4 border-b text-gray-600">Perfil</th>
                        <th class="p-4 border-b text-gray-600">Email</th>
                        <th class="p-4 border-b text-gray-600">Conta Verificada</th>
                        <th class="p-4 border-b text-gray-600">Último Login</th>
                        <th class="p-4 border-b text-gray-600">Data de Criação</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($users as $user) 
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-600">{{ $user['id'] }}</td>
                        <td class="p-4 text-gray-600 user-name">{{ $user['name'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['profile'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['email'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['account_is_verified'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['last_login'] }}</td>
                        <td class="p-4 text-gray-600">{{ $user['updated_at'] }}</td>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

<script>
    function searchUser() {
            const searchValue = document.getElementById('search').value.toLowerCase();

            // Seleciona todas as linhas da tabela
            const rows = document.querySelectorAll("#userTable tbody tr");

            rows.forEach(row => {
                const userName = row.querySelector(".user-name").textContent.toLowerCase();

                if (userName.includes(searchValue)) {
                    row.style.display = "";  // Mostra a linha
                } else {
                    row.style.display = "none";  // Esconde a linha
                }
            });
        }

        
</script>

@endsection

