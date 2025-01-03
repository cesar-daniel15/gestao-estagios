@extends('users.institution.layouts.default-institution')

@section('title', 'Gestão Estágios | Institution Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Informações sobre a Instituição
        </div>

        <div class="mt-10 grid grid-cols-1 md:grid-cols-2 gap-6">

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19 3h-2v6.5l-3-2.25l-3 2.25V3H5v18h14zm-6 0v2.5l1-.75l1 .75V3zm8 20H3V1h18z"/>
                </svg>

                <div class="ml-4 flex-grow">
                    <div class="text-sm font-medium text-gray-500">Total Cursos</div>
                    <div class="text-xl font-bold text-gray-800">{{ $totalCourses ?? 'Indisponivel'}} </div> 
                </div>
            </div>

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" width="24" height="24" viewBox="0 0 50 50">
                        <path fill="currentColor" d="M30 8v33H6V8zm4-4H2v42h32zM9 12h18v4H9zm0 7h18v4H9zm0 7h18v4H9zm0 7h18v4H9zm31-21h8v28h-8zm4.006-11C41.812 1 40 2.765 40 4.937V9h8V4.937C48 2.765 46.191 1 44.006 1m-4.068 42l4.041 6.387L48 43z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-grow">
                    <div class="text-sm font-medium text-gray-500">Total de Unidades Curriculares</div>
                    <div class="text-xl font-bold text-gray-800">{{ $totalUCs ?? 'Indisponivel' }}</div>
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
        const userRegistration = @json($userRegistration);
        
        const labels = userRegistration.map(item => item.date); 
        const data = userRegistration.map(item => item.count); 

        const ctx = document.getElementById('usersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    borderColor: '#3b82f6', 
                    backgroundColor: 'rgba(59, 130, 246, 0.2)', 
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
