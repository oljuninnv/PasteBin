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

        <main class="m-auto mt-10 ml-[10%] mr-[10%] mb-5">
            <div class="w-full m-auto ">
                @yield('content')
            </div>           
        </main>
    </body>
</html>
