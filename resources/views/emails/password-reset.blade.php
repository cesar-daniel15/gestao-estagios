<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redefinição de Password</title>
    @vite('resources/css/app.css')
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">

    <div class="max-w-md w-11/12 bg-white rounded-lg shadow-lg p-6 text-center">
        <img src="{{ asset('images/icon.png') }}" alt="Logo da Empresa" class="mx-auto h-20 mb-4">
        <h1 class="text-2xl font-bold text-sky-500 mb-4">Redefinição de Password</h1>

        <p class="text-lg text-gray-700 mb-4">Olá,</p>
        <p class="text-gray-700 mb-4">Recebemos uma solicitação para redefinir sua password. Clique no link abaixo para redefinir sua password automaticamente:</p>

        <a href="{{ route('password.reset', ['token' => $token, 'email' => $user->email]) }}" class="inline-block bg-sky-500 text-white text-xl  py-2 px-4 rounded mb-6">Redefinir Pasword</a>

        <p class="text-gray-700 mb-6">Se você não solicitou a redefinição de password, ignore este e-mail.</p>
    </div>

</body>
</html>
