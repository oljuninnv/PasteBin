<div>
    <table class="min-w-full border-collapse border border-gray-300 overflow-x-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2">Название пасты</th>
                <th class="border border-gray-300 p-2">Дата создания</th>
                <th class="border border-gray-300 p-2">Истекает</th>
                <th class="border border-gray-300 p-2">Синтаксис</th>
                <th class="border border-gray-300 p-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            @foreach($userPastes as $paste)
                <tr>
                    <td class="border border-gray-300 p-2"><a href="{{ route('user_paste', $paste->short_link) }}"
                        class="text-blue-600 hover:underline">{{ $paste->title }}</a></td>
                    <td class="border border-gray-300 p-2">{{$paste->updated_at}}</td>
                    <td class="border border-gray-300 p-2">{{$paste->expires_at}}</td>
                    <td class="border border-gray-300 p-2">{{$paste->language->name}}</td>
                    <td class="border border-gray-300 p-2">
                        <div class="flex gap-2">
                            <a href="{{ route('paste.edit', ['short_link' => $paste->short_link]) }}" class="text-blue-500 cursor-pointer hover:underline">Edit</a>
                            <form action="{{ route('paste.delete', ['short_link' => $paste->short_link]) }}" method="POST" onsubmit="return confirm('Вы уверены, что хотите удалить эту пасту?');">
                                @csrf
                                <button type="submit" class="text-red-500 cursor-pointer hover:underline">Delete</button>
                            </form>
                        </div>
                    </td>                          
                </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        @include('./../components/paginate')
    </div>
</div>