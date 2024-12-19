<div>
    <form action="" method="post" class="flex flex-col gap-2 mt-2">
        @csrf

        <label for="username">Имя</label>
        <input type="text" id="username" name="username" class="p-2 border border-gray-300 rounded-md bg-gray-300" readonly value placeholder="nikitka">

        <label for="email">Почта</label>
        <input type="email" id="email" name="email" class="p-2 border border-gray-300 rounded-md" required>

        {{-- Ссылка, если почта была изменена --}}
        {{-- <a href="#" class="text-blue-600 hover:underline">Подтверить почту</a>  --}}

        <label for="website">Ссылка на ваш веб-сайт</label>
        <input type="url" id="website" name="website" class="p-2 border border-gray-300 rounded-md" value placeholder="Enter a valid URL starting with http(s)://">

        <label for="location">Откуда вы?</label>
        <input type="text" id="location" name="location" class="p-2 border border-gray-300 rounded-md">

        <label for="avatar">Аватар</label>
        <input type="file" id="avatar" name="avatar" class="p-2 border border-gray-300 rounded-md" accept="image/*">

        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Обновить профиль</button>
    </form>
</div>