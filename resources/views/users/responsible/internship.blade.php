@extends('users.responsible.layouts.default-responsible')

@section('title', 'Gestão Estágios | Responsible Dashboard')

@section('page-name', 'Estágios')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Ofertas de Estágio Disponiveis
        </div>

        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

        <div class="flex flex-col md:flex-row">

            <!-- Barra de pesquisa -->
            <div class="relative w-full md:w-auto mb-4 md:mb-0">
                <input type="text" id="search-title" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" placeholder="Procurar por Título" oninput="searchTitle()" />
                <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                    <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                </svg>
            </div>

        </div>

        <div class="flex gap-4">
            <!-- Botão de Atualizar -->
            <div class="mt-4 md:mt-0 hidden md:flex">
                <button id="refreshButton" class="bg-info text-white font-bold p-2 rounde bg-teal-600 hover:bg-teal-500 rounded-lg text-sm flex items-center" onclick="refreshTable()">
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


        <!-- Tabela Ofertas de Estágio -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="internshipOffersTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Título</th>
                        <th class="p-4 border-b text-gray-600">Aluno</th>
                        <th class="p-4 border-b text-gray-600">Empresa</th>
                        <th class="p-4 border-b text-gray-600">Prazo</th>
                        <th class="p-4 border-b text-gray-600">Estado</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($internship_offers))
                    <tr>
                        <td colspan="7" class="p-4 text-gray-600 text-center">Ainda não existem ofertas de estágio registadas</td>
                    </tr>
                @else
                    @foreach($internship_offers as $internship_offer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600">{{ $internship_offer['id'] }}</td>
                            <td class="p-4 text-gray-600 internship-title">{{ $internship_offer['title'] }}</td>
                            <td class="p-4 text-gray-600 internship-title">{{ $internship_offer['student']['users']['name'] }}</td>
                            <td class="p-4 text-gray-600 company-name">{{ $internship_offer['company']['users']['name'] }}</td>
                            <td class="p-4 text-gray-600">{{ $internship_offer['deadline'] }}</td>
                            <td class="p-4 text-gray-600">
                                <span class="px-2 py-1 {{ $internship_offer['plan']['status'] == 'Aprovado' ? 'bg-green-500' : ($internship_offer['plan']['status']== 'Rejeitado' ? 'bg-red-500' : 'bg-yellow-500') }} text-white rounded-full">
                                    {{ $internship_offer['plan']['status'] }}
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

                                    <!-- Botão para Abrir Modal -->
                                    <button onclick="agreementModal({{ $internship_offer['plan']['id'] }})" 
                                        class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                            <path fill="currentColor" d="m17.275 20.25l3.475-3.45l-1.05-1.05l-2.425 2.375l-.975-.975l-1.05 1.075zM6 9h12V7H6zm12 14q-2.075 0-3.537-1.463T13 18t1.463-3.537T18 13t3.538 1.463T23 18t-1.463 3.538T18 23M3 22V5q0-.825.588-1.412T5 3h14q.825 0 1.413.588T21 5v6.675q-.7-.35-1.463-.513T18 11H6v2h7.1q-.425.425-.787.925T11.675 15H6v2h5.075q-.05.25-.062.488T11 18q0 1.05.288 2.013t.862 1.837L12 22l-1.5-1.5L9 22l-1.5-1.5L6 22l-1.5-1.5z"/>
                                        </svg>
                                    </button>

                                    <!-- Botão para Abrir o Modal -->
                                    <button onclick="associateModal({{ $internship_offer['id'] }}, {{ json_encode($students) }})" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                            <path fill="#fff" d="m21.7 13.35l-1 1l-2.05-2.05l1-1a.55.55 0 0 1 .77 0l1.28 1.28c.21.21.21.56 0 .77M12 18.94l6.06-6.06l2.05 2.05L14.06 21H12zM12 14c-4.42 0-8 1.79-8 4v2h6v-1.89l4-4c-.66-.08-1.33-.11-2-.11m0-10a4 4 0 0 0-4 4a4 4 0 0 0 4 4a4 4 0 0 0 4-4a4 4 0 0 0-4-4"/>
                                        </svg>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>


    @if (!empty($internship_offers))

    <!-- Modal Concordar ou Não Concordar -->
    <div id="agreementModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white w-auto sm:w-[800px] p-8 rounded-lg shadow-lg max-w-full">
            <h2 id="modalTitle" class="text-lg font-bold mb-6 text-center text-black">
                Você Concorda com o Plano de Estágio?
            </h2>
            <form id="agreeForm" action="{{ route('responsible.internships.agree', $internship_offer['plan']['id']) }}" method="POST">
                @csrf 
                <div class="mb-6 flex justify-center space-x-4 w-full">
                    <button name="approved_by_uc" value="1" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 px-6 w-full sm:w-48 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="mr-2">
                            <path fill="white" d="m14.83 4.89l1.34.94l-5.81 8.38H9.02L5.78 9.67l1.34-1.25l2.57 2.4z"/>
                        </svg>
                        Concordo
                    </button>

                    <button name="approved_by_uc" value="0" class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-6 w-full sm:w-48 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" class="mr-2">
                            <path fill="white" d="m12.12 10l3.53 3.53l-2.12 2.12L10 12.12l-3.54 3.54l-2.12-2.12L7.88 10L4.34 6.46l2.12-2.12L10 7.88l3.54-3.53l2.12 2.12z"/>
                        </svg>
                        Não Concordo
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal para Atribuir Estágio a Aluno -->
    <div id="associateModal" class="fixed inset-0 bg-black bg-opacity-50 items-center justify-center z-50 hidden">
        <div class="bg-white w-auto sm:w-[400px] h-auto p-6 rounded-lg shadow-lg flex flex-col justify-center items-center">

            <h2 id="modalTitle" class="text-lg font-bold mb-4 text-center">
                Atribuir Estágio a Aluno
            </h2>
            
            <p class="text-center mb-4">Selecione o aluno para atribuir o estágio</p>

            <form action="{{ route('responsible.internships.associate', $internship_offer['id']) }}" method="POST">
                @csrf
                <div class="mb-4 p-5">
                    <select id="student_id" name="student_id" class="border border-gray-300 rounded-lg w-full p-2">
                        <option value="">Selecione um aluno</option>

                    </select>
                </div>

                <div class="flex justify-end space-x-4 w-full">
                    <button type="button" onclick="closeModal('associateModal')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">Fechar</button>
                    <button type="submit" class="bg-green-500 hover:bg-green- 600 text-white font-bold py-2 px-4 rounded">Atribuir</button>
                </div>
            </form>
        </div>
    </div>

@endif

    <script>

    // Atualiza a pagina
    function refreshTable() {
        location.reload();
    }

    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('loader');
        const table = document.getElementById('internshipOffersTable'); 

        if (loader && table) { 
            setTimeout(() => {
                loader.classList.add('hidden'); 
                table.classList.remove('hidden'); 
            }, 2000);
        }
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

    // Função de pesquisa de Ofertas de Estágio
    function searchTitle() {
        const searchValue = document.getElementById('search-title').value.toLowerCase(); 
        const rows = document.querySelectorAll("#internshipOffersTable tbody tr");

        rows.forEach(row => {
            const internshipTitle = row.querySelector(".internship-title").textContent.toLowerCase(); 

            if (internshipTitle.includes(searchValue)) {
                row.style.display = ""; 
            } else {
                row.style.display = "none"; 
            }
        });
    }

    function agreementModal(id) {
        openModal('agreementModal');

        const agreeForm = document.getElementById('agreeForm');
        agreeForm.action = `/responsible/internships/${id}`; 
    }

    function associateModal(id, students) {
        openModal('associateModal');

        const studentSelect = document.getElementById('student_id');
        studentSelect.innerHTML = '<option value="">Selecione um aluno</option>'; 

        students.forEach(student => {
            if (student.pending_internship_offer_id == id) {
                const option = document.createElement('option');
                option.value = student.id;
                option.textContent = student.user.name; 
                studentSelect.appendChild(option);
            }
        });
    }

    </script>


@endsection   