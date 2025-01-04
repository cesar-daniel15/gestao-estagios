@extends('users.institution.layouts.default-institution')

@section('title', 'Gestão Estágios | Institution Dashboard')

@section('page-name', 'Estágios')

@section('content')

@include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
            <div class="text-lg font-bold text-gray-600 mb-6">
                Estágio para Avaliar
            </div>
            <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

                <!-- Barra de pesquisa -->
                <div class="relative w-full md:w-auto mb-4 md:mb-0">
                    <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" 
                        placeholder="Procurar por Relatorio" oninput="searchReport()" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                    </svg>
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

            <!-- Tabela Relatórios Finais -->
            <div class="overflow-x-auto">
                <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="finalReportTable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-4 border-b text-gray-600">ID</th>
                            <th class="p-4 border-b text-gray-600">Nome Oferta</th>
                            <th class="p-4 border-b text-gray-600">Avaliação Empresa</th>
                            <th class="p-4 border-b text-gray-600">Avaliação Final</th>
                            <th class="p-4 border-b text-gray-600">Total Horas</th>
                            <th class="p-4 border-b text-gray-600">Total Dias</th>
                            <th class="p-4 border-b text-gray-600">Status</th>
                            <th class="p-4 border-b text-gray-600">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    @if (empty($final_reports))
                        <tr>
                            <td colspan="8" class="p-4 text-gray-600 text-center">Ainda não existem relatórios finais registados</td>
                        </tr>
                    @else
                        @foreach($final_reports as $final_report)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 text-gray-600">{{ $final_report['id'] }}</td>
                                <td class="p-4 text-gray-600 finalReport-title">{{ $final_report['internship_offer_title'] }}</td>
                                <td class="p-4 text-gray-600">{{ $final_report['company_evaluation'] }}</td>
                                <td class="p-4 text-gray-600">{{ $final_report['final_evaluation'] }}</td>
                                <td class="p-4 text-gray-600">{{ $final_report['total_hours'] }}</td>
                                <td class="p-4 text-gray-600">{{ $final_report['total_days'] }}</td>
                                <td class="p-4 text-gray-600">
                                    <span class="px-2 py-1 {{ $final_report['status'] == 'Avaliado' ? 'bg-green-500' : ($final_report['status'] == 'Rejeitado' ? 'bg-red-500' : 'bg-yellow-500') }} text-white rounded-full">
                                        {{ ucfirst($final_report['status']) }}
                                    </span>
                                </td>

                                <td class="p-4 text-gray-600">
                                    <div class="flex space-x-2 justify-center">
                                        
                                        <!-- Botão PDF -->
                                        <a href="{{ route('admin.internship_final_reports.download', $final_report['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                                <path fill="currentColor" d="m12 16l-5-5l1.4-1.45l2.6 2.6V4h2v8.15l2.6-2.6L17 11zm-6 4q-.825 0-1.412-.587T4 18v-3h2v3h12v-3h2v3q0 .825-.587 1.413T18 20z"/>
                                            </svg>
                                        </a>

                                        <!-- Botão Avaliar -->
                                        <button type="button" onclick="evaluateModal({{ $final_report['id'] }}, '{{ $final_report['final_evaluation'] }}')" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.667 21H6.333c-.31 0-.465 0-.592-.043c-.345-.115-.614-.452-.707-.884C5 19.915 5 19.722 5 19.334c0-.775 0-1.162.068-1.48c.185-.863.724-1.537 1.414-1.768C6.737 16 7.047 16 7.667 16h8.666c.62 0 .93 0 1.185.085c.69.231 1.229.905 1.414 1.768c.068.318.068.705.068 1.48c0 .388 0 .582-.034.74c-.093.432-.362.769-.707.884c-.127.043-.282.043-.592.043M9.5 16c.515-2.548.585-4.034.256-4.95a2.3 2.3 0 0 0-.316-.547c-.813-1.131-1.182-2.015-1.323-2.562a3.4 3.4 0 0 1-.093-.985a4.54 4.54 0 0 1 .855-2.394C9.729 3.372 11.313 3.007 12 3c.688.007 2.313.373 3.163 1.562a4.54 4.54 0 0 1 .855 2.394c.014.33-.011.665-.093.985c-.14.547-.51 1.43-1.323 2.562a2.3 2.3 0 0 0-.316.547c-.328.916-.3 2.402.214 4.95m-.5-3h-4" color="currentColor"/>
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

        @if (!empty($final_reports))

        <!-- Modal de Avaliar -->
        <div id="evaluateModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
            <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
                <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Avaliar Estágio</h2>

                <!-- Form -->
                <form id="updateForm" action="{{ route('institution.finalEvaluation', $final_report['id']) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                        <div class="col-span-2">
                            <label for="final_evaluation" class="block text-gray-600 mb-1">Avaliação Final</label>
                            <input type="number" id="update_final_evaluation" name="final_evaluation" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" min="0" max="20" value="{{ $final_report['final_evaluation'] }}" required>
                        </div>

                    </div>

                    <div class="flex justify-end">
                        <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('evaluateModal')">Cancelar</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Avaliar</button>
                    </div>

                </form>
            </div>
        </div>

    @endif

    <script>

        // Atualiza a página
        function refreshTable() {
            location.reload();
        }

        // Loader
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('loader');
            const table = document.getElementById('finalReportTable');

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

        // Abrir Modal para fazer a avalicao final
        function evaluateModal(id, finalEvaluation) {
            openModal('evaluateModal');

            document.getElementById('update_final_evaluation').value = finalEvaluation;

            const updateForm = document.getElementById('updateForm');
            updateForm.action = `/institution/internships/${id}`;
        }

        // Função de pesquisa de Relatórios
        function searchReport() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll("#finalReportTable tbody tr");

            rows.forEach(row => {
                const reportContent = row.querySelector(".finalReport-title").textContent.toLowerCase();
                row.style.display = reportContent.includes(searchValue) ? "" : "none"; 
            });
        }

    </script>

@endsection