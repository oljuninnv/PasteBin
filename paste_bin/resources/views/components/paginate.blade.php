<div class="mt-4">
    <nav aria-label="Page navigation">
        <ul class="flex justify-center">
            {{-- Предыдущая страница --}}
            @if ($pastes->onFirstPage())
                <li>
                    <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-md cursor-not-allowed">« Предыдущая</span>
                </li>
            @else
                <li>
                    <a href="{{ $pastes->previousPageUrl() }}" class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100">« Предыдущая</a>
                </li>
            @endif

            {{-- Номера страниц --}}
            @for ($i = 1; $i <= $pastes->lastPage(); $i++)
                @if ($i == $pastes->currentPage())
                    <li>
                        <span class="px-4 py-2 text-white bg-blue-600 border border-blue-600 rounded-md">{{ $i }}</span>
                    </li>
                @else
                    <li>
                        <a href="{{ $pastes->url($i) }}" class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100">{{ $i }}</a>
                    </li>
                @endif
            @endfor

            {{-- Следующая страница --}}
            @if ($pastes->hasMorePages())
                <li>
                    <a href="{{ $pastes->nextPageUrl() }}" class="px-4 py-2 text-blue-600 bg-white border border-gray-300 rounded-md hover:bg-gray-100">Следующая »</a>
                </li>
            @else
                <li>
                    <span class="px-4 py-2 text-gray-500 bg-gray-200 rounded-md cursor-not-allowed">Следующая »</span>
                </li>
            @endif
        </ul>
    </nav>
</div>