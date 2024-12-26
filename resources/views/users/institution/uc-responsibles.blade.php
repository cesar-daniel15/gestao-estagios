@extends('users.institution.layouts.default-institution')

@section('title', 'Gestão Estágios | Responsáveis por Unidades Curriculares ')

@section('page-name', 'Responsáveis por Unidades Curriculares')

@section('content')

@include('admin.layouts.components.alert')

<div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
    <div class="text-lg font-bold text-gray-600 mb-6">
        Responsáveis da Unidade Curricular
    </div>
    <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

        <div class="flex flex-col md:flex-row">

            <!-- Barra de pesquisa -->
            <div class="relative w-full lg:w-72 mb-4 md:mb-0">
                <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" 
                    placeholder="Procurar por Responsável de UC" oninput="searchUcResponsible()" />
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

    <!-- Tabela Responsáveis -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="responsibleTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 border-b text-gray-600">ID</th>
                    <th class="p-4 border-b text-gray-600">Nome</th>
                    <th class="p-4 border-b text-gray-600">Curso</th>
                    <th class="p-4 border-b text-gray-600">Unidade Curricular</th>
                    <th class="p-4 border-b text-gray-600">Contacto</th>
                    <th class="p-4 border-b text-gray-600"></th>
                </tr>
            </thead>
            <tbody>
            @if (empty($responsaveis))
                <tr>
                    <td colspan="5" class="p-4 text-gray-600 text-center">Ainda não existem responsáveis da UC registados</td>
                </tr>
            @else
            @foreach($responsaveis as $responsavel)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-4 text-gray-600">{{ $responsavel['id'] }}</td>
                <td class="p-4 text-gray-600 responsible-name">{{ $responsavel['user']['name'] }}</td>
                <td class="p-4 text-gray-600">
                    @if($responsavel['ucs']->isEmpty())
                        Nenhuma Unidade Curricular
                    @else
                        @foreach($responsavel['ucs'] as $uc)
                            {{ $uc['course']['name'] }}<br>
                        @endforeach
                    @endif
                </td>
                <td class="p-4 text-gray-600">
                    @if($responsavel['ucs']->isEmpty())
                        Nenhuma Unidade Curricular
                    @else
                        @foreach($responsavel['ucs'] as $uc)
                            {{ $uc['uc_name'] }}<br>
                        @endforeach
                    @endif
                </td>
                <td class="p-4 text-gray-600">{{ $responsavel['phone'] }}</td>
                <td class="p-4 text-gray-600">
                    <div class="flex space-x-2 justify-center">
                        <!-- Botão Ver -->
                        <a onclick="viewModal({{ $responsavel['id'] }}, '{{ $responsavel['user']['name'] }}', '{{ $responsavel['phone'] }}', '{{ $responsavel['created_at'] }}', '{{ $responsavel['picture'] }}', '{{ $responsavel['ucs'] && count($responsavel['ucs']) > 0 ? ($responsavel['ucs'][0]['course']['name'] ?? 'N/A') : 'N/A' }}', '{{ $responsavel['ucs'] && count($responsavel['ucs']) > 0 ? ($responsavel['ucs'][0]['course']['institution']['acronym'] ?? 'N/A') : 'N/A' }}')" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
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


@if (!empty($responsavel))

<!-- Modal de Visualização -->
<div id="viewModal" class="fixed inset-0 items-center bg-black bg-opacity-50 justify-center z-50 hidden">
    <div class="bg-white p-6 rounded-lg relative w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
        <div class="modal-content flex flex-col">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center mx-5" id="modal-name"></h2>
            <div class="modal-body flex flex-col md:flex-row">
                <!-- Div para a imagem -->
                <div class="w-full md:w-1/2 p-4 flex justify-center items-center" id="modal-picture">
                    <img src="{{ Storage::url($responsavel['picture']) }}" id="modal-picture" alt="Foto do Responsável" class="w-full h-48 object-contain rounded-2xl">
                </div>

                <!-- Div para os dados -->
                <div class="ml-4 space-y-4 flex flex-col data-content">
                    <p><strong>ID:</strong> <span id="modal-id"></span> </p>
                    <p><strong>Nome:</strong> <span id="modal-name"></span> </p>
                    <p><strong>Contacto:</strong> <span id="modal-phone"></span></p>
                    <p><strong>Instituição:</strong> <span id="modal-institution"></span></p>
                    <p><strong>Curso:</strong> <span id="modal-course"></span></p>
                </div>
            </div>

            <div class="modal-footer flex justify-end absolute top-0 right-0 p-5">
                <button type="button" class="text-gray-600 hover:text-gray-800 text-3xl font-bold" onclick="closeModal('viewModal')">×</button>
            </div>
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
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('loader');
        const table = document.getElementById('responsibleTable');

        setTimeout(() => {
            loader.classList.add('hidden'); 
            table.classList.remove('hidden'); 
        }, 2000);
    });


    // Função de pesquisa de Responsáveis de UC
    function searchUcResponsible() {
        const searchValue = document.getElementById('search').value.toLowerCase();
        const rows = document.querySelectorAll("#responsibleTable tbody tr"); 

        rows.forEach(row => {
            const responsibleName = row.querySelector(".responsible-name").textContent.toLowerCase();
            
            if (responsibleName.includes(searchValue)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

     // Funcao para abrir o modal
    function openModal(modalId) {
        const modal = document.getElementById(modalId);
            modal.style.display = 'flex';
            modal.classList.remove('hidden');
    }

    // Funcao para fechar o modal
    function closeModal(modalId) {
        const modal = document.getElementById(modalId);
        modal.style.display = 'none';
        modal.classList.add('hidden');
    }

    // Função para modal de visualização dos responsáveis da UC
    function viewModal(id, name, phone, createdAt, picture, courseName, institutionName) {
        // Definindo o nome no modal
        document.querySelector('#viewModal .modal-content h2').textContent = name;

        // Definindo a imagem no modal
        document.querySelector('#viewModal .modal-body #modal-picture').innerHTML = `
            <img src="${picture}" alt="Foto do Responsável da UC" class="w-48 h-48 object-cover rounded-full">
        `;

        // Definindo os dados no modal
        document.querySelector('#viewModal .modal-body .data-content').innerHTML = `
            <div class="ml-4 flex flex-col gap-5">
                <p><strong>ID:</strong> ${id}</p>
                <p><strong>Contacto:</strong> ${phone}</p>
                <p><strong>Instituição:</strong> ${institutionName}</p>
                <p><strong>Curso:</strong> ${courseName}</p>
                <p><strong>Data de Criação:</strong> ${createdAt}</p>
            </div>
        `;

        // Abrindo o modal
        openModal('viewModal');
    }
</script>

@endsection