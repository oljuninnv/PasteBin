{{-- Страница отправки жалоб на пасту --}}

@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap gap-5'>
    <div class="w-full sm:w-[70%]">
        <h2 class="text-xl font-bold">Отправить жалобу на пасту: {{$paste->short_link}}</h2>
        <hr class="border-t border-solid border-gray-300">
        @include('../../components/Form/reportForm')
    </div>
    <div class="w-full sm:w-[25%]">
        <div class="w-full">
            <a href="{{ route('archive')}}" class=" hover:underline">Public Pastes</a>
            @include('../../components/userPastes', ['pastes' => $publicPastes])
        </div>
    </div>
</div>
@endsection