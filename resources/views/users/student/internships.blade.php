@extends('users.student.layouts.default-student')

@section('title', 'Gestão Estágios | Student Dashboard')

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

        </div>


        <!-- Tabela Ofertas de Estágio -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl" id="internshipOffersTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">Título</th>
                        <th class="p-4 border-b text-gray-600">Empresa</th>
                        <th class="p-4 border-b text-gray-600">Prazo</th>
                        <th class="p-4 border-b text-gray-600">Estado</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($internships))
                    <tr>
                        <td colspan="7" class="p-4 text-gray-600 text-center">Ainda não existem ofertas de estágio registadas</td>
                    </tr>
                @else
                    @foreach($internships as $internship_offer)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600 internship-title">{{ $internship_offer['title'] }}</td>
                            <td class="p-4 text-gray-600 company-name">{{ $internship_offer['company']['users']['name'] }}</td>
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

                                    <!-- Botão Candidatar -->
                                    <form action="{{ route('student.internships.apply', $internship_offer['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="m18 13l3 3v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4l3-3h.83l2 2H6.78L5 17h14l-1.77-2h-1.91l2-2zm1 7v-1H5v1zm-7.66-5l-4.95-4.93a.996.996 0 0 1 0-1.41l6.37-6.37a.975.975 0 0 1 1.4.01l4.95 4.95c.39.39.39 1.02 0 1.41L12.75 15a.96.96 0 0 1-1.41 0m2.12-10.59L8.5 9.36l3.55 3.54L17 7.95z"/>
                                            </svg>
                                        </button>
                                    </form>

                                    <!-- Botão Remover Candidatura -->
                                    <form action="{{ route('student.internships.remove', $internship_offer['id']) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                                <g fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" color="currentColor"><path d="M12.5 22h-3c-3.3 0-4.95 0-5.975-1.08C2.5 19.843 2.5 18.106 2.5 14.633V9.368c0-3.473 0-5.21 1.025-6.289S6.2 2 9.5 2h3c3.3 0 4.95 0 5.975 1.08C19.5 4.157 19.5 5.894 19.5 9.367V12.5M22 16l-3 3m0 0l-3 3m3-3l3 3m-3-3l-3-3"/><path d="m7 2l.082.493c.2 1.197.3 1.796.72 2.152C8.22 5 8.827 5 10.041 5h1.917c1.213 0 1.82 0 2.24-.355c.42-.356.52-.955.719-2.152L15 2M7 16h4m-4-5h8"/></g>
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

    @if (!empty($internship_offers))

    @endif

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

        // Função de pesquisa de Ofertas de Estágio
        function searchInternshipOffer() {
            const searchValue = document.getElementById('search').value.toLowerCase();
            const rows = document.querySelectorAll("#internshipOffersTable tbody tr");

            rows.forEach(row => {
                const internshipTitle = row.querySelector(".internship-title").textContent.toLowerCase(); 
                const companyName = row.querySelector(".company-name").textContent.toLowerCase(); 

                // Verifica se o título ou o nome da empresa inclui o valor de pesquisa
                if (internshipTitle.includes(searchValue) || companyName.includes(searchValue)) {
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