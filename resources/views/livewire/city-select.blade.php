<div class="form-group relative">
    <label class="block text-sm font-medium text-gray-700 mb-1">City</label>

    <input
        wire:model.debounce.300ms="inputsearch"
        type="text"
        class="form-control w-full bg-white dark:bg-neutral-800 rounded-0 py-2 text-zinc-900 dark:text-white"
        placeholder="Search city...">

    @if(strlen($inputsearch) > 1)
        <div class="absolute w-full bg-white dark:bg-neutral-800 shadow-lg mt-1 z-50 rounded max-h-60 overflow-y-auto">
            @if(count($searchResults) > 0)
                @foreach($searchResults as $city)
                    <div
                        wire:click="selectCity('{{ $city['value'] }}', '{{ $city['label'] }}')"
                        class="px-4 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-neutral-700 capitalize">
                        {{ $city['label'] }}
                    </div>
                @endforeach
            @else
                <div class="px-4 py-2 text-gray-500">No results found...</div>
            @endif
        </div>
    @endif

    <input type="hidden" wire:model="selectedCity" name="city" />
</div>
