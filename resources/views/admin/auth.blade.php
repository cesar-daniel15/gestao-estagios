<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')

    <title>Auth | Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">

    <!-- Styles -->
</head>

<body class="flex items-center justify-center min-h-screen">  
    <div class="bg-white p-8 w-full md:w-1/2 flex flex-col justify-center items-center ">
        <img src="{{ asset('images/icon.png') }}" class="h-40 my-5" alt="Gestão de Estágios Logo" />
        <div class="text-2xl font-extrabold text-center text-sky-400 mb-2 mt-10">Dashboard de Admin</div>
        <p class="text-gray-400 font-bold text-md text-center mb-10">Introduza o código de acesso</p>

        <div class="flex justify-center space-x-4">
            <form action="{{ route('admin.auth') }}" method="POST">
            @csrf
                <input type="password" id="code" name="code" class="h-12 w-50 rounded-md border-2 border-sky-400 text-center text-xl" required>
                
                <!-- Submit button -->
                <div class="flex justify-center">
                    <button class="bg-sky-400 font-bold text-white border border-white p-2 rounded-xl px-10 my-10" type="submit">Entrar</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
