{{-- Главная страница с формой добавления пасты --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    
            <form action="{{ route('paste.update', $paste->short_link) }}" method="POST" class="flex flex-col gap-6 w-full sm:w-3/4 lg:w-1/2">
                @csrf
                @method('POST') <!-- Указываем метод POST -->
                <h2 class="text-2xl font-bold">Edit Paste</h2>
                @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Успех!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
                @endif
            
                <!-- Поле для контента -->
                <textarea id="paste" name="content" class="w-full h-48 border-2 border-gray-300 rounded-md p-2" required>{{ old('content', $paste->content) }}</textarea>
                @error('content')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror
            
                <h2 class="text-2xl font-bold">Optional Paste Settings</h2>
                <hr class="border-gray-400">
            
                <div class="flex flex-col gap-4">
                    <!-- Категория -->
                    <label class="block">
                        <span class="text-gray-700 font-medium">Категория</span>
                        <select name="category_id" id="category" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" {{ $paste->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
            
                    <!-- Время существования -->
                    <label for="expiration_time" class="block">
                        <span class="text-gray-700 font-medium">Время существования пасты</span>
                        <select name="expiration_time" id="expiration_time" class="w-full border-2 border-gray-300 rounded-md p-2">
                            @foreach ($expiration_times as $expiration_time)
                                <option value="{{ $expiration_time->id }}" {{ $paste->expiration_time == $expiration_time->id ? 'selected' : '' }}>{{ $expiration_time->name }}</option>
                            @endforeach
                        </select>
                        @error('expiration_time')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
            
                    <!-- Теги -->
                    <label class="block">
                        <span class="text-gray-700 font-medium">Теги</span>
                        <input type="text" name="tags" class="w-full border-2 border-gray-300 rounded-md p-2" placeholder="Введите теги через запятую" value="{{ old('tags', $paste->tags) }}">
                        @error('tags')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
            
                    <!-- Синтаксис -->
                    <label class="block">
                        <span class="text-gray-700 font-medium">Синтаксис</span>
                        <select name="language" id="language" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                            @foreach ($languages as $language)
                                <option value="{{ $language->id }}" {{ $paste->language_id == $language->id ? 'selected' : '' }}>{{ $language->name }}</option>
                            @endforeach
                        </select>
                        @error('syntax')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
            
                    <!-- Права доступа -->
                    <label class="block">
                        <span class="text-gray-700 font-medium">Права доступа</span>
                        <select name="visibility_id" id="visibilitys" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                            @foreach ($visibilitys as $visibility)
                                <option value="{{ $visibility->id }}" {{ $paste->visibility_id == $visibility->id ? 'selected' : '' }}>{{ $visibility->name }}</option>
                            @endforeach
                        </select>
                        @error('visibility')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
            
                    <!-- Название пасты -->
                    <label class="block">
                        <span class="text-gray-700 font-medium">Название пасты</span>
                        <input type="text" name="title" class="w-full border-2 border-gray-300 rounded-md p-2" required value="{{ old('title', $paste->title) }}">
                        @error('title')
                            <div class="text-red-500 text-sm">{{ $message }}</div>
                        @enderror
                    </label>
                </div>
            
                <button type="submit" class="bg-slate-300 px-4 py-2 rounded-md hover:bg-slate-400 transition-colors duration-300">Обновить пасту</button>
            </form>
        </div>        
    </div>
    <div class="flex flex-col gap-5 w-[25%]">
        <div class="w-full">           
            @if (Auth::check()) 
            <a href="{{ route('user')}}" class=" hover:underline">My Pastes</a>
                @include('../../components/userPastes', ['pastes' => $userPastes])
            @endif
        </div>
        <div>
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            @include('../../components/userPastes', ['pastes' => $publicPastes])
        </div>
    </div>
</div>
@endsection