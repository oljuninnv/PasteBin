<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        @vite(['resources/js/app.js'])
    </head>
    <body class="antialiased">
        @include('components/header')
        {{-- <h1 class="font-bold underline  text-2xl text-[#2a59b1]">
            Hello world!
          </h1> --}}
    </body>
</html>
