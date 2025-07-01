<form wire:submit="saveAddress('{{ $type }}')" class="bg-white">
    <div class="flex items-center justify-between mt-6">
        <h3 class="text-lg font-medium">
            {{$type == 'shipping' ? 'Delivery Address' : ucfirst($type) . ' Address'}}
        </h3>

        {{-- @if ($type == 'shipping' && $step == $currentStep)
        <label class="flex items-center p-2 rounded-lg cursor-pointer hover:bg-gray-50">
            <input class="w-5 h-5 text-green-600 border-gray-100 rounded" type="checkbox" value="1"
                wire:model.live="shippingIsBilling" />

            <span class="ml-2 text-xs font-medium">
                Same as billing
            </span>
        </label>
        @endif --}}
    </div>

    <div class="py-6">
        <div class="grid grid-cols-6 gap-4">

            <x-input.group class="col-span-3" label="First name" :errors="$errors->get($type . '.first_name')" required>
                <x-input.text wire:model="{{ $type }}.first_name" required />
            </x-input.group>

            <x-input.group class="col-span-3" label="Last name" :errors="$errors->get($type . '.last_name')" required>
                <x-input.text wire:model="{{ $type }}.last_name" required />
            </x-input.group>

            <x-input.group class="col-span-6" label="Company name" :errors="$errors->get($type . '.company_name')">
                <x-input.text wire:model="{{ $type }}.company_name" />
            </x-input.group>

            <x-input.group class="col-span-6 sm:col-span-3" label="Contact phone"
                :errors="$errors->get($type . '.contact_phone')">
                <x-input.text wire:model="{{ $type }}.contact_phone" />
            </x-input.group>

            <x-input.group class="col-span-6 sm:col-span-3" label="Contact email"
                :errors="$errors->get($type . '.contact_email')" required>
                <x-input.text wire:model="{{ $type }}.contact_email" type="email" required />
            </x-input.group>

            <div class="col-span-6">
                <hr class="h-px my-4 bg-gray-100 border-none">
            </div>

            <x-input.group class="col-span-3 sm:col-span-2" label="Address line 1"
                :errors="$errors->get($type . '.line_one')" required>
                <x-input.text wire:model="{{ $type }}.line_one" required />
            </x-input.group>

            <x-input.group class="col-span-3 sm:col-span-2" label="Address line 2"
                :errors="$errors->get($type . '.line_two')">
                <x-input.text wire:model="{{ $type }}.line_two" />
            </x-input.group>

            <x-input.group class="col-span-3 sm:col-span-2" label="Address line 3"
                :errors="$errors->get($type . '.line_three')">
                <x-input.text wire:model="{{ $type }}.line_three" />
            </x-input.group>

            <x-input.group class="col-span-3 sm:col-span-2" label="City" :errors="$errors->get($type . '.city')"
                required>
                <x-input.text wire:model="{{ $type }}.city" required />
            </x-input.group>

            <x-input.group class="col-span-3 sm:col-span-2" label="State / Province"
                :errors="$errors->get($type . '.state')">
                <x-input.text wire:model="{{ $type }}.state" />
            </x-input.group>

            <x-input.group class="col-span-3 sm:col-span-2" label="Postcode" :errors="$errors->get($type . '.postcode')"
                required>
                <x-input.text wire:model="{{ $type }}.postcode" required />
            </x-input.group>

            <x-input.group class="col-span-6" label="Country" :errors="$errors->get($type . '.country_id')" required>
                <select class="w-full p-3 border border-gray-200 rounded-lg sm:text-sm"
                    wire:model="{{ $type }}.country_id">
                    <option value>Select a country</option>
                    @foreach ($this->countries as $country)
                    <option value="{{ $country->id }}" wire:key="country_{{ $country->id }}">
                        {{ $country->native }}
                    </option>
                    @endforeach
                </select>
            </x-input.group>
        </div>

        <div class="mt-6 flex justify-between">
            <button class="px-5 py-3 w-auto text-white bg-[#0066FF] h-14 text-[16px] text-inter cursor-pointer rounded-full hover:bg-blue-500 font-normal text-center"
                type="submit" wire:key="submit_btn" wire:loading.attr="disabled" wire:target="saveAddress">
                <span wire:loading.remove wire:target="saveAddress">
                    Save Address
                </span>

                <span wire:loading wire:target="saveAddress">
                    <span class="inline-flex items-center">
                        Saving

                        <x-icon.loading />
                    </span>
                </span>
            </button>

            <a class="px-5 py-4 w-auto  text-black bg-[#ffffff] border-1 h-14 text-[16px] text-inter cursor-pointer rounded-full hover:bg-gray-100 font-normal text-center" x-on:click="showAddressEdit = false">Back</a>
        </div>
  
    </div>
    
</form>