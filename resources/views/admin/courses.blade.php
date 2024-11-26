@extends('admin.layouts.default-admin')

@section('title', 'Gestão de Cursos | Admin Dashboard')

@section('page-name', 'Instituições / Cursos')

@section('content')

    <!-- Alerta de Sucesso -->
    @if(session('success'))
        <div class="fixed top-5 right-5 max-w-xs p-4 text-white bg-green-600 border-l-4 border-green-800 rounded-lg shadow-lg animate-fade-out opacity-100 transition-opacity animate-slide-in-out px-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-semibold">Sucesso!</span>
            </div>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Alerta de Erro -->
    @if(session('error'))
        <div class="fixed top-5 right-5 max-w-xs p-4 text-white bg-red-600 border-l-4 border-red-800 rounded-lg shadow-lg animate-fade-out opacity-100 transition-opacity animate-slide-in-out px-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-semibold">Erro!</span>
            </div>
            <p class="text-sm">{{ session('error') }}</p>
        </div>
    @endif

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Cursos Existentes
        </div>
    <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">
        <!-- Barra de pesquisa -->
        <div class="flex">
            <div class="relative w-full">
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2.5 text-start" 
                    placeholder="Procurar por Curso" oninput="searchCourse()" />
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                    <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                </svg>
            </div>
        </div>

        <!-- Botão para criar Curso -->
        <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl p-2.5 flex text-sm items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
            </svg>
            Registrar Curso
        </button>
    </div>

    <!-- Tabela Cursos -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl" id="courseTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 border-b text-gray-600">ID</th>
                    <th class="p-4 border-b text-gray-600">Instituição</th>
                    <th class="p-4 border-b text-gray-600">Nome</th>
                    <th class="p-4 border-b text-gray-600">Acrónimo</th>
                    <th class="p-4 border-b text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $course)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-600">{{ $course['id'] }}</td>
                        <td class="p-4 text-gray-600">{{ $course['institution']['name'] ?? 'N/A' }}</td> <!-- Verifica se a chave existe -->
                        <td class="p-4 text-gray-600 course-name">{{ $course['name'] }}</td>
                        <td class="p-4 text-gray-600">{{ $course['acronym'] }}</td>
                        <td class="p-4 te xt-gray-600">
                        <div class="flex space-x-2 justify-center">
    
                        <div class="flex space-x-2 justify-center">
    
                            <!-- Botão Ver -->
                            <a href="javascript:void(0)" onclick="openViewModal(this)" 
                            data-id="{{ $course['id'] }}"
                            data-institution_id="{{ $course['institution']['name'] }}"
                            data-name="{{ $course['name'] }}" 
                            data-acronym="{{ $course['acronym'] }}" 
                            data-createdat="{{ $course['created_at'] }}" 
                            class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                </svg>
                            </a>

                            <!-- Botão Update -->
                            <button type="button" onclick="openUpdateModal({{ $course['id'] }}, '{{ $course['name'] }}', '{{ $course['acronym'] }}', {{ $course['institution_id']}})" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                    <path fill="currentColor" d="m12.9 6.855l4.242 4.242l-9.9 9.9H3v-4.243zm1.414-1.415l2.121-2.121a1 1 0 0 1 1.414 0l2.829 2.828a1 1 0 0 1 0 1.415l-2.122 2.121z"/>
                                </svg>
                            </button>

                            <!-- Botão Apagar -->
                            <form id="deleteForm{{ $course['id'] }}" action="{{ route('admin.courses.destroy', $course['id']) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="openDeleteModal({{ $course['id'] }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded flex items-center">
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

<!-- Modal para registro -->
<div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
        <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Novo Curso</h2>

        <!-- Form -->
        <form action="{{ route('admin.courses.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
            
            <div>
                <label for="institution_id" class="block text-gray-600 mb-1">*Nome da Instituição</label>
                <select id="institution_id" name="institution_id" required class="form-input mt-1 block w-full border rounded-md py-2 px-4">
                    <option value="" selected disabled>Selecione uma instituição</option>
                    @foreach($institutions as $institution)
                    <option value="{{ $institution['id'] }}">{{ $institution['name'] }}</option>
                    @endforeach
                </select>
            </div>

                <div>
                    <label for="course_name" class="block text-gray-600 mb-1">*Nome do Curso</label>
                    <input type="text" name="name" id="course_name" required class="form-input mt-1 block w-full border rounded-md py-2 px-4">
                </div>

                <div>
                    <label for="acronym" class="block text-gray-600 mb-1">*Acrónimo</label>
                    <input type="text" name="acronym" id="acronym" required class="form-input mt-1 block w-full border rounded-md py-2 px-4">
                </div>
            </div>

            <p class="text-center my-2">* Obrigatório</p>

            <div class="flex justify-center">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
            </div>
        </form>
    </div>
</div>

    <!-- Modal de Visualizacao -->
    <div id="viewModal" class="fixed inset-0 items-center bg-black bg-opacity-50 justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-lg relative">
                <div class="modal-content">
                    <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">{{ $course['name'] }}</h2>
                    <div class="modal-body flex text-base px-5">

                        <!-- Lado com as informações -->
                        <div class="ml-4 space-y-4 flex flex-col">
                            <p><strong>ID:</strong> {{ $course['id'] }}</p>
                            <p><strong>Instituição:</strong> {{ $course['institution']['name'] }}</p>
                            <p><strong>Nome do Curso:</strong> {{ $course['name'] }}</p>
                            <p><strong>Acrónimo:</strong> {{ $course['acronym'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer flex justify-end absolute top-0 right-0 p-5">
                    <button type="button" class="text-gray-600 hover:text-gray-800 text-3xl font-bold" onclick="closeModal('viewModal')">×</button>
                </div>
    </div>           

    <!-- Modal de Update -->
    <div id="updateModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Atualizar Curso</h2>

            <!-- Form -->
            <form id="updateForm" action="{{ route('admin.courses.update', $course['id']) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="name" class="block text-gray-600 mb-1">Nome</label>
                        <input type="text" id="update_name" name="name" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="acronym" class="block text-gray-600 mb-1">Acrónimo</label>
                        <input type="text" id="update_acronym" name="acronym" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                    </div>

                    <div>
                        <label for="institution_id" class="block text-gray-600 mb-1">Instituição</label>
                        <input type="text" id="update_institution_id" name="institution_id" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" disabled>
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
        
        <h2 class="text-md font-smibold py-10 text-center text-gray-500">Tem a certeza que deseja apagar o curso?</h2>
        
        <div class="flex justify-center space-x-5">
            <button class="bg-gray-500 hover:bg-gray-600 text-white p-2.5 font-bold rounded" onclick="closeModal('deleteModal')">Cancelar</button>
            <button id="confirmDeleteButton" class="bg-red-500 hover:bg-red-600 text-white p-2.5 font-bold rounded">Confirmar</button>
        </div>
    </div>
</div>



<script>
    // Função para abrir o modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'flex';
        modal.classList.remove('hidden');
    }

    // Função para fechar o modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    // Abrir Modal para visualizar um Curso
    function openViewModal(element) {
        openModal('viewModal');

        const viewModal = document.getElementById('viewModal');

        viewModal.querySelector('h2').textContent = element.dataset.name;
        viewModal.querySelector('p:nth-child(1)').innerHTML = `<strong>ID:</strong> ${element.dataset.id}`;
        viewModal.querySelector('p:nth-child(2)').innerHTML = `<strong>Instituição:</strong> ${element.dataset.institution_id}`;        
        viewModal.querySelector('p:nth-child(3)').innerHTML = `<strong>Nome do Curso:</strong> ${element.dataset.name}`;
        viewModal.querySelector('p:nth-child(4)').innerHTML = `<strong>Acrónimo:</strong> ${element.dataset.acronym}`;
    }

    // Abrir Modal para apagar um Curso
    function openDeleteModal(id) {
        openModal('deleteModal');

        const deleteForm = document.querySelector('#deleteForm' + id);
        const confirmDeleteButton = document.getElementById('confirmDeleteButton');
        confirmDeleteButton.onclick = function () {
            deleteForm.submit(); // Submete o Form
        };
    }

    // Abrir Modal para fazer uma atualização de um Curso
    function openUpdateModal(id, name, acronym, institution_id) {
        openModal('updateModal');

        document.getElementById('update_name').value = name;
        document.getElementById('update_acronym').value = acronym;
        document.getElementById('update_institution_id').value = institution_id;

        const updateForm = document.getElementById('updateForm');
        updateForm.action = `/admin/courses/${id}`; 
    }

    // Função de pesquisa de Cursos
    function searchCourse() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll("#courseTable tbody tr");

        rows.forEach(row => {
            const courseName = row.querySelector(".course-name").textContent.toLowerCase();
            row.style.display = courseName.includes(searchValue) ? "" : "none";
        });
    }

</script>

@endsection