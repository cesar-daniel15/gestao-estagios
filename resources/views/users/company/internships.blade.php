@extends('users.company.layouts.default-company')

@section('title', 'Gestão Estágios | Company Dashboard')

@section('page-name', 'Ofertas de Estágio')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Ofertas Existentes
        </div>
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

            <!-- Barra de pesquisa -->
            <div class="relative w-full md:w-auto mb-4 md:mb-0">
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" 
                    placeholder="Procurar por Oferta" oninput="searchInternshipOffer()" />
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                    <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                </svg>
            </div>

            <div class="flex gap-4">
                <!-- Botão para criar uma Oferta -->
                <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg p-2 flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                        <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                    </svg>
                    Registrar Oferta
                </button>

                <!-- Botão de Atualizar -->
                <form action="{{ route('company.internships.close') }}" method="POST">
                    @csrf
                    <div class="mt-4 md:mt-0 hidden md:flex">
                        <button id="refreshButton" type="submit" class="bg-info text-white font-bold p-2 rounde bg-teal-600 hover:bg-teal-500 rounded-lg text-sm flex items-center" onclick="refreshTable()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="mr-2">
                                <path fill="white" d="M12 20q-3.35 0-5.675-2.325T4 12t2.325-5.675T12 4q1.725 0 3.3.712T18 6.75V4h2v7h-7V9h4.2q-.8-1.4-2.187-2.2T12 6Q9.5 6 7.75 7.75T6 12t1.75 4.25T12 18q1.925 0 3.475-1.1T17.65 14h2.1q-.7 2.65-2.85 4.325T12 20"/>
                            </svg>
                            Atualizar
                        </button>
                    </div>
                </form>
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


        <!-- Tabela Ofertas de Estágio -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="internshipOffersTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Título</th>
                        <th class="p-4 border-b text-gray-600">Instituição</th>
                        <th class="p-4 border-b text-gray-600">Prazo</th>
                        <th class="p-4 border-b text-gray-600">Estado</th>
                        <th class="p-4 border-b text-gray-600"></th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($internship_offers))
                    <tr>
                        <td colspan="6" class="p-4 text-gray-600 text-center">Ainda não existem ofertas de estágio registadas</td>
                    </tr>
                @else
                    @foreach($internship_offers as $internship_offer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600">{{ $internship_offer['id'] }}</td>
                            <td class="p-4 text-gray-600 internship-title">{{ $internship_offer['title'] }}</td>
                            <td class="p-4 text-gray-600">{{ $internship_offer['institution']['acronym'] }}</td>
                            <td class="p-4 text-gray-600">{{ $internship_offer['deadline'] }}</td>
                            <td class="p-4 text-gray-600">
                                <span class="px-2 py-1 {{ $internship_offer['status'] == 'Aberto' ? 'bg-green-500' : ($internship_offer['status'] == 'Fechado' ? 'bg-red-500' : 'bg-yellow-500') }} text-white rounded-full">
                                    {{ $internship_offer['status'] }}
                                </span>
                            </td>                            
                            <td class="p-4 text-gray-600">
                                <div class="flex space-x-2 justify-center">
                                    
                                    <!-- Botão PDF -->
                                    <a href="{{ route('admin.internship_offers.download', $internship_offer['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                            <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/>
                                        </svg>
                                    </a>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Criar Nova Oferta de Estágio -->
    <div id="createModal" class="fixed inset-0 items-center justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Nova Oferta de Estágio</h2>

            <!-- Form -->
            <form action="{{ route('company.internships.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                    <!-- Título -->
                    <div>
                        <label for="title" class="block text-gray-600 mb-1">Título</label>
                        <input type="text" id="title" name="title" Placeholder="Oferta de Estágio (Empresa)" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <!-- Instituições -->
                    <div>
                        <label for="institution_id" class="block text-gray-600 mb-1">Instituição</label>
                        <select id="institution_id" name="institution_id" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" onchange="filterCourses()">
                            <option value="" disabled selected>Selecione uma instituição</option>
                            @foreach ($institutions as $institution)
                                <option value="{{ $institution['id'] }}">{{ $institution['acronym'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Cursos -->
                    <div>
                        <label for="course_id" class="block text-gray-600 mb-1">Curso</label>
                        <select id="course_id" name="course_id" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                            <option value="" disabled selected>Selecione um curso</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course['id'] }}" data-institution="{{ $course['institution_id'] }}">{{ $course['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Prazo -->
                    <div>
                        <label for="deadline" class="block text-gray-600 mb-1">Data limite</label>
                        <input type="date" id="deadline" name="deadline" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>


                    <!-- Descrição -->
                    <div class="sm:col-span-2">
                        <label for="description" class="block text-gray-600 mb-1">Descrição</label>
                        <textarea id="description" name="description" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" rows="4" required></textarea>
                    </div>
                </div>

                <div class="flex justify-center">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
            </form>
        </div>
    </div>


    <script>

        // Atualiza a pagina
        function refreshTable() {
            location.reload();
        }

        // Loader
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');
            const table = document.getElementById('internshipOffersTable');

            setTimeout(() => {
                loader.classList.add('hidden');
                table.classList.remove('hidden');
            }, 2000);
        });

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

        // Abrir Modal para apagar uma Oferta de Estágio
        function openDeleteModal(id) {
            openModal('deleteModal');

            const deleteForm = document.querySelector('#deleteForm' + id);
            const confirmDeleteButton = document.getElementById('confirmDeleteButton');
            confirmDeleteButton.onclick = function () {
                deleteForm.submit(); // Submete o formulário
            };
        }

        // Função de pesquisa de Ofertas de Estágio
        function searchInternshipOffer() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll("#internshipOffersTable tbody tr");

            rows.forEach(row => {
                const internshipName = row.querySelector(".internship-title").textContent.toLowerCase(); 

                if (internshipName.includes(searchValue)) {
                    row.style.display = ""; 
                } else {
                    row.style.display = "none";
                }
            });
        }

        function filterCourses() {
            const institutionId = document.getElementById('institution_id').value;
            const courseSelect = document.getElementById('course_id');
            const options = courseSelect.options;

            // Mostra ou esconde as opções de cursos com base na instituição selecionada
            for (let i = 0; i < options.length; i++) {
                const option = options[i];
                if (option.value === "") {
                    continue; 
                }
                if (option.getAttribute('data-institution') === institutionId) {
                    option.style.display = 'block';
                } else {
                    option.style.display = 'none'; 
                }
            }

            courseSelect.value = ""; 
        }

    </script>

@endsection