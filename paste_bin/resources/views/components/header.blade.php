<header class="bg-[#023859] text-white">
    <div class="max-w-[1340px] mx-auto flex flex-wrap items-center justify-between p-4">
        <span class="text-[45px]">PASTEBIN</span>
        <div class="flex flex-wrap items-center gap-5">
            <span>API</span>
            <span class="bg-green-600 p-[3px] rounded-md">+ Paste</span>
            <form method="get" class="flex gap-[5px]">
                <input type="text" name="search" class="text-black p-2 rounded-md" placeholder="Введите название..." />
                <button type="submit" class="bg-white p-[3px] rounded-md text-black">Поиск</button>
            </form>
        </div>
        <div>
            <nav class="flex items-center justify-between">
                @if(Auth::check())
                    <div class="relative">
                        <button id="avatar-button" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar" class="w-8 h-8 rounded-full">
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="dropdown-menu" class="absolute right-0 mt-2 w-48 bg-gray-500 border border-gray-500 rounded-md shadow-lg z-10 hidden">
                            <a href="/pastebin" class="block px-4 py-2 hover:bg-gray-300">Мой Pastebin</a>
                            <a href="/profile" class="block px-4 py-2 hover:bg-gray-300">Профиль</a>
                            <form method="GET" action="{{ route('logout') }}" class="block px-4 py-2 hover:bg-gray-300">
                                @csrf
                                <button type="submit" class="w-full text-left">Выйти</button>
                            </form>
                        </div>
                    </div>
                @else
                    <ul class="flex flex-wrap gap-4">
                        <li><a href="/login" class="text-white">Войти</a></li>
                        <li><a href="/register" class="text-white">Регистрация</a></li>
                    </ul>
                @endif
            </nav>
        </div>
</header>

<script>
    document.getElementById('avatar-button').addEventListener('click', function() {
        const dropdown = document.getElementById('dropdown-menu');
        dropdown.classList.toggle('hidden');
    });

    // Закрытие меню при клике вне его
    window.addEventListener('click', function(event) {
        const dropdown = document.getElementById('dropdown-menu');
        const avatarButton = document.getElementById('avatar-button');
        if (!avatarButton.contains(event.target) && !dropdown.contains(event.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>