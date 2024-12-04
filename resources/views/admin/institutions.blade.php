@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Instituições / Instituições')

@section('content')

@include('admin.layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Instituições Existentes
        </div>
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

            <!-- Barra de pesquisa -->
            <div class="relative w-full md:w-auto mb-4 md:mb-0">
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2.5 text-start" 
                    placeholder="Procurar por Instituição" oninput="searchInstitution()" />
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                    <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                </svg>
            </div>

            <div class="flex gap-4">
                <!-- Botão para criar Instituição
                <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg p-2.5 flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                        <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                    </svg>
                    Registrar Instituição
                </button> -->

                <!-- Botão de Atualizar -->
                <div class="mt-4 md:mt-0 hidden md:flex">
                    <button id="refreshButton" class="bg-info text-white font-bold p-2.5 rounde bg-teal-600 hover:bg-teal-500 rounded-lg flex items-center" onclick="refreshTable()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="mr-2">
                            <path fill="white" d="M12 20q-3.35 0-5.675-2.325T4 12t2.325-5.675T12 4q1.725 0 3.3.712T18 6.75V4h2v7h-7V9h4.2q-.8-1.4-2.187-2.2T12 6Q9.5 6 7.75 7.75T6 12t1.75 4.25T12 18q1.925 0 3.475-1.1T17.65 14h2.1q-.7 2.65-2.85 4.325T12 20"/>
                        </svg>
                        Atualizar
                    </button>
                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="loader" class="text-center">
            <div role="status">
                <svg aria-hidden="true" class="inline w-8 h-8 text-gray-300 animate-spin fill-sky-400" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                </svg>
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <!-- Tabela Instituicoes -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="institutionTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome de Utilizador</th>
                        <th class="p-4 border-b text-gray-600">Acrónimo</th>
                        <th class="p-4 border-b text-gray-600">Contacto</th>
                        <th class="p-4 border-b text-gray-600">Website</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($institutions))
                    <tr>
                        <td colspan="7" class="p-4 text-gray-600 text-center">Ainda não existem instituições registadas </td>
                    </tr>
                @else
                    @foreach($institutions as $institution)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600">{{ $institution['id'] }}</td>
                            <td class="p-4 text-gray-600 institution-name">{{ $institution['user']['name'] ?? 'Nome não disponível' }}</td>
                            <td class="p-4 text-gray-600  acronym-name">{{ $institution['acronym'] }}</td>
                            <td class="p-4 text-gray-600">{{ $institution['phone'] }}</td>
                            <td class="p-4 text-gray-600">
                                <a href="{{ $institution['website'] }}" class="text-sky-400 hover:underline" target="_blank">{{ $institution['website'] }}</a>
                            </td>
                            <td class="p-4 text-gray-600">
                                <div class="flex space-x-2 justify-center">
                                        
                                    <!-- Botão Ver -->
                                    <a onclick="viewModal({{ $institution['id'] }},'{{ $institution['user']['name'] }}','{{ $institution['acronym'] }}', '{{ $institution['user']['email'] }}' , '{{ $institution['phone'] }}' , '{{ $institution['address'] }}' , '{{ $institution['website'] }}', '{{ $institution['created_at'] }}' , '{{ $institution['logo'] }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                            <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                        </svg>
                                    </a>

                                    <!-- Botão Update -->
                                    <button type="button" onclick="updateModal({{ $institution['id'] }}, '{{ $institution['acronym'] }}', '{{ $institution['phone'] }}', '{{ $institution['address'] }}', '{{ $institution['website'] }}', '{{ $institution['logo'] }}')" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                            <path fill="currentColor" d="m12.9 6.855l4.242 4.242l-9.9 9.9H3v-4.243zm1.414-1.415l2.121-2.121a1 1 0 0 1 1.414 0l2.829 2.828a1 1 0 0 1 0 1.415l-2.122 2.121z"/>
                                        </svg>
                                    </button>

                                    <!-- Botão Apagar -->
                                    <form id="deleteForm{{ $institution['id'] }}" action="{{ route('admin.institutions.destroy', $institution['id']) }}" method="POST">
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
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Criar Nova Instituição -->
    <div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Instituição</h2>

            <!-- Form -->
            <form action="{{ route('admin.institutions.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label for="acronym" class="block text-gray-600 mb-1">Acrónimo</label>
                        <input type="text" id="acronym" name="acronym" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="phone" class="block text-gray-600 mb-1">Contacto</label>
                        <input type="text" id="phone" name="phone" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="address" class="block text-gray-600 mb-1">Morada</label>
                        <input type="text" id="address" name="address" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="website" class="block text-gray-600 mb-1">Website</label>
                        <input type="url" id="website" name="website" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="logo" class="block text-gray-600 mb-1">Logo</label>
                        <input type="file" id="logo" name="logo" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
                
            </form>
        </div>
    </div>

    @if (!empty($institutions))

    <!-- Modal de Visualização -->
    <div id="viewModal" class="fixed inset-0 items-center bg-black bg-opacity-50 justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg relative w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <div class="modal-content flex flex-col">
                <h2 class="text-xl font-bold text-gray-700 mb-4 text-center" id="modal-name"></h2>
                <div class="modal-body flex flex-col md:flex-row">
                    <!-- Div para a imagem -->
                    <div class="w-full md:w-1/2 p-4 flex justify-center items-center" id="modal-logo">
                        <img src="{{ Storage::url($institution['logo']) }}" alt="Logo" class="w-full h-48 object-contain  rounded-2xl">
                    </div>
                    <!-- Div para os dados -->
                    <div class="w-full md:w-1/2 p-4 flex flex-col data-content">
                        <p><strong>ID:</strong> <span id="modal-id"></span> </p>
                        <p><strong>Acrónimo:</strong> <span id="modal-acronym"></span> </p>
                        <p><strong>Email:</strong> <span id="modal-email"></span> </p>
                        <p><strong>Contacto:</strong> <span id="modal-phone"></span> </p>
                        <p><strong>Morada:</strong> <span id="modal-address"></span> </p>
                        <p><strong>Website:</strong> <span id="modal-website"></span> </p>
                        <p><strong>Data de Criação:</strong> <span id="modal-created-at"></span> </p>
                    </div>
                </div>

                <div class="modal-footer flex justify-end absolute top-0 right-0 p-5">
                    <button type="button" class="text-gray-600 hover:text-gray-800 text-3xl font-bold" onclick="closeModal('viewModal')">×</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal de Update -->
    <div id="updateModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Atualizar Instituição</h2>

            <!-- Form -->
            <form id="updateForm" action="{{ route('admin.institutions.update', $institution['id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label for="acronym" class="block text-gray-600 mb-1">Acrónimo</label>
                        <input type="text" id="update_acronym" name="acronym" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="phone" class="block text-gray-600 mb-1">Contacto</label>
                        <input type="text" id="update_phone" name="phone" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="address" class="block text-gray-600 mb-1">Morada</label>
                        <input type="text" id="update_address" name="address" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="website" class="block text-gray-600 mb-1">Website</label>
                        <input type="url" id="update_website" name="website" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="logo" class="block text-gray-600 mb-1">Logo</label>
                        <input type="file" id="update_logo" name="logo" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>
                    
                </div>

                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('updateModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Atualizar</button>
                </div>

            </form>
        </div> 
    </div>

    <!-- Modal de Confirmação -->
    <div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg w-1/3">

            <h2 class="text-md font-smibold py-10 text-center text-gray-500">Tem a certeza que deseja apagar a instituição?</h2>

            <div class="flex justify-center space-x-5">
                <button class="bg-gray-500 hover:bg-gray-600 text-white p-2.5 font-bold rounded" onclick="closeModal('deleteModal')">Cancelar</button>
                <button id="confirmDeleteButton" class="bg-red-500 hover:bg-red-600 text-white p-2.5 font-bold rounded">Confirmar</button>
            </div>
        </div>
    </div>

    @endif

    <script>

        // Atualiza a pagina
        function refreshTable() {
            location.reload();
        }

        // Loader
        document.addEventListener('DOMContentLoaded', 
        function () {
            const loader = document.getElementById('loader');
            const table = document.getElementById('userTable');

            setTimeout(() => {
                loader.classList.add('hidden'); 
                table.classList.remove('hidden'); 
            }, 2000);
        });

        // Funcao para abrir o modal
        function openModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
        }

        // Funcao  para fechar o modal
        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
            modal.classList.add('hidden');
        }

        // Funcao para modal de view das instituicoes
        function viewModal(id, name, acronym, email, phone, address, website, createdAt, logo) {
            document.querySelector('#viewModal .modal-content h2').textContent = name;
            document.querySelector('#viewModal .modal-body #modal-logo').innerHTML = `
                <img src="${logo}" alt="Logo" class="w-full h-48 object-contain">
            `;
            document.querySelector('#viewModal .modal-body .data-content').innerHTML = `
                <div class="ml-4 flex flex-col gap-5">
                    <p><strong>ID:</strong> ${id}</p>
                    <p><strong>Acrónimo:</strong> ${acronym}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Contacto:</strong> ${phone}</p>
                    <p><strong>Morada:</strong> ${address}</p>
                    <p><strong>Website:</strong> <a href="${website}" target="_blank">${website}</a></p>
                    <p><strong>Data de Criação:</strong> ${createdAt}</p>
                </div>
            `;

            openModal('viewModal');
        }

        // Abrir Modal para apagar uma Instituicao
        function openDeleteModal(id) {
            openModal('deleteModal');  

            const deleteForm = document.querySelector('#deleteForm' + id);
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            confirmDeleteButton.onclick = function () {
                deleteForm.submit(); // Submete o Form 
            };
        }

        // Abrir Modal para fazer uma atualizacao de uma Instituicao
        function updateModal(id, acronym, phone, address, website, logo) {
            openModal('updateModal');  

            document.getElementById('update_acronym').value = acronym;
            document.getElementById('update_phone').value = phone;
            document.getElementById('update_address').value = address;
            document.getElementById('update_website').value = website 
            const currentLogo = document.getElementById('current_logo');
            currentLogo.src = logo; 

            const updateForm = document.getElementById('updateForm');
            updateForm.action = `/admin/institutions/${id}`; 
        }

        // Funcao de pesquisa de Instituicoes
        function searchInstitution() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll("#institutionTable tbody tr");

            rows.forEach(row => {
                const institutionName = row.querySelector(".institution-name").textContent.toLowerCase();
                row.style.display = institutionName.includes(searchValue) ? "" : "none";

                const acronymName = row.querySelector(".acronym-name").textContent.toLowerCase();
                row.style.display = acronymName.includes(searchValue) ? "" : "none";
            });
        }

        // Loader
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');
            const table = document.getElementById('institutionTable');

            setTimeout(() => {
                loader.classList.add('hidden'); 
                table.classList.remove('hidden'); 
            }, 2000);
        });

    </script>


@endsection
