@php
    $student = Auth::user()->student;
    $notifications = App\Models\Notification::where('student_num', $student->id)->get(); 
    $unreadCount = $notifications->where('status_visualization', 0)->count(); 
@endphp

<!-- Navbar -->
<nav class="flex justify-between items-center relative z-50">

    <div class="text-md font-bold text-gray-500">
        @yield('page-name')
    </div> 

    <div class="hidden md:flex items-center bg-white drop-shadow-md rounded-xl w-auto ml-auto">

        <!-- Ícone de Notificações -->
        <div class="relative mx-4" onclick="toggleNotifications()">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="text-gray-500 w-8 h-8 cursor-pointer">
                <path fill="currentColor" d="M10 21h4c0 1.1-.9 2-2 2s-2-.9-2-2m11-2v1H3v-1l2-2v-6c0-3.1 2-5.8 5-6.7V4c0-1.1.9-2 2-2s2 .9 2 2v.3c3 .9 5 3.6 5 6.7v6zm-4-8c0-2.8-2.2-5-5-5s-5 2.2-5 5v7h10z"/>
            </svg>
            <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-1">{{ $unreadCount }}</span>

            <!-- Dropdown de Notificações -->
            <div id="notificationDropdown" class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg hidden z-50">
                <div class="py-2 px-4 border-b">
                    <h3 class="font-bold text-lg">Notificações</h3>
                </div>
                <div class="py-2">
                    @if ($notifications->isEmpty())
                        <p class="px-4 py-2 text-gray-500">Nenhuma notificação</p>
                    @else
                        @foreach ($notifications as $notification)
                            <div class="px-4 py-2 {{ $notification->status_visualization ? '' : 'font-bold bg-gray-100' }} flex items-center justify-between">
                                <div>
                                    <strong>{{ $notification->title }}</strong><br>
                                    <span class="text-gray-600">{{ $notification->content }}</span>
                                </div>
                                <form action="{{ route('student.notification', $notification->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="text-green-500 text-xs rounded px-2 py-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 48 48" class="mr-1">
                                            <path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="m4 24l5-5l10 10L39 9l5 5l-25 25z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                            <hr>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="flex items-center">
            @if ($student && $student->picture) 
                <img src="{{ asset('storage/' . $student->picture) }}" alt="User   Logo" class="w-12 h-12 rounded-full mx-2 my-2">
            @else
                <img src="{{ asset('images/uploads/default-user.png') }}" alt="Default User Image" class="w-12 h-12 rounded-full mx-2 my-2">
            @endif 

            <span class="text-gray-500 font-semibold me-5">{{ Auth::user()->name ?? 'Utilizador' }}</span>
        </div>

    </div>
</nav>

<script>
    function toggleNotifications() {
        const dropdown = document.getElementById('notificationDropdown');
        dropdown.classList.toggle('hidden');
    }
</script>
