{{--  Страница подтверждения почты --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        <h1 class="text-green-400">Почта подтверждена!!!</h1>
    </div>
    <div class="flex flex-col gap-5 w-[25%]">
        <div class="w-full">
            <a href='#'><h2>My Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
        <div>
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            @include('../../components/userPastes', ['pastes' => $publicPastes])
        </div>
    </div>
</div>
@endsection