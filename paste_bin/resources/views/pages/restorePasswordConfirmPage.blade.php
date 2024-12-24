{{-- Страница подтверждения сброса пароля --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap gap-5'>
    <div class="w-full sm:w-[70%]">
        <h2 class="text-xl font-bold text-green-500">Смена пароля</h2>

        {{-- Вывод ошибок --}}
        @if ($errors->any())
            <div class="bg-red-500 text-white p-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Вывод сообщения об успехе --}}
        @if (session('success'))
            <div class="bg-green-500 text-white p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        {{-- Форма для смены пароля --}}
        <form action="{{ route('reset_password_confirm') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Новый пароль</label>
                <input type="password" name="password" id="password" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Подтверждение пароля</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 focus:ring-opacity-50" />
            </div>
            <button type="submit" class="mt-2 bg-green-500 text-white py-2 px-4 rounded">Сменить пароль</button>
        </form>
    </div>
    <div class="w-full sm:w-[25%]">
        <div class="w-full">
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            @include('../../components/userPastes', ['pastes' => $publicPastes])
        </div>
    </div>
</div>
@endsection