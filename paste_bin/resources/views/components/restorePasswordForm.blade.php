<div class="mt-2">
    <form action='Post' class="mt-2 flex flex-col gap-2">
        @csrf

        <div class="flex gap-2 flex-col">
            <label for="username">Почта:</label>
            <input type="email" name="username" id="username" class="border border-gray-300 rounded-md p-2" required>
        </div>
        
        <div class="flex gap-2 flex-col">
            <label for="password">Пароль:</label>
            <input type="password" name="password" id="password" class="border border-gray-300 rounded-md p-2" required>
        </div>
    
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors duration-300 mt-4">Сбросить пароль</button>
    </form>
</div>