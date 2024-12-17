{{-- Страница отправки жалоб на пасту --}}

@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap gap-5'>
    <div class="w-full sm:w-[70%]">
        <h2 class="text-xl font-bold">Отправить жалобу на пасту: Qgj5RgSz</h2>
        <hr class="border-t border-solid border-gray-300">
        @include('../../components/reportForm')
    </div>
    <div class="w-full sm:w-[25%]">
        <div class="w-full">
            <a href='#'><h2>Public Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
    </div>
</div>
@endsection