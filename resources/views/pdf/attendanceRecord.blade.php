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
        th {
            background-color: #f3f4f6;
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
            <h1 class="text-xl font-bold">{{ $studentName }}</h1>
            <p class="text-sm">Oferta de Estágio: {{ $internshipOffer->title }}</p> 
        </div>
    </header>

    <div class="p-6">
        <h3 class="text-sky-400 text-lg font-bold mb-4">Registos Diários</h3>
        <table class="min-w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Data</th>
                    <th>Horas Presentes (H:M)</th>
                    <th>Sumário</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($attendanceRecords as $record)
                <tr>
                    <td>{{ $record['id'] }}</td>
                    <td>{{ $record['date'] }}</td>
                    <td>{{ $record['approval_hours'] }}</td>
                    <td>{{ $record['summary'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>