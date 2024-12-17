{{-- Страница пасты --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap gap-5'>
    <div class="w-full sm:w-[70%]">
        @include('../../components/pasteView')
    </div>
    <div class="w-[25%]">
        <div class="w-full">
            <a href='#'><h2>Public Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
    </div>
</div>
@endsection