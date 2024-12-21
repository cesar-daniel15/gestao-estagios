    <!-- Alerta de Sucesso -->
    @if(session('success'))
        <div class="fixed top-5 right-5 max-w-xs p-4 text-white bg-green-600 border-l-4 border-green-800 rounded-lg z-50 shadow-lg animate-fade-out opacity-100 transition-opacity animate-slide-in-out px-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-semibold">Sucesso!</span>
            </div>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Alerta de Erros -->
    @if ($errors->any())
        <div class="fixed top-5 right-5 max-w-xs p-4 text-white bg-red-600 border-l-4 border-red-800 rounded-lg z-50 shadow-lg animate-fade-out opacity-100 transition-opacity animate-slide-in-out px-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-semibold">Erro!</span>
            </div>
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- Alerta de Informacao -->
    @if(session('info'))
        <div class="fixed top-5 right-5 max-w-xs p-4 text-white bg-yellow-500 border-l-4 border-yellow-700 rounded-lg z-50 shadow-lg animate-fade-out opacity-100 transition-opacity animate-slide-in-out px-5">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="font-semibold">Informação!</span>
            </div>
            <p class="text-sm">{{ session('info') }}</p>
        </div>
    @endif