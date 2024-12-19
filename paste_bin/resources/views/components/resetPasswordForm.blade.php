<div class="mt-2">
    @if (session('success'))
        <div class="alert alert-success text-green-600">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger text-red-600">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method='POST' action="{{ route('reset_password') }}" class="mt-2 flex flex-col gap-2">
        @csrf

        <div class="flex gap-2 flex-col">
            <label for="email">Почта:</label>
            <input type="email" name="email" id="email" class="border border-gray-300 rounded-md p-2" required>
        </div>
    
        <button type="submit" class="bg-blue-500 text-white p-2 rounded-md hover:bg-blue-600 transition-colors duration-300 mt-4">Сбросить пароль</button>
    </form>
</div>