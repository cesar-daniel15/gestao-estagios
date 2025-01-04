@extends('users.company.layouts.default-company')

@section('title', 'Gestão Estágios | Company Dashboard')

@section('page-name', 'Registos Diarios')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Registo Diários Existentes
        </div>
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

            <div class="flex flex-col md:flex-row">
                <!-- Barra de pesquisa -->
                <div class="relative w-full md:w-auto mb-4 md:mb-0">
                    <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" 
                        placeholder="Procurar por Registo" oninput="searchAttendanceRecord()" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                    </svg>
                </div>

                <!-- Filtro de Status -->
                <div class="relative w-auto md:ms-5 mt-4 md:mt-0">
                    <select id="search-status" class="bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" onchange="searchByStatus()">
                        <option value="" disabled selected>Procurar por Status</option>
                        <option value="Aprovado">Aprovado</option>
                        <option value="Rejeitado">Rejeitado</option>
                        <option value="Pendente">Pendente</option>
                    </select>
                    <svg xmlns="http://www.w3.org/2000/svg" width="1.3em" height="1.3em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                        <path fill="#9c9c9c" d="M2 8a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m0 4a1 1 0 0 1 1-1h18a1 1 0 1 1 0 2H3a1 1 0 0 1-1-1m1 3a1 1 0 1 0 0 2h12a1 1 0 1 0 0-2z"/>
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

        <!-- Tabela Registros de Presença -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="attendanceRecordTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Oferta de Estágio</th>
                        <th class="p-4 border-b text-gray-600">Data</th>
                        <th class="p-4 border-b text-gray-600">Horas de Aprovação</th>
                        <th class="p-4 border-b text-gray-600">Status de Aprovação</th>
                        <th class="p-4 border-b text-gray-600"></th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($attendance_records))
                    <tr>
                        <td colspan="9" class="p-4 text-gray-600 text-center">Ainda não existem registros de presença </td>
                    </tr>
                @else
                    @foreach($attendance_records as $attendance_record)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600">{{ $attendance_record['id'] }}</td>
                            <td class="p-4 text-gray-600 internship-offer">{{ $attendance_record['internship_offer_title'] ?? 'Oferta não disponível' }}</td>
                            <td class="p-4 text-gray-600">{{ $attendance_record['date'] }}</td>
                            <td class="p-4 text-gray-600">{{ $attendance_record['approval_hours'] }}</td>
                            <td class="p-4 text-gray-600 internship-offer-status">
                                <span class="px-2 py-1 {{ $attendance_record['approval_status'] == 'Aprovado' ? 'bg-green-500' : ($attendance_record['approval_status'] == 'Rejeitado' ? 'bg-red-500' : 'bg-yellow-500') }} text-white rounded-full">
                                    {{ $attendance_record['approval_status'] }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-600 flex items-center justify-center">
                                <form action="{{ route('company.attendance.approve', $attendance_record['id']) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-1 px-2 rounded flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 48 48" class="mr-1">
                                            <path fill="currentColor" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m4 24l5-5l10 10L39 9l5 5l-25 25z" clip-rule="evenodd"/>
                                        </svg>
                                        Aprovar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // Atualiza a página
        function refreshTable() {
            location.reload();
        }

        // Loader
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');
            const table = document.getElementById('attendanceRecordTable');

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

        // Função de pesquisa de Registros de Presença
        function searchAttendanceRecord() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll("#attendanceRecordTable tbody tr");

            rows.forEach(row => {
                const internshipOffer = row.querySelector(".internship-offer").textContent.toLowerCase();
                row.style.display = internshipOffer.includes(searchValue) ? "" : "none";
            });
        }

        // Pesquisar por status
        function searchByStatus() {
            const selectedStatus = document.getElementById('search-status').value;
            const rows = document.querySelectorAll("#attendanceRecordTable tbody tr");

            rows.forEach(row => {
                const statusElement = row.querySelector(".internship-offer-status span");
                const statusText = statusElement ? statusElement.textContent.trim() : "";

                row.style.display = (selectedStatus === "" || statusText === selectedStatus) ? "" : "none";
            });
        }

        // Funcao para mudar a cor da linha quando ela estiver selecionada
        function toggleRowHighlight(checkbox) {
            const row = checkbox.closest('tr'); 
            if (checkbox.checked) {
                row.classList.add('bg-blue-100'); 
            } else {
                row.classList.remove('bg-blue-100');
            }
        }
    </script>


@endsection