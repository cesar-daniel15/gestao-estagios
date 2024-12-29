@extends('users.responsible.layouts.default-responsible')

@section('title', 'Gestão Estágios | Alunos')

@section('page-name', 'Alunos')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Alunos Existentes
        </div>
    
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">

            <div class="flex flex-col md:flex-row">

                <!-- Barra de pesquisa -->
                <div class="relative w-full md:w-auto mb-4 md:mb-0">
                    <input type="text" id="search-student" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2 text-start" placeholder="Procurar por Aluno" oninput="searchStudent()" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                    </svg>
                </div>
            
            </div>

            <div class="flex gap-4">
                <!-- Botão Registar User -->
                <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg p-2 flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                        <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                    </svg>
                    Registrar Utilizador
                </button> 

                    <!-- Botão de Atualizar -->
                    <div class="mt-4 md:mt-0 hidden md:flex">
                        <button id="refreshButton" class="bg-info text-white font-bold p-2 rounded bg-teal-600 hover:bg-teal-500 rounded-lg text-sm flex items-center" onclick="refreshTable()">
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

        <!-- Tabela Alunos -->
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="studentTable">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome do Aluno</th>
                        <th class="p-4 border-b text-gray-600">Ano Letivo</th> 
                        <th class="p-4 border-b text-gray-600">Instituição</th>
                        <th class="p-4 border-b text-gray-600">Curso</th> 
                        <th class="p-4 border-b text-gray-600">Estágio</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                @if (empty($students))
                    <tr>
                        <td colspan="7" class="p-4 text-gray-600 text-center">Ainda não existem alunos registadas </td>
                    </tr>
                @else
                    @foreach($students as $student)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4 text-gray-600">{{ $student['id'] }}</td>
                            <td class="p-4 text-gray-600 student-name">{{ $student['user']['name']  }}</td>
                            <td class="p-4 text-gray-600">
                                @if($student['ucs']->isEmpty())
                                    Sem Unidade Curricular
                                @else
                                    {{ $student['ucs']->first()['lective_year'] }} 
                                @endif
                            </td>
                            <td class="p-4 text-gray-600 institution">
                                @if($student['ucs']->isEmpty())
                                    Sem Unidade Curricular
                                @else
                                    {{ $student['ucs']->first()['course']['institution']['acronym'] }} 
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">
                                @if($student['ucs']->isEmpty())
                                    Sem Unidade Curricular
                                @else
                                    {{ $student['ucs']->first()['course']['name'] }} 
                                @endif
                            </td>
                            <td class="p-4 text-gray-600">{{ $student['assigned_internship_id']}}</td>
       
                        </tr>
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Criar Novo Aluno -->
    <div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Aluno</h2>

            <!-- Form -->
            <form action="{{ route('responsible.students.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">


                    <div>
                        <label for="phone" class="block text-gray-600 mb-1">Contacto</label>
                        <input type="text" id="phone" name="phone" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="picture" class="block text-gray-600 mb-1">Foto</label>
                        <input type="file" id="picture" name="picture" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                </div>

                <div class="flex justify-center">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
                
            </form>
        </div>
    </div>

    @if (!empty($students))

    <!-- Modal de Visualização -->
    <div id="viewModal" class="fixed inset-0 items-center bg-black bg-opacity-50 justify-center z-50 hidden">
        <div class="bg-white p-6 rounded-lg relative w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <div class="modal-content flex flex-col">
                <h2 class="text-xl font-bold text-gray-700 mb-4 text-center mx-5" id="modal-name"></h2>
                <div class="modal-body flex flex-col md:flex-row">
                    <!-- Div para a imagem -->
                    <div class="w-full md:w-1/2 p-4 flex justify-center items-center" id="modal-picture">
                        <img src="" id="modal-picture-img" alt="Foto do Aluno" class="w-full h-48 object-contain rounded-2xl">
                    </div>

                    <!-- Div para os dados -->
                    <div class="w-full md:w-1/2 p-4 flex flex-col data-content space-y-4">
                        <p><strong>ID:</strong> <span id="modal-id"></span></p>
                        <p><strong>Nome:</strong> <span id="modal-name-text"></span></p>
                        <p><strong>Contacto:</strong> <span id="modal-phone"></span></p>
                        <p><strong>Estágio Atribuído:</strong> <span id="modal-internship-name"></span></p>
                        <p><strong>Data de Criação:</strong> <span id="modal-created-at"></span></p>
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

    // Pesquisar por aluno
    function searchStudent() {
        const searchStudent = document.getElementById('search-student').value.toLowerCase();
        const rows = document.querySelectorAll("#studentTable tbody tr");

        rows.forEach(row => {
            const studentName = row.querySelector(".student-name").textContent.toLowerCase();

            const matchName = studentName.includes(searchStudent);

            if (matchName) {
                row.style.display = ""; 
            } else {
                row.style.display = "none"; 
            }
        });
    }

    // Atualiza a pagina
    function refreshTable() {
        location.reload();
    }

    // Loader
    document.addEventListener('DOMContentLoaded', function () {
    const loader = document.getElementById('loader');
    const table = document.getElementById('studentTable');

    // Verificar se a tabela contém dados
    if (table.rows.length > 0) {
        loader.classList.add('hidden'); 
        table.classList.remove('hidden'); 
    } else {
        loader.classList.remove('hidden'); 
        table.classList.add('hidden');
    }
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


        function ViewModal(student) {
        document.getElementById('modal-id').innerText = student.id;
        document.getElementById('modal-name-text').innerText = student.name;
        document.getElementById('modal-phone').innerText = student.phone;
        document.getElementById('modal-internship-name').innerText = student.internship || 'Nenhum estágio atribuído';
        document.getElementById('modal-created-at').innerText = student.created_at;

        const picture = document.getElementById('modal-picture-img');
        picture.src = student.picture || 'placeholder.jpg';
        picture.alt = `Foto de ${student.name}`;

        openModal('viewModal');
    }


</script>

@endsection
