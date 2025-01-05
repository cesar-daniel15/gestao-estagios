@extends('users.student.layouts.default-student')

@section('title', 'Gestão Estágios | Student Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Registos Diarios 
        </div>

        <div class="flex flex-col gap-5 md:flex-row justify-between items-center my-5">
            
            <!-- Filtro de data -->
            <div class="relative w-full md:w-auto mb-4 md:mb-0">
                <select id="date_filter" class="bg-gray-50 border border-gray-300 text-gray-400 text-sm rounded-lg block w-full p-2" onchange="filterByDate()">
                    <option value="">Selecione uma opção</option>
                    <option value="recent" class="text-black">Data Mais Recente</option>
                    <option value="oldest" class="text-black">Data Mais Antiga</option>
                </select>
            </div>

            <div class="flex gap-4">
                
                <!-- Botão para criar registo -->
                <button onclick="openModal('createModal')" class="bg-green-500 hover:bg-green-600 text-white font-bold rounded-lg p-2 flex text-sm items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-5 h-5 " fill="white">
                        <path d="M12 4.75c.69 0 1.25.56 1.25 1.25v4.75H18a1.25 1.25 0 1 1 0 2.5h-4.75V18a1.25 1.25 0 1 1-2.5 0v-4.75H6a1.25 1.25 0 1 1 0-2.5h4.75V6c0-.69.56-1.25 1.25-1.25"/>
                    </svg>
                    <span class="mx-2 flex md:hidden md:mx-0">Criar Registo Diario</hiden>
                </button>

            </div>
        </div>

        <div id="records-container">
        
            @foreach ($attendanceRecords as $record)
            
            <div class="mb-5"> 

                <div class="flex items-center justify-between {{ $record['approval_status'] === 'Pendente' ? 'bg-gray-300' : ($record['approval_status'] === 'Aprovado' ? 'bg-sky-400' : 'bg-red-400') }} border rounded-t-lg shadow-md p-4">
                    <span class="text-white record-date">{{ \Carbon\Carbon::parse($record['date'])->format('d/m/Y') }}</span>
                    <svg onclick="toggleDetails('{{ $record['id'] }}')" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-white cursor-pointer">
                        <path fill="currentColor" d="M7 10l5 5 5-5H7z"/>
                    </svg>
                </div>

                <div id="details-{{ $record['id'] }}" class="hidden bg-gray-100 rounded-b-lg p-4">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        
                            <!-- Data e horas diarias -->
                            <div>
                                <p class="mb-2"><strong>Data:</strong> {{ \Carbon\Carbon::parse($record['date'])->format('d/m/Y') }}</p>
                                <p><strong>Horas Diárias:</strong> {{ $record['approval_hours']}}</p>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <!-- Horas de manha -->
                                <div class="flex flex-col items-center">
                                    <div class="hidden md:flex items-center text-yellow-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                                            <path fill="currentColor" d="M18 12a6 6 0 1 1-12 0a6 6 0 0 1 12 0"/>
                                            <path fill="currentColor" fill-rule="evenodd" d="M12 1.25a.75.75 0 0 1 .75.75v1a.75.75 0 0 1-1.5 0V2a.75.75 0 0 1 .75-.75M4.399 4.399a.75.75 0 0 1 1.06 0l.393.392a.75.75 0 0 1-1.06 1.061l-.393-.393a.75.75 0 0 1 0-1.06m15.202 0a.75.75 0 0 1 0 1.06l-.393.393a.75.75 0 0 1-1.06-1.06l.393-.393a.75.75 0 0 1 1.06 0M1.25 12a.75.75 0 0 1 .75-.75h1a.75.75 0 0 1 0 1.5H2a.75.75 0 0 1-.75-.75m19 0a.75.75 0 0 1 .75-.75h1a.75.75 0 0 1 0 1.5h-1a.75.75 0 0 1-.75-.75m-2.102 6.148a.75.75 0 0 1 1.06 0l.393.393a.75.75 0 1 1-1.06 1.06l-.393-.393a.75.75 0 0 1 0-1.06m-12.296 0a.75.75 0 0 1 0 1.06l-.393.393a.75.75 0 1 1-1.06-1.06l.392-.393a.75.75 0 0 1 1.061 0M12 20.25a.75.75 0 0 1 .75.75v1a.75.75 0 0 1-1.5 0v-1a.75.75 0 0 1 .75-.75" clip-rule="evenodd"/>
                                        </svg>
                                        <span class="font-semibold mb-2"> Manhã</span>
                                    </div>
                                    <p class="mb-2"><strong>Hora Entrada:</strong>  {{ $record['morning_start_time']}}</p>
                                    <p><strong>Hora Saída:</strong>  {{ $record['morning_end_time']}}</p>
                                </div>

                                <!-- Horas de tarde -->
                                <div class="flex flex-col items-center">
                                    <div class="hidden md:flex items-center text-orange-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30">
                                            <path fill="currentColor" d="M2.66 20.92c0 .23.08.42.25.57c.17.16.38.23.62.23h18.61c.24 0 .44-.08.6-.23c.17-.16.25-.35.25-.57c0-.24-.08-.45-.24-.61a.8.8 0 0 0-.61-.25H3.53c-.24 0-.44.08-.61.25s-.26.38-.26.61m2.61-3.11c0 .24.09.43.26.59c.14.18.33.27.59.27h18.61c.23 0 .42-.08.58-.25s.23-.37.23-.61a.8.8 0 0 0-.23-.58a.8.8 0 0 0-.58-.23H6.12c-.24 0-.44.08-.6.23c-.17.16-.25.35-.25.58m.15-2.42v-.05c-.04.15 0 .22.12.22h1.44c.06 0 .12-.05.19-.15c.24-.52.59-.94 1.06-1.27s.99-.52 1.55-.56l.53-.08c.12 0 .19-.06.19-.18l.06-.5c.11-1.08.56-1.97 1.36-2.7c.8-.72 1.75-1.08 2.84-1.08c1.07 0 2.02.36 2.82 1.07s1.27 1.6 1.38 2.67l.07.57q0 .18.21.18h1.58c.64 0 1.23.17 1.75.52c.52.34.92.8 1.17 1.36c.07.1.14.15.22.15h1.42c.12 0 .17-.07.15-.22c-.22-.56-.37-.91-.46-1.06c.72-.65 1.23-1.51 1.5-2.57l.17-.66a.15.15 0 0 0-.01-.16c-.03-.04-.07-.07-.12-.07l-.62-.22c-.89-.26-1.57-.78-2.04-1.58s-.59-1.65-.37-2.56l.13-.58c.05-.09.01-.17-.13-.23l-.84-.23a5.03 5.03 0 0 0-3.22.26a5.2 5.2 0 0 0-2.47 2.12c-.79-.31-1.56-.46-2.29-.46c-1.39 0-2.62.44-3.71 1.31S9.27 10.64 8.95 12c-.84.2-1.58.6-2.22 1.21s-1.06 1.34-1.31 2.18M7 23.97c0 .24.09.43.26.59c.17.18.37.27.59.27H26.5c.23 0 .43-.08.59-.25s.24-.37.24-.61c0-.23-.08-.42-.24-.58s-.36-.23-.59-.23H7.86c-.24 0-.44.08-.6.23c-.17.16-.26.35-.26.58M18.51 8.7c.35-.57.82-1.02 1.41-1.33s1.21-.44 1.87-.38c-.07 1.04.17 2.02.7 2.93c.54.91 1.28 1.58 2.22 2.02c-.15.35-.4.71-.75 1.07a4.8 4.8 0 0 0-3.14-1.13h-.32c-.32-1.31-.98-2.37-1.99-3.18"/>
                                        </svg>
                                        <span class="font-semibold"> Tarde</span>
                                    </div>
                                    <p class="mb-2"><strong>Hora Entrada:</strong>  {{ $record['afternoon_start_time']}}</p>
                                    <p><strong>Saída:</strong>  {{ $record['afternoon_end_time']}}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sumario -->
                        <div>
                            <label for="summary" class="block text-black mb-1 font-semibold">Sumário</label>
                            <textarea id="summary" class="bg-gray-100 w-full" rows="3" readonly> {{ $record['summary']}}</textarea>
                        </div>
                    </div>  
                
                </div>

                @endforeach
            </div>

            @if(empty($attendanceRecords))
                <p class="text-center text-gray-500">Não há registros de presença disponíveis.</p>
            @endif

            <div class="hidden md:flex items-center justify-end my-5">

                <div class="bg-gray-300 w-4 h-4 mx-2"></div>
                <span class="text-sm text-gray-500">Por Aprovar</span>

                <div class="bg-sky-400 w-4 h-4 mx-2"></div>
                <span class="text-sm text-gray-500">Aprovado</span>

                <div class="bg-red-400 w-4 h-4 mx-2"></div>
                <span class="text-sm text-gray-500">Rejeitado</span>

            </div>
        </div>

    
    <!-- Modal Criar Novo Registro de Presença -->
    <div id="createModal" class="fixed inset-0 items-center sm:h-screen justify-center z-50 bg-black bg-opacity-50 hidden text-sm">
        <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 sm:w-3/4 md:w-2/3 lg:w-1/2">
            <h2 class="text-xl font-bold text-gray-700 mb-4 text-center">Registro de Presença</h2>

            <!-- Form -->
            <form action="{{ route('student.storeAttendance') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">

                    <div>
                        <label for="morning_start_time" class="block text-gray-600 mb-1">Início Manhã</label>
                        <input type="time" id="morning_start_time" name="morning_start_time" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="morning_end_time" class="block text-gray-600 mb-1">Fim Manhã</label>
                        <input type="time" id="morning_end_time" name="morning_end_time" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="afternoon_start_time" class="block text-gray-600 mb-1">Início Tarde</label>
                        <input type="time" id="afternoon_start_time" name="afternoon_start_time" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div>
                        <label for="afternoon_end_time" class="block text-gray-600 mb-1">Fim Tarde</label>
                        <input type="time" id="afternoon_end_time" name="afternoon_end_time" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" required>
                    </div>

                    <div class="col-span-2">
                        <label for="summary" class="block text-gray-600 mb-1">Sumário</label>
                        <textarea id="summary" name="summary" class="border border-gray-300 rounded-lg w-full p-1 xl:p-2" rows="4" required></textarea>
                    </div>

                </div>

                <div class="flex justify-center">
                    <button type="button" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-2 xl:px-4 rounded mr-2" onclick="closeModal('createModal')">Cancelar</button>
                    <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-2 xl:px-4 rounded">Registrar</button>
                </div>
                
            </form>
        </div>
    </div>

@endsection


<script>
        // Atualiza a página
        function refreshTable() {
            location.reload();
        }

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
        
        // Função para alternar a exibição da div de detalhes
        function toggleDetails(id) {
            const details = document.getElementById('details-' + id);
            details.classList.toggle('hidden');
        }
        
        // Filtrar a listagem pela data
        function filterByDate() {
            const filterValue = document.getElementById('date_filter').value;
            const recordsContainer = document.getElementById('records-container'); 
            const records = Array.from(recordsContainer.children); 

            // Ordena os registros com base no valor do filtro
            records.sort((a, b) => {
                const dateA = new Date(a.querySelector('.record-date').textContent); 
                const dateB = new Date(b.querySelector('.record-date').textContent);

                return filterValue === 'recent' ? dateB - dateA : dateA - dateB; 
            });

            // Limpa o contêiner e adiciona os registros ordenados
            recordsContainer.innerHTML = '';
            records.forEach(record => recordsContainer.appendChild(record));
        }
</script>