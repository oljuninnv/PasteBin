<div class="w-full mt-2">
    <form action="" method="POST" class="flex flex-col gap-2">
        @csrf
        <textarea name="text" id="text" class="w-[100%] border-solid border-2" required placeholder="Напишите причину жалобы"></textarea>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Отправить</button>
    </form>
</div>