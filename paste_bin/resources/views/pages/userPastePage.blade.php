{{-- Страница пасты --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap gap-5'>
    <div class="w-full sm:w-[70%]">
        @include('../../components/pasteView')
    </div>
    <div class="w-[25%]">
        <div class="w-full">
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            {{-- @include('../../components/userPastes', ['pastes' => $publicPastes]) --}}
        </div>
    </div>
</div>
@endsection