{{-- Главная страница с формой добавления пасты --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        @include('../../components/Form/createPaste')
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