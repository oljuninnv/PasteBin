<div>
    <table class="min-w-full border-collapse border border-gray-300 overflow-x-auto">
        <thead>
            <tr class="bg-gray-100">
                <th class="border border-gray-300 p-2">Название пасты</th>
                <th class="border border-gray-300 p-2">Дата создания</th>
                <th class="border border-gray-300 p-2">Истекает</th>
                <th class="border border-gray-300 p-2">Просмотры</th>
                <th class="border border-gray-300 p-2">Комментарии</th>
                <th class="border border-gray-300 p-2">Синтаксис</th>
                <th class="border border-gray-300 p-2">Действия</th>
            </tr>
        </thead>
        <tbody>
            {{-- @foreach($pastes as $paste) --}}
                <tr>
                    <td class="border border-gray-300 p-2">Untitled</td>
                    <td class="border border-gray-300 p-2">17.12.24</td>
                    <td class="border border-gray-300 p-2">Never</td>
                    <td class="border border-gray-300 p-2">8</td>
                    <td class="border border-gray-300 p-2">0</td>
                    <td class="border border-gray-300 p-2">None</td>
                    <td class="border border-gray-300 p-2">
                        <div class="flex gap-2">
                            <p class="text-blue-500 cursor-pointer hover:underline">Edit</p>
                            <p class="text-red-500 cursor-pointer hover:underline">Delete</p>    
                        </div>
                    </td>                          
                </tr>
            {{-- @endforeach --}}
        </tbody>
    </table>
    <div>
        @include('./../components/paginate')
    </div>
</div>