<div class="max-w-4xl mx-auto p-4">
    {{-- Заголовок пасты --}}
    <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-4">
        {{ $paste->title }}
    </h1>

    {{-- Информация о пользователе и дате --}}
    <div class="flex flex-col md:flex-row items-center justify-between text-sm text-gray-600 mb-4">
        <div class="flex items-center gap-2 mb-2 md:mb-0">
            @if (!empty($user->avatar))
                <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar" class="w-8 h-8 rounded-full">
            @else
                <img src="{{ asset('storage/users/default.png') }}" alt="User Avatar" class="w-8 h-8 rounded-full">
            @endif
            <span class="font-semibold">{{ $user && $user->name ? $user->name : 'Guest' }}</span>
        </div>
        <div class="flex items-center gap-4">
            <span>Синтаксис: {{ $language->name }}</span>
            <span>📅 {{ $paste->updated_at }}</span>
            <span>⏳ {{ $expirationTime && $expirationTime->name ? $expirationTime->name : 'Never' }}</span>
        </div>
    </div>

    {{-- Кнопки действий --}}
    <div class="flex justify-between gap-2 mb-4">
        <div class="flex flex-wrap gap-2">
            <button id="copyButton" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                Copy
            </button>
            @if (!$isUserPaste)
            <a  href="{{ route('report', $paste->short_link)}}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-red-600 transition">
                Report
            </a>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <label for="syntax" class="text-gray-700 font-medium">Синтаксис:</label>
            <select id="syntax" name="syntax"
                class="p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                @foreach ($languages as $language)
                    <option value="{{ $language->name }}" data-syntax="{{ $language->name }}" 
                        @if ($language->name == 'None') selected @endif>
                        {{ $language->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
        {{-- Содержимое пасты --}}
        <div class="bg-gray-100 p-4 rounded-md shadow-inner overflow-auto mb-4">
            <pre id="pasteContent" class="whitespace-pre-wrap text-sm text-gray-800">
                <code class="language-{{ $language->name }}">
                    {{ $paste->content }}
                </code>
            </pre>
        </div>
    

    @if (empty($comments))
    <h2 class="lock text-lg font-semibold text-gray-800 mb-2">Здесь пока нет комментариев. Станьте первым!</h2>
    @else
        <h2 class="text-lg font-semibold text-gray-800 mb-2">Комментарии:</h2>
        <ul class="space-y-4">
            @foreach ($comments as $comment)
                <li class="p-4 border border-gray-300 rounded-md">
                    <span class="font-semibold">{{ $comment->user->name }}</span>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                    <span class="text-gray-500 text-sm">{{ $comment->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif

    {{-- Форма добавления комментария --}}
    @if (Auth::check() && $isUserPaste == false)
    <div class="w-full mt-5">
        <form action="{{ route('send_comment') }}" method="POST">
            @csrf
            <input type="hidden" name="paste_id" value="{{ $paste->id }}">
            
            <label for="comment" class="block text-lg font-semibold text-gray-800 mb-2">Ваш комментарий</label>
    
            <textarea id="comment" name="comment" rows="4"
                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Напишите ваш комментарий здесь..."></textarea>
    
            <div class="flex flex-col md:flex-row items-center justify-between mt-4 gap-4">
                <button type="submit"
                    class="bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition">
                    Добавить комментарий
                </button>
            </div>
        </form>
    </div>
    @elseif (Auth::check() == false)
        <h2 class="lock text-lg font-semibold text-gray-800 mb-2">Чтобы оставить комментарий, пожалуйста авторизуйтесь</h2>
    @endif
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.5.1/highlight.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const syntaxSelect = document.getElementById('syntax');
        const pasteContent = document.getElementById('pasteContent');

        syntaxSelect.addEventListener('change', function() {
            const selectedOption = syntaxSelect.options[syntaxSelect.selectedIndex];
            const syntax = selectedOption.getAttribute('data-syntax');

            // Обновляем класс для подсветки синтаксиса
            pasteContent.innerHTML = `<code class="language-${syntax}">${{{ $paste->content }}}</code>`;
            hljs.highlightAll();
        });

        // Обработчик для кнопки копирования
        document.getElementById('copyButton').addEventListener('click', function() {
            // Получаем текст из блока с пастой
            const pasteContentText = document.getElementById('pasteContent').innerText;

            // Создаем временный элемент для копирования текста
            const tempInput = document.createElement('textarea');
            tempInput.value = pasteContentText;
            document.body.appendChild(tempInput);

            // Выделяем текст
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Для мобильных устройств

            // Копируем текст в буфер обмена
            document.execCommand('copy');

            // Удаляем временный элемент
            document.body.removeChild(tempInput);

            // Уведомление о том, что текст скопирован (можно заменить на alert)
            alert('Текст скопирован в буфер обмена!');
        });
    });
</script>
