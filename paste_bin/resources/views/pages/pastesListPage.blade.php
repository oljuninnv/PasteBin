{{-- Страница просмотра паст --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        @include('../../components/listPastes')
    </div>
    <div class="flex flex-col gap-5 w-[25%]">
        <div class="w-full">
            <a href='#'><h2>My Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
        <div>
            <a href='#'><h2>Public Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
    </div>
</div>
@endsection