<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificação de E-mail</title>
    @vite('resources/css/app.css')

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="max-w-md w-11/12 bg-white rounded-lg shadow-lg p-6 text-center">
        <img src="{{ asset('images/icon.png') }}" alt="Logo da Empresa" class="mx-auto h-20 mb-4">

        <h1 class="text-2xl font-bold text-sky-500 mb-4">Verificação de E-mail</h1>

        <p class="text-lg text-gray-700 mb-4">Olá 👋,</p>
        <p class="text-gray-700 mb-4">Para completar a verificação da sua conta, insira este código:</p>

        <div class="inline-block bg-sky-500 text-white text-xl font-bold py-2 px-4 rounded mb-6">{{ $token }}</div>

        <p class="text-gray-700 mb-6">Por favor, insira este código no campo solicitado para verificar o seu e-mail.</p>

        <div class="text-sm text-gray-500">
            <p>Se você não solicitou esta verificação, pode ignorar este e-mail.</p>
            <p>Agradecemos por usar os nossos serviços.</p>
        </div>
    </div>

</body>
</html>
