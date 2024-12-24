<div class="max-w-6xl mx-auto p-4">
    <!-- Заголовок страницы -->
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Pastes</h1>

    <!-- Поисковая строка -->
    <form action="{{ route('archive') }}" method="GET">
        <div class="flex flex-wrap items-center gap-4 mb-6">
            <input type="text" name="search" placeholder="Search..."
                class="flex-grow p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" />
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition">
                Search
            </button>
            <!-- Выбор количества элементов на странице -->
            <form method="GET" action="{{ request()->url() }}">
                <select name="per_page" onchange="this.form.submit()" class="p-2 border border-gray-300 rounded-md">
                    <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page') == 20 ? 'selected' : '' }}>20</option>
                </select>
            </form>
        </div>
    </form>

    <!-- Список паст -->
    <h2 class="text-3xl font-semibold text-gray-800 mb-4">Публичные пасты</h2>
    <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
        <thead class="bg-gray-200">
            <tr>
                <th class="py-3 px-4 border-b text-left text-gray-600">Название</th>
                <th class="py-3 px-4 border-b text-left text-gray-600">Дата публикации</th>
                <th class="py-3 px-4 border-b text-left text-gray-600">Синтаксис</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pastes as $paste)
                <tr class="hover:bg-gray-100 transition duration-200">
                    @if ($paste->short_link)
                        <td class="py-3 px-4 border-b">
                            <a href="{{ route('user_paste', $paste->short_link) }}"
                                class="text-blue-600 hover:underline">{{ $paste->title }}</a>
                        </td>
                        <td class="py-3 px-4 border-b">{{ $paste->created_at->format('d.m.Y H:i') }}</td>
                        <td class="py-3 px-4 border-b">
                            @foreach ($languages as $language)
                                @if ($language->id == $paste->language_id)
                                    {{ $language->name }}
                                @endif
                            @endforeach
                        </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="py-3 px-4 border-b text-center text-gray-500">Нет доступных паст.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex space-x-2 mt-5 ">
        <!-- Кнопка "Назад" -->
        @if ($pastes->onFirstPage())
            <button class="disabled bg-gray-300 text-gray-500 cursor-not-allowed px-4 py-2 rounded">Назад</button>
        @else
            <a href="{{ $pastes->previousPageUrl() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Назад</a>
        @endif

        <!-- Кнопка "Вперед" -->
        @if ($pastes->hasMorePages())
            <a href="{{ $pastes->nextPageUrl() }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Вперед</a>
        @else
            <button class="disabled bg-gray-300 text-gray-500 cursor-not-allowed px-4 py-2 rounded">Вперед</button>
        @endif
    </div>
</div>