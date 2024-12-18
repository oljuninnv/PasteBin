<div class="mt-2">
    <h3>Войти через социальные сети</h3>
    <div class="flex gap-5 flex-wrap mt-2">
        <a href="#" class="bg-red-500 text-white p-2 rounded">Sign in with Google</a>
        <a href="#" class="bg-black text-white p-2 rounded">Sign in with GitHub</a>       
    </div>
    
    <div class="relative my-4 text-center">
        <hr class="border-t border-solid border-gray-300" />
        <span class="absolute left-1/2 transform -translate-x-1/2 -top-4 text-lg bg-white px-2 text-gray-300">или</span>
    </div>
    
    <form action="{{ route('auth') }}" method="POST" class="mt-2 flex flex-col gap-2">
        @csrf
        <div class="flex gap-2 flex-col">
            <label for="username">Логин:</label>
            <input type="text" name="name" id="username" class="border border-gray-300 rounded-md p-2" required>
        </div>
        
        <div class="flex gap-2 flex-col">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2" required>
        </div>
    
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors duration-300 mt-4">Войти</button>
    </form>

    <div class="mt-4 text-center">
        <p>
            <a href="#" class="text-blue-500 hover:underline">Зарегистрироваться</a> / 
            <a href="#" class="text-blue-500 hover:underline">Восстановить пароль</a>
        </p>
    </div>
</div>