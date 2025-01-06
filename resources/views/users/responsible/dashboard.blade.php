@extends('users.responsible.layouts.default-responsible')

@section('title', 'Gestão Estágios | Responsible Dashboard')

@section('page-name', 'Home Dashboard')

@section('content')

    @include('layouts.components.alert')

    <div class="mt-10 bg-white drop-shadow-md rounded-xl p-10 mb-10">
        <div class="text-lg font-bold text-gray-600 mb-6">
            Informações Relevantes
        </div>

        <div class="mt-10 flex flex-col gap-6 mx-0 md:mx-12"> 

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M4 21q-.825 0-1.412-.587T2 19V8q0-.825.588-1.412T4 6h4V4q0-.825.588-1.412T10 2h4q.825 0 1.413.588T16 4v2h4q.825 0 1.413.588T22 8v11q0 .825-.587 1.413T20 21zm0-2h16V8H4zm6-13h4V4h-4zM4 19V8z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-grow flex justify-between items-center">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Alunos Atualmente a Estágiar</div>
                    </div>
                    <div class="text-xl font-bold text-gray-800">{{ $studentsCurrentlyInterning }}</div> 
                </div>
            </div>

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-500" width="24" height="24" viewBox="0 0 50 50">
                        <path fill="currentColor" d="M30 8v33H6V8zm4-4H2v42h32zM9 12h18v4H9zm0 7h18v4H9zm0 7h18v4H9zm0 7h18v4H9zm31-21h8v28h-8zm4.006-11C41.812 1 40 2.765 40 4.937V9h8V4.937C48 2.765 46.191 1 44.006 1m-4.068 42l4.041 6.387L48 43z"/>
                    </svg>
                </div>
                <div class="ml-4 flex-grow flex justify-between items-center">
                    <div>
                        <div class="text-sm font-medium text-gray-500">Estágio Atualmente Disponíveis</div>
                    </div>
                    <div class="text-xl font-bold text-gray-800">{{ $internshipsAvailable }}</div>
                </div>
            </div>

            <div class="bg-gray-100 drop-shadow-md rounded-xl p-6 flex items-center">
                <div class="flex-shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-sky-500" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M7 13.5q.625 0 1.063-.437T8.5 12t-.437-1.062T7 10.5t-1.062.438T5.5 12t.438 1.063T7 13.5m5 0q.625 0 1.063-.437T13.5 12t-.437-1.062T12 10.5t-1.062.438T10.5 12t.438 1.063T12 13.5m5 0q.625  0 1.063-.437T18.5 12t-.437-1.062T17 10.5t-1.062.438T15.5 12t.438 1.063T17 13.5M12 22q-2.075 0-3.9-.788t-3.175-2.137T2.788 15.9T2 12t.788-3.9t2.137-3.175T8.1 2.788T12 2t3.9.788t3.175 2.137T21.213 8.1T22 12t-.788 3.9t-2.137 3.175t-3.175 2.138T12 22m0-2q3.35 0 5.675-2.325T20 12t-2.325-5.675T12 4T6.325 6.325T4 12t2.325 5.675T12 20m0-8"/>
                </svg>
            </div>
            <div class="ml-4 flex-grow flex justify-between items-center">
                <div>
                    <div class="text-sm font-medium text-gray-500">Alunos Sem Estágio</div>
                </div>
                <div class="text-xl font-bold text-gray-800">{{ $studentsWithoutInternship }}</div>
            </div>
        </div>

    </div>
</div>

@endsection