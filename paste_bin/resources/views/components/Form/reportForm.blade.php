<div class="w-full mt-2">
    <form action="{{ route('send_report', ['short_link' => $paste->short_link, 'user_id' => Auth::user()]) }}" method="POST">
        @csrf
        <textarea name="text" id="text" class="w-[100%] border-solid border-2" required placeholder="Напишите причину жалобы"></textarea>
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Отправить</button>
    </form>
</div>