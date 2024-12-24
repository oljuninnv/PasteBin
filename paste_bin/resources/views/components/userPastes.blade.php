<div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div>
        <div class="mt-4">
            <ul class="flex flex-col gap-4">
                @if(isset($pastes) && $pastes->isNotEmpty())
                @foreach ($pastes as $paste)
                    <li class="border p-4 rounded-md shadow-md flex flex-col break-normal">
                        <a href="{{ route('user_paste', $paste->short_link) }}"
                            class="text-blue-600 hover:underline">{{ $paste->title }}</a>
                        <div class="flex gap-2">
                            <small class="text-gray-500">{{ $paste->created_at->format('d.m.Y H:i') }}</small>
                        </div>
                        
                    </li>
                @endforeach
                @endif
            </ul>
        </div>
    </div>
</div>