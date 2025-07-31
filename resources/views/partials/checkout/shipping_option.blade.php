<form wire:submit="saveShippingOption"
      class="bg-white rounded-xl">
    <div class="flex items-center justify-between ">
        <h3 class="font-semibold text-[18px] text-[#111111] mb-2">
            Delivery
        </h3>  
    </div>

    @if ($currentStep >= $step)
        <div class="">
            @if ($currentStep == $step)
                <div class="grid grid-cols-1 gap-4">
                    @foreach ($this->shippingOptions as $option)
                        <div>
                            <input class="hidden peer"
                                   type="radio"
                                   wire:model.live="chosenShipping"
                                   name="shippingOption"
                                   value="{{ $option->getIdentifier() }}"
                                   id="{{ $option->getIdentifier() }}" x-on:click="$wire.saveShippingOption" />

                            <label class="flex items-center justify-between p-4 text-sm font-medium border border-gray-100 rounded-lg shadow-sm cursor-pointer peer-checked:border-blue-500 hover:bg-gray-50 peer-checked:ring-1 peer-checked:ring-blue-500"
                                   for="{{ $option->getIdentifier() }}">
                                <p>
                                    {{ $option->getName() }}
                                </p>

                                <p>
                                    {{ $option->getPrice()->formatted() }}
                                </p>
                            </label>
                        </div>
                    @endforeach
                </div>

                @if ($errors->has('chosenShipping'))
                    <p class="p-4 text-sm text-red-500">
                        {{ $errors->first('chosenShipping') }}
                    </p>
                @endif
            @elseif($currentStep > $step && $this->shippingOption)
                <div class="flex flex-wrap max-w-xs text-sm">
                    <div class="w-1/2 font-medium">
                        {{ $this->shippingOption->getName() }}
                    </div>

                    <div class="w-1/2 text-right">
                        {{ $this->shippingOption->getPrice()->formatted() }}
                    </div>
                </div>
            @endif
    
        </div>
    @endif
</form>
