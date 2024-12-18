@extends('admin.layouts.default-admin')

@section('title', 'Gestão Estágios | Admin Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

@include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Informações relevantes
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-8 w-8 text-sky-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2 2 4-4 5 5 6-6" />
                    </svg>
                </div>

                <div class="ml-4 flex-grow">
                    <div class="text-sm font-medium text-gray-500">Total de Utilizadores</div>
                    <div class="text-xl font-bold text-gray-800">{{ $totalUsers ?? 'Indisponivel'}} </div> 
                </div>
            </div>

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c-4.42 0-8 2.69-8 6v1h16v-1c0-3.31-3.58-6-8-6z" />
                    </svg>
                </div>
                <div class="ml-4 flex-grow">
                    <div class="text-sm font-medium text-gray-500">Perfil Predominante</div>
                    <div class="text-xl font-bold text-gray-800">{{ $mostCommonProfile->profile ?? 'Indisponivel' }} ({{ $mostCommonProfile->count ?? 'Indisponivel' }})</div>
                </div>
            </div>

        </div>

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <div class="w-full md:flex justify-center h-auto my-12 hidden">
            <div class="w-full h-auto">
                <canvas id="usersChart" class="w-full h-64"></canvas>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dados fornecidos pelo servidor
            const userRegistration = @json($userRegistration);
            
            const labels = userRegistration.map(item => item.date); // Datas formatadas
            const data = userRegistration.map(item => item.count); // Quantidade de registros

            // Renderiza o gráfico
            const ctx = document.getElementById('usersChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderColor: '#3b82f6', 
                        backgroundColor: 'rgba(1, 130, 246, 0.2)', 
                        borderWidth: 2,
                        tension: 0.4 
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false 
                        }
                    },
                    scales: {
                        x: {
                            display: true,
                            ticks: {
                                display: true 
                            }
                        },
                        y: {
                            display: true,
                            ticks: {
                                display: true 
                            },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
            
@endsection