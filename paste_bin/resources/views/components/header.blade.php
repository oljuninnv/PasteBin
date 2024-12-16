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
            <nav>
                <ul class="flex flex-wrap gap-[10px]">
                    @if(Auth::check())
                        <li>Welcome, {{ Auth::user()->name }}</li>
                        <li>
                            <form method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-white">Logout</button>
                            </form>
                        </li>
                    @else
                        <li><a href="/login" class="text-white">Login</a></li>
                        <li><a href="/register" class="text-white">Register</a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
</header>