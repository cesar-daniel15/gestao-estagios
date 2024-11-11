@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Instituições / Instituições')

@section('content')

    <!-- Alertas -->
    @if(session('success'))
        <div class="flex items-center p-4 mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ session('success') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-3" aria-label="Close">
                <span class="sr-only">Dispensar</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="flex items-center p-4 mb-4 text-red-800 border-t-4 border-red-300 bg-red-50 dark:text-red-400 dark:bg-gray-800 dark:border-red-800" role="alert">
            <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <div class="ms-3 text-sm font-medium">
                {{ session('error') }}
            </div>
            <button type="button" class="ms-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-border-2" aria-label="Close">
                <span class="sr-only">Dispensar</span>
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
            </button>
        </div>
    @endif

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Instituições Existentes
        </div>
        <div class="flex justify-between items-center my-5">
            <!-- Barra de pesquisa -->
            <form class="hidden sm:flex">
                <div class="relative w-auto">
                    <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Procurar Instituição" required />
                </div>
                <button type="submit" class="p-2.5 ms-2 text-sm font-medium text-white bg-sky-400 rounded-lg hover:bg-sky-500 focus:ring-4 focus:outline-none focus:ring-blue-300">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                    </svg>
                    <span class="sr-only">Procurar</span>
                </button>
            </form>

            <!-- Botão para criar Instituicao -->
            <button onclick="openCreateModal()" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl p-2.5 flex text-sm items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                    <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                </svg>
                Registrar Instituição
            </button>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome</th>
                        <th class="p-4 border-b text-gray-600">Acrónimo</th>
                        <th class="p-4 border-b text-gray-600">Email</th>
                        <th class="p-4 border-b text-gray-600">Contacto</th>
                        <th class="p-4 border-b text-gray-600">Website</th>
                        <th class="p-4 border-b text-gray-600">Conta Verificada</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($institutions as $institution)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 text-gray-600">{{ $institution['id'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['name'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['acronym'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['email'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['phone'] }}</td>
                                <td class="p-4 text-gray-600">
                                    <a href="{{ $institution['website'] }}" class="text-sky-400 hover:underline" target="_blank">{{ $institution['website'] }}</a>
                                </td>
                                <td class="p-4 text-gray-600">{{ $institution['account_is_verified'] }}</td>
                                <td class="p-4 text-gray-600">
                                    <div class="flex space-x-2 justify-center">
                                        <!-- Botão Ver -->
                                        <a href="{{ route('institutions.show', $institution['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                                <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                            </svg>
                                        </a>

                                        <!-- Botão Editar -->
                                        <a href="{{ route('institutions.update', $institution['id']) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                                <path fill="currentColor" d="m12.9 6.855l4.242 4.242l-9.9 9.9H3v-4.243zm1.414-1.415l2.121-2.121a1 1 0 0 1 1.414 0l2.829 2.828a1 1 0 0 1 0 1.415l-2.122 2.121z"/>
                                            </svg>
                                        </a>

                                        <!-- Botão Apagar -->
                                        <form id="deleteForm{{ $institution['id'] }}" action="{{ route('institutions.destroy', $institution['id']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="openDeleteModal({{ $institution['id'] }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded flex items-center">
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

    <!-- Modal Criar Nova Instituicao -->
    <div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Instituição</h2>

            <!-- Forma -->
            <form action="{{ route('institutions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 mb-1">Nome</label>
                    <input type="text" id="name" name="name" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="acronym" class="block text-gray-600 mb-1">Acrónimo</label>
                    <input type="text" id="acronym" name="acronym" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-600 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-600 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-600 mb-1">Contacto</label>
                    <input type="text" id="phone" name="phone" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-600 mb-1">Morada</label>
                    <input type="text" id="address" name="address" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="website" class="block text-gray-600 mb-1">Website</label>
                    <input type="url" id="website" name="website" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                </div>

                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeCreateModal()">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal de Confirmação -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-md font-smibold py-10 text-center text-gray-500">Tem a certeza que deseja apagar a instituição?</h2>
            <div class="flex justify-center space-x-5">
                <button class="bg-gray-500 hover:bg-gray-600 text-white p-2.5 font-bold rounded" onclick="closeDeleteModal()">Cancelar</button>
                <button id="confirmDeleteButton" class="bg-red-500 hover:bg-red-600 text-white p-2.5 font-bold rounded">Confirmar</button>
                </div>
        </div>
    </div>

    <!-- Modal de Visualizacao -->
    <div id="viewModal" class="fixed inset-0 items-center bg-black bg-opacity-50 justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg">
            <div class="modal-content">
                <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">{{ $institution['name'] }}</h2>
                <div class="modal-body flex text-base">
                    <!-- Coluna da imagem -->
                    <div class="flex-shrink-0 w-1/3">
                        <img src="{{ $institution['logo'] }}" alt="Logo" class="w-full h-52 object-cover">
                    </div>
                    
                    <!-- Coluna com as informações -->
                    <div class="ml-4 w-2/3">
                        <p><strong>Acrónimo:</strong> {{ $institution['acronym'] }}</p>
                        <p><strong>Email:</strong> {{ $institution['email'] }}</p>
                        <p><strong>Contacto:</strong> {{ $institution['phone'] }}</p>
                        <p><strong>Morada:</strong>  {{ $institution['address'] }}</p>
                        <p><strong>Website:</strong> <a href="{{ $institution['website'] }}" target="_blank">{{ $institution['website'] }}</a></p>
                        <p><strong>Conta Verificada:</strong> {{ $institution['account_is_verified'] }}</p>
                        <p><strong>Último Login:</strong> {{ $institution['last_login'] }}</p>
                        <p><strong>Data de Criação:</strong> {{ $institution['created_at'] }}</p>
                    </div>
                </div>
                <div class="modal-footer flex justify-end">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeViewModal()">Fechar</button>
                </div>
            </div>
        </div>
    </div>

    <script>
         // Abrir Modal para ver uma Instituicao
        function openViewModal() {
            const viewModal = document.querySelector('#viewModal');

            viewModal.style.display = 'flex';
            viewModal.classList.remove('hidden'); 
        }

        // Fechar Modal para ver uma Instituicao
        function closeViewModal() {
            const viewModal = document.querySelector('#viewModal');
            
            viewModal.style.display = 'none'; 
        }

        // Abrir Modal para criar nova Instituicao
        function openCreateModal() {
            const createModal = document.querySelector('#createModal');

            createModal.style.display = 'flex';
            createModal.classList.remove('hidden'); 
        }

        // Fechar Modal para criar nova Instituicao
        function closeCreateModal() {
            const createModal = document.querySelector('#createModal');
            
            createModal.style.display = 'none'; 
        }

        // Abrir Modal para apagar uma Instituicao
        function openDeleteModal(id) {
            const deleteModal = document.querySelector('#deleteModal');
            const deleteForm = document.querySelector('#deleteForm' + id);
            
            // Exibe o modal
            deleteModal.style.display = 'flex';
            deleteModal.classList.remove('hidden'); 

            // Seleciona o botão de confirmação
            const confirmDeleteButton = deleteModal.querySelector('#confirmDeleteButton');
            
            confirmDeleteButton.onclick = function () {
                deleteForm.submit(); // Submete o formulário 
            };
        }

        // Fechar Modal para apagar uma Instituicao
        function closeDeleteModal() {
            const deleteModal = document.querySelector('#deleteModal');
            
            deleteModal.style.display = 'none'; 
        }

    </script>

@endsection
