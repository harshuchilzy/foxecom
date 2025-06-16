<div class="sm:relative">
    <div x-data="{ linesVisible: $wire.entangle('linesVisible') }">
        <button class="grid w-16 h-16 transition border-l border-gray-100 lg:border-l-transparent hover:opacity-75"
            x-on:click="linesVisible = !linesVisible">
            <span class="sr-only">Cart</span>

            <span class="place-self-center">
                <svg width="53" height="38" viewBox="0 0 53 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M52.7 10.2683C52.5473 10.1087 52.3448 9.97836 52.1094 9.88837C51.8741 9.79839 51.6128 9.75135 51.3476 9.75123H16.0201L13.3459 2.96201C12.2972 0.288603 9.8053 0 8.78325 0H1.65299C0.739077 0 0 0.54473 0 1.21691C0 1.88909 0.739909 2.43379 1.65294 2.43379H8.78236C9.00791 2.43379 9.69622 2.43379 10.1657 3.62803L19.365 28.5183C19.5648 29.0435 20.2148 29.4062 20.9563 29.4062H43.4266C44.1241 29.4062 44.7466 29.0845 44.9822 28.601L52.9023 11.3798C53.0846 11.0067 53.0088 10.5912 52.7 10.2683ZM42.2633 26.973H22.211L16.9492 12.1857H48.9975L42.2633 26.973ZM38.985 31.8725C36.6862 31.8725 34.8235 33.2439 34.8235 34.9363C34.8235 36.6287 36.6862 38 38.985 38C41.2838 38 43.1465 36.6287 43.1465 34.9363C43.1465 33.2439 41.2838 31.8725 38.985 31.8725ZM24.0037 31.8725C21.7049 31.8725 19.8422 33.2439 19.8422 34.9363C19.8422 36.6287 21.7049 38 24.0037 38C26.3025 38 28.1652 36.6287 28.1652 34.9363C28.1652 33.2439 26.3025 31.8725 24.0037 31.8725Z"
                        fill="white" />
                </svg>
            </span>
        </button>

        <script>
            document.addEventListener('livewire:load', function() {
                console.log($wire.foo);
            });
        </script>
        <div class="absolute inset-x-0 top-auto z-50 w-screen max-w-sm px-6 py-8 mx-auto mt-4 bg-white border border-gray-100 shadow-xl sm:left-auto rounded-xl"
            x-show="linesVisible" x-on:click.away="linesVisible = false" x-transition x-cloak>
            <button class="absolute text-gray-500 transition-transform top-3 right-3 hover:scale-110" type="button"
                aria-label="Close" x-on:click="linesVisible = false">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <div>
                @if ($this->cart)
                    @if ($lines)
                        <div class="flow-root">
                            <ul class="-my-4 overflow-y-auto divide-y divide-gray-100 max-h-96">
                                @foreach ($lines as $index => $line)
                                    <li>
                                        <div class="flex py-4" wire:key="line_{{ $line['id'] }}">
                                            @if ($line['thumbnail'])
                                                <img class="object-cover w-16 h-16 rounded"
                                                    src="{{ $line['thumbnail'] }}">
                                            @endif

                                            <div class="flex-1 ml-4">
                                                <p class="max-w-[20ch] text-sm font-medium text-black">
                                                    {{ $line['description'] }}
                                                </p>

                                                <span class="block mt-1 text-xs text-gray-500">
                                                    {{ $line['identifier'] }} / {{ $line['options'] }}
                                                </span>

                                                <div class="flex items-center mt-2">
                                                    <input
                                                        class="w-16 p-2 text-xs transition-colors border border-gray-100 rounded-lg text-black"
                                                        type="number"
                                                        wire:model.live="lines.{{ $index }}.quantity" />

                                                    <p class="ml-2 text-xs text-black">
                                                        @ {{ $line['unit_price'] }}
                                                    </p>

                                                    <button
                                                        class="p-2 ml-auto text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-gray-700"
                                                        type="button" wire:click="removeLine('{{ $line['id'] }}')">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        @if ($errors->get('lines.' . $index . '.quantity'))
                                            <div class="p-2 mb-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
                                                role="alert">
                                                @foreach ($errors->get('lines.' . $index . '.quantity') as $error)
                                                    {{ $error }}
                                                @endforeach
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="py-4 text-sm font-medium text-center text-gray-500">
                            Your cart is empty
                        </p>
                    @endif

                    <dl class="flex flex-wrap pt-4 mt-6 text-sm border-t border-gray-100">
                        <dt class="w-1/2 font-medium">
                            Sub Total
                        </dt>

                        <dd class="w-1/2 text-right">
                            {{ $this->cart->subTotal->formatted() }}
                        </dd>
                    </dl>
                @else
                    <p class="py-4 text-sm font-medium text-center text-gray-500">
                        Your cart is empty
                    </p>
                @endif
            </div>

            @if ($this->cart)
                <div class="mt-4 space-y-4 text-center">
                    <button
                        class="block w-full p-3 text-sm font-medium text-blue-800 border border-blue-600 rounded-[100px] hover:ring-1 hover:ring-blue-600"
                        type="button" wire:click="updateLines">
                        Update Cart
                    </button>

                    <a class="block w-full p-3 text-sm font-medium text-center text-white bg-blue-600 rounded-[100px] hover:bg-blue-500"
                        href="{{ route('checkout.view') }}" wire:navigate>
                        Checkout
                    </a>

                    <a class="inline-block text-sm font-medium text-gray-600 underline hover:text-gray-500"
                        href="{{ url('/') }}">
                        Continue Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
