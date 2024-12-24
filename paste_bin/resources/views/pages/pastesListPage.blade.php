{{-- Страница просмотра паст --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        @include('../../components/listPastes')
    </div>
    <div class="flex flex-col gap-5 w-[25%]">
        <div class="w-full">
            <a href="{{ route('user')}}" class=" hover:underline">My Pastes</a>
            {{-- @include('../../components/userPastes', ['pastes' => $userPastes]) --}}
        </div>
        <div>
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            {{-- @include('../../components/userPastes', ['pastes' => $publicPastes]) --}}
        </div>
    </div>
</div>
@endsection