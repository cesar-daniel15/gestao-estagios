@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Instituições /')

@section('content')
    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Instituições Existentes
        </div>
        <div class="flex justify-end my-5">
            <!-- Botão para abrir o modal -->
            <button onclick="openModal()" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl py-2 px-4 flex text-sm items-center">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 mr-2" fill="white">
                    <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                </svg>
                Registrar Instituição
            </button>
        </div>
        <div class="overflow-x-auto">
            <table class="table-auto w-full border-collapse text-center text-sm overflow-hidden rounded-xl">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 border-b text-gray-600">ID</th>
                        <th class="p-4 border-b text-gray-600">Nome</th>
                        <th class="p-4 border-b text-gray-600">Acrónimo</th>
                        <th class="p-4 border-b text-gray-600">Email</th>
                        <th class="p-4 border-b text-gray-600">Contacto</th>
                        <th class="p-4 border-b text-gray-600">Morada</th>
                        <th class="p-4 border-b text-gray-600">Website</th>
                        <th class="p-4 border-b text-gray-600">Conta Verificada</th>
                        <th class="p-4 border-b text-gray-600">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($institutions as $institution)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4 text-gray-600">{{ $institution['id'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['name'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['acronym'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['email'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['phone'] }}</td>
                                <td class="p-4 text-gray-600">{{ $institution['address'] }}</td>
                                <td class="p-4 text-gray-600">
                                    <a href="{{ $institution['website'] }}" class="text-sky-400 hover:underline" target="_blank">{{ $institution['website'] }}</a>
                                </td>
                                <td class="p-4 text-gray-600">{{ $institution['account_is_verified'] }}</td>
                                <td class="p-4 text-gray-600">
                                    <div class="flex space-x-2">
                                        <!-- Botão Editar -->
                                        <a href="{{ route('institutions.show', $institution['id']) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-2 rounded flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5">
                                                <path fill="currentColor" d="M11 17h2v-6h-2zm1-8q.425 0 .713-.288T13 8t-.288-.712T12 7t-.712.288T11 8t.288.713T12 9m0 13q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                                            </svg>
                                        </a>

                                        <!-- Botão Apagar -->
                                        <form action="{{ route('institutions.destroy', $institution['id']) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja apagar esta instituição?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-2 rounded flex items-center">
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

    <!-- Modal -->
    <div class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3">
            <h2 class="text-2sm font-bold text-gray-700 mb-4 text-center">Registrar Instituição</h2>
            
            <form action="{{ route('institutions.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-600 mb-1">Nome</label>
                    <input type="text" id="name" name="name" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="acronym" class="block text-gray-600 mb-1">Acrónimo</label>
                    <input type="text" id="acronym" name="acronym" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-600 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-600 mb-1">Password</label>
                    <input type="password" id="password" name="password" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-600 mb-1">Contacto</label>
                    <input type="text" id="phone" name="phone" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-600 mb-1">Morada</label>
                    <input type="text" id="address" name="address" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                </div>

                <div class="mb-4">
                    <label for="website" class="block text-gray-600 mb-1">Website</label>
                    <input type="url" id="website" name="website" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2">
                </div>

                <div class="flex justify-end mt-4">
                    <button type="button" class="bg-gray-400 hover:bg-gray-500 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal()">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Abrir o modal
        function openModal() {
            const modal = document.querySelector('.fixed.inset-0');
            modal.style.display = 'flex'; 
        }

        // Fechar o modal
        function closeModal() {
            const modal = document.querySelector('.fixed.inset-0');
            modal.style.display = 'none'; 
        }
    </script>

@endsection
