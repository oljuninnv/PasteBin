{{-- Страница авторизации --}}
@extends('layout')

@section('content')
<div class='flex w-full m-auto justify-between flex-wrap'>
    <div class="w-[70%]">
        <h2>Login Page</h2>
        <hr class="border-t border-solid border-gray-300">
        @include('../../components/authForm')
    </div>
    <div class="w-[25%]">
        <div class="w-full">
            <a href='#'><h2>Public Pastes</h2></a>
            @include('../../components/userPastes')
        </div>
    </div>
</div>
@endsection