<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <form action="#" method="POST" class="flex flex-col gap-6 w-full sm:w-3/4 lg:w-1/2">
        @csrf
        <h2 class="text-2xl font-bold">New Paste</h2>
        <textarea id="paste" name="content" class="w-full h-48 border-2 border-gray-300 rounded-md p-2" required></textarea>
        
        <h2 class="text-2xl font-bold">Optional Paste Settings</h2>
        <hr class="border-gray-400">
    
        <div class="flex flex-col gap-4">
            <label class="block">
                <span class="text-gray-700 font-medium">Категория</span>
                <select name="category_id" id="category_id" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                    {{-- @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach --}}
                </select>
            </label>
    
            <label class="block">
                <span class="text-gray-700 font-medium">Время существования пасты</span>
                <select name="access_time" id="access_time" class="w-full border-2 border-gray-300 rounded-md p-2">
                    {{-- @foreach($access_times as $access_time)
                        <option value="{{ $access_time->id }}">{{ $access_time->name }}</option>
                    @endforeach --}}
                </select>
            </label>
    
            <label class="block">
                <span class="text-gray-700 font-medium">Теги</span>
                <input type="text" name="tags" class="w-full border-2 border-gray-300 rounded-md p-2" placeholder="Введите теги через запятую">
            </label>
    
            <label class="block">
                <span class="text-gray-700 font-medium">Синтаксис</span>
                <select name="syntax_id" id="syntax_id" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                    {{-- @foreach($syntaxes as $syntax)
                        <option value="{{ $syntax->id }}">{{ $syntax->name }}</option>
                    @endforeach --}}
                </select>
            </label>
    
            <label class="block">
                <span class="text-gray-700 font-medium">Права доступа</span>
                <select name="rights_id" id="rights_id" class="w-full border-2 border-gray-300 rounded-md p-2" required>
                    {{-- @foreach($rights as $right)
                        <option value="{{ $right->id }}">{{ $right->name }}</option>
                    @endforeach --}}
                </select>
            </label>
    
            <label class="block">
                <span class="text-gray-700 font-medium">Название пасты</span>
                <input type="text" name="title" class="w-full border-2 border-gray-300 rounded-md p-2" required>
            </label>
        </div>

        <label class="flex items-center">
            <input type="checkbox" name="guest" class="mr-2" />
            <span class="text-gray-700">Создать как гость</span>
        </label>
    
        <button type="submit" class="bg-slate-300 px-4 py-2 rounded-md hover:bg-slate-400 transition-colors duration-300">Создать пасту</button>
    </form>
</div>