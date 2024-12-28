<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Oferta de Estágio</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .header {
            border-bottom: 2px solid #38bdf8;
        }
        table {
            width: 100%; 
            border-collapse: collapse; 
        }
        th, td {
            border: 1px solid #d1d5db; 
            padding: 8px; 
            text-align: left;
            font-size: 14px;
        }
        h2 {
            margin-top: 24px;
            margin-bottom: 12px;
        }
    </style>
</head>
<body>
    <header class="header flex justify-between items-center p-4">
        <div>
            <h1 class="text-xl font-bold">{{ $internship_offer->title }}</h1>
            <p class="text-sm">{{ \Carbon\Carbon::parse($internship_offer->created_at)->format('d/m/Y') }}</p>
        </div>
    </header>

    <div class="p-6">
        <h3 class="text-sky-400 text-lg font-bold mb-4">Detalhes</h3>
        <table class="min-w-full">
            <tbody>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Empresa</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->company->users->first()->name ?? 'Nome não disponível' }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Descrição</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->description }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Data Limite</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->deadline }}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="text-sky-400 text-lg font-bold mt-6 mb-4">Público Alvo</h3>
        <table class="min-w-full">
            <tbody>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Instituição</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->institution->acronym }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Curso</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->course->name }}</td>
                </tr>
            </tbody>
        </table>

        <h3 class="text-sky-400 text-lg font-bold mt-6 mb-4">Informação Complementar</h3>
        <table class="min-w-full">
            <tbody>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Status</strong></td>
                    <td class="border border-gray-300 p-2">
                        {{ $internship_offer->status === 'open' ? 'Aberto' : ($internship_offer->status === 'closed' ? 'Fechado' : 'Arquivado') }}
                    </td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Plano</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->plan_id ?? 'Indisponível' }}</td>
                </tr>
                <tr>
                    <td class="border border-gray-300 p-2"><strong>Relatório Final</strong></td>
                    <td class="border border-gray-300 p-2">{{ $internship_offer->final_report_id ?? 'Indisponível' }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>