<!-- resources/views/components/header.blade.php -->
<header class="h-[50px] w-full m-0 p-0 bg-[#023859] text-white">
    <div class="max-w-[1340px] m-auto flex h-full justify-between items-center px-4">
        <span class="h-full text-[45px]">PASTEBIN</span>
        <div class="flex gap-5 items-center">
            <span>API</span>
            <span class="bg-green-600 p-[3px] rounded-md">+ Paste</span>
            <form  method="get" class="flex gap-[5px]">
                <input type="text" name="search" class="text-black" placeholder="Введите название...">
                <button type="submit" class="bg-white p-[3px] rounded-md text-black">Поиск</button>
            </form>
        </div>
        <div>
            <nav>
                <ul class="flex gap-[10px]">
                    @if(Auth::check())
                        <li>Welcome, {{ Auth::user()->name }}</li>
                        <li>
                            <form  method="POST" style="display:inline;">
                                @csrf
                                <button type="submit">Logout</button>
                            </form>
                        </li>
                    @else
                        <li>Login</li>
                        <li>Register</li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>   
</header>