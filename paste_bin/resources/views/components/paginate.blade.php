<div class="mt-4">
    <nav aria-label="Page navigation">
        <ul class="flex justify-center">
            {{-- Предыдущая страница --}}
            <li>
                <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-md cursor-not-allowed">« Предыдущая</span>
            </li>

            {{-- Номера страниц --}}
            @for ($i = 1; $i <= 2; $i++) {{-- Предположим, у нас 2 страницы --}}
                <li>
                    @if ($i == 1) {{-- Текущая страница --}}
                        <span class="px-4 py-2 text-white bg-blue-600 border border-blue-600 rounded-md">{{ $i }}</span>
                    @else
                        <span class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-md">{{ $i }}</span>
                    @endif
                </li>
            @endfor

            {{-- Следующая страница --}}
            <li>
                <span class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-md">Следующая »</span>
            </li>
        </ul>
    </nav>
</div>