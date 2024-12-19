<div>
    @if ($errors->any())
    <div class="bg-red-500 text-white p-2 rounded-md mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="bg-green-500 text-white p-2 rounded-md mb-4">
        {{ session('success') }}
    </div>
@endif

<form action="{{ route('edit_profile') }}" method="post" class="flex flex-col gap-2 mt-2" enctype="multipart/form-data">
    @csrf

    <label for="name">Имя</label>
    <input type="text" id="name" name="name" class="p-2 border border-gray-300 rounded-md bg-gray-300" readonly value="{{ $user->name }}" placeholder="nikitka">

    <label for="email">Почта</label>
    <input type="email" id="email" name="email" class="p-2 border border-gray-300 rounded-md" required value="{{ $user->email }}">

    <label for="website">Ссылка на ваш веб-сайт</label>
    <input type="url" id="website" name="website" class="p-2 border border-gray-300 rounded-md" value="{{ $user->website }}" placeholder="Enter a valid URL starting with http(s)://">

    <label for="location">Откуда вы?</label>
    <input type="text" id="location" name="location" class="p-2 border border-gray-300 rounded-md" value="{{ $user->location }}">

    <label for="avatar">Аватар</label>
    <input type="file" id="avatar" name="avatar" class="p-2 border border-gray-300 rounded-md" accept="image/*">

    @if (!$hasPassword)
        <label for="password">У вас видимо нету пароля, придумайте его</label>
        <input type="password" id="password" name="password" class="p-2 border border-gray-300 rounded-md" placeholder="Введите новый пароль">
    @endif

    <button type="submit" class="bg-blue-500 text-white p-2 rounded-md">Обновить профиль</button>
</form>
{{-- Ссылка, если почта была изменена --}}
@if ($showEmailVerificationButton)
<form action="{{ route('send_mail') }}" method="POST">
    @csrf
    <button type="submit" class="text-blue-600 hover:underline">Подтвердить почту</button>
</form>
@endif
</div>