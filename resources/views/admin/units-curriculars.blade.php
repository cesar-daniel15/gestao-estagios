@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Instituições / Unidades Curriculares')

@section('content')

@extends('admin.layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Unidades Curriculares Existentes
        </div>
        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">
            
            <!-- Barra de pesquisa -->
            <div class="flex">
                <div class="relative w-full">
                    <input type="text" id="search" class="bg-gray-50 border border-gray-300 text-black text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block pl-10 w-full p-2.5 text-start" 
                        placeholder="Procurar por Instituição" oninput="searchUnitCurricular()" />
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24" class="absolute top-1/2 left-3 transform -translate-y-1/2 text-gray-500">
                        <path fill="currentColor" d="m19.6 21l-6.3-6.3q-.75.6-1.725.95T9.5 16q-2.725 0-4.612-1.888T3 9.5t1.888-4.612T9.5 3t4.613 1.888T16 9.5q0 1.1-.35 2.075T14.7 13.3l6.3 6.3zM9.5 14q1.875 0 3.188-1.312T14 9.5t-1.312-3.187T9.5 5T6.313 6.313T5 9.5t1.313 3.188T9.5 14"/>
                    </svg>
                </div>
            </div>

            <!-- Botão para criar Unidade Curricular -->
            <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl p-2.5 flex text-sm items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                    <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                </svg>
                Registrar Unidade Curricular
            </button>
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


    <!-- Tabela Unidades Curriculares -->
    <div class="overflow-x-auto">
        <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl hidden" id="unitCurricularTable">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-4 border-b text-gray-600">ID</th>
                    <th class="p-4 border-b text-gray-600">Nome</th>
                    <th class="p-4 border-b text-gray-600">Código</th>
                    <th class="p-4 border-b text-gray-600">Curso</th>
                    <th class="p-4 border-b text-gray-600">Ementa</th>
                    <th class="p-4 border-b text-gray-600">Ações</th>
                </tr>
            </thead>
            <tbody>
            @if (empty($unitCurricular))
                <tr>
                    <td colspan="6" class="p-4 text-gray-600 text-center">Ainda não existem unidades curriculares registadas.</td>
                </tr>
            @else
                @foreach($unitCurricular as $unit)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="p-4 text-gray-600">{{ $unit['id'] }}</td>
                        <td class="p-4 text-gray-600">{{ $unit['name'] }}</td>
                        <td class="p-4 text-gray-600">{{ $unit['code'] }}</td>
                        <td class="p-4 text-gray-600">{{ $unit['course']['name'] ?? 'Curso não disponível' }}</td>
                        <td class="p-4 text-gray-600">{{ $unit['syllabus'] }}</td>
                        <td class="p-4 text-gray-600">
                            <div class="flex space-x-2 justify-center">

                                <!-- Botão Ver -->
                                <a href="javascript:void(0)" onclick="openViewModal(this)" data-id="{{ $unit['id'] }}" data-name="{{ $unit['name'] }}" data-code="{{ $unit['code'] }}" data-course="{{ $unit['course']['name'] }}" data-syllabus="{{ $unit['syllabus'] }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                    </svg>
                                </a>

                                <!-- Botão Update -->
                                <button type="button" onclick="updateModal({{ $unit['id'] }}, '{{ $unit['name'] }}', '{{ $unit['code'] }}', '{{ $unit['course']['name'] }}', '{{ $unit['syllabus'] }}')" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                        <path fill="currentColor" d="m12.9 6.855l4.242 4.242l-9.9 9.9H3v-4.243zm1.414-1.415l2.121-2.121a1 1 0 0 1 1.414 0l2.829 2.828a1 1 0 0 1 0 1.415l-2.122 2.121z"/>
                                    </svg>
                                </button>

                                <!-- Botão Apagar -->
                                <form id="deleteForm{{ $unit['id'] }}" action="{{ route('admin.units.destroy', $unit['id']) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="openDeleteModal({{ $unit['id'] }})" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded flex items-center">
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

    <!-- Modal Criar Nova Unidade Curricular -->
    <div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registrar Unidade Curricular</h2>

            <!-- Form -->
            <form action="{{ route('admin.units.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label for="name" class="block text-gray-600 mb-1">* Nome</label>
                        <input type="text" id="name" name="name" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="code" class="block text-gray-600 mb-1">* Código</label>
                        <input type="text" id="code" name="code" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="course" class="block text-gray-600 mb-1">* Curso</label>
                        <select name="course_id" id="course_id" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="syllabus" class="block text-gray-600 mb-1">Ementa</label>
                        <textarea name="syllabus" id="syllabus" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2"></textarea>
                    </div>
                </div>

                <p class="text-center my-2">* Obrigatorio</p>

                <div class="flex justify-center">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Visualizar Unidade Curricular -->
    <div id="viewModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Visualizar Unidade Curricular</h2>

            <div>
                <label class="block text-gray-600 mb-1">Nome</label>
                <p id="viewName" class="text-gray-700"></p>
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Código</label>
                <p id="viewCode" class="text-gray-700"></p>
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Curso</label>
                <p id="viewCourse" class="text-gray-700"></p>
            </div>

            <div>
                <label class="block text-gray-600 mb-1">Ementa</label>
                <p id="viewSyllabus" class="text-gray-700"></p>
            </div>

            <div class="flex justify-center mt-4">
                <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded" onclick="closeModal('viewModal')">Fechar</button>
            </div>
        </div>
    </div>

@endsection

<script>
    // Exemplo de função para abrir o modal de visualização
    function openViewModal(button) {
        document.getElementById('viewModal').classList.remove('hidden');
        document.getElementById('viewName').textContent = button.getAttribute('data-name');
        document.getElementById('viewCode').textContent = button.getAttribute('data-code');
        document.getElementById('viewCourse').textContent = button.getAttribute('data-course');
        document.getElementById('viewSyllabus').textContent = button.getAttribute('data-syllabus');
    }

    // Exemplo de função para fechar o modal
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }
</script>
