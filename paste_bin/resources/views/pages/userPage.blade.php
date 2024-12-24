{{-- Страница пользователя --}}
@extends('layout')

@section('content')
<div class="flex w-full m-auto justify-between flex-wrap gap-5">
    <div class="w-full sm:w-[70%]">
        <div class="flex justify-between items-center flex-wrap">
            <div class="flex items-center gap-2">
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Аватар пользователя" class="w-10 h-10 rounded-full">
                <h2 class="font-bold text-lg">{{$user->name}}</h2>
            </div>
            <div class="w-full sm:w-auto mt-2 sm:mt-0">
                <form method="get" class="flex gap-2">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}" 
                        class="text-black p-2 rounded-md border-solid border-2 w-full sm:w-auto" 
                        placeholder="Введите название..." 
                    />
                    <select name="per_page" onchange="this.form.submit()" class="p-2 border border-gray-300 rounded-md">
                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                        <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                    </select>
                    <button type="submit" class="bg-blue-500 p-2 rounded-md text-white">Поиск</button>
                </form>
            </div>                
        </div>
        <div class="mt-2">
            @include('../../components/pasteTable')
        </div>
        <div class="mt-2">
            @include('../../components/userStats')
        </div>
    </div>
    <div class="w-full sm:w-[25%]">
        <div class="w-full">
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            @include('../../components/userPastes', ['pastes' => $publicPastes])
        </div>
    </div>
</div>
@endsection