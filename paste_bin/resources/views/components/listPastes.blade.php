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
</div>
