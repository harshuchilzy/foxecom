
<div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col gap-8 justify-center items-center lg:min-h-[70vh] bg-white">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12 w-full">
        <!-- Billing address section -->
        <div class="flex flex-col gap-8">
            <div class="flex justify-between w-full">
                <p class="font-inter font-semibold text-[22px] text-black">Billing Address</p>
                @if ($billingAddress)
                    <button class="cursor-pointer hover:text-[#1275EE] hover:shadow-lg rounded-lg" x-on:click="$openModal('billingAddressEdit')" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                        </svg>
                    </button>
                @else
                    <button class="cursor-pointer hover:text-[#1275EE] hover:shadow-lg rounded-lg" data-modal-target="billing-address-edit" x-on:click="$openModal('billingAddressEdit')" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </button>
                @endif
            </div>
            <div class="border border-[#008ECC] rounded-[6px] p-5 flex flex-col gap-4 items-start justify-start">
                @if( $billingAddress )
                    <div class="w-full">
                        @if ($billingAddress?->company_name)
                            <p class="font-inter font-normal text-[18px] text-black">{{ $billingAddress->company_name ?? '' }}</p>
                            <hr class="my-3">
                        @endif

                        <p class="font-inter font-normal text-[15px] text-black">{{ $first_name }} {{ $last_name }}</p>
                        @if (empty($billingAddress->postcode))
                            <button class="cursor-pointer flex gap-4 my-4 border py-3 px-6 hover:text-[#1275EE]" data-modal-target="billing-address-edit" data-modal-toggle="billing-address-edit" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke-width="1.5"  class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> <span>{{__('Add a billing address')}}</span>
                            </button>
                        @else
                            <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->line_one ?? '' }}</p>
                            <p class="font-inter font-normal text-[15px] text-black">{{ $postcode ?? '' }} {{ $city ?? '' }}</p>
                            <hr class="my-3">
                            <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->contact_email ?? '' }}</p>
                            <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->contact_phone ?? '' }}</p>
                        @endif

                    </div>
                @else
                    <div class="w-full">
                        <p class="font-inter font-normal text-[15px] text-black">Billing address is not found.</p>
                    </div>
                @endif

                <!-- Billing Address Edit modal -->
                <x-wui-modal-card name="billingAddressEdit" wire:model="billingAddressEdit" title="Billing Address" description="" >
                    <input type="hidden" name="billing_default" value="1">
                    <div class="mb-6">
                        <label for="company" class="block mb-2 text-sm font-medium text-gray-900 ">Company</label>
                        <input type="text" id="company" wire:model="company" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Foxergo" />
                    </div>
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 ">First name</label>
                            <input type="text" id="first_name" value="{{ $first_name }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last name</label>
                            <input type="text" id="last_name" value="{{ $last_name }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                        </div>
                        <div>
                            <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">Phone number</label>
                            <input type="tel" id="phone" wire:model="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                        </div>
                        <div>
                            <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email address</label>
                            <input type="email" id="email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="john.doe@foxergo.com" required />
                        </div>
                        <div>
                            <label for="streetno" class="block mb-2 text-sm font-medium text-gray-900 ">Street Number or House Number</label>
                            <input type="text" id="streetno" wire:model="streetno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="221B" required />
                        </div>
                        <div>
                            <label for="address-line-two" class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                            <input type="text" id="address-line-two" wire:model="address_line_two" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Baker Street" required />
                        </div>
                        <div>
                            <label for="city" class="block mb-2 text-sm font-medium text-gray-900 ">City</label>
                            <input type="text" id="city" wire:model="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Manchester" required />
                        </div>
                        <div>
                            <label for="postcode" class="block mb-2 text-sm font-medium text-gray-900 ">Postcode</label>
                            <input type="text" id="postcode" wire:model="postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="SW1A 1AA" required />
                        </div>
                        <div>
                            <label for="state" class="block mb-2 text-sm font-medium text-gray-900 ">State</label>
                            <input type="text" id="state" wire:model="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="West Midlands" required />
                        </div>
                        <div>
                            <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Country</label>
                            <select id="country" wire:model="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                <option value="">Choose a country</option>
                                @foreach ($countries as $c)
                                    <option value="{{ $c->iso2 }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <x-slot name="footer" class="flex justify-between gap-x-4">
                            <button type="submit" class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg"  wire:click="saveBillingAddress" primary >
                                <span wire:loading.remove wire:target="saveBillingAddress">Save Address</span>
                                <span wire:loading wire:target="saveBillingAddress">Saving...</span>
                            </button>
                            <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg" x-on:click="close">Cancel</button>
                        </x-slot>
                    </div>
                </x-wui-modal-card>

            </div>
        </div>


        <!-- Shipping Address section -->
        <div class="flex flex-col gap-8">
            <div class="flex justify-between w-full">
                <p class="font-inter font-semibold text-[22px] text-black">Shipping Address</p>
                <button class="cursor-pointer hover:text-[#1275EE] hover:shadow-lg rounded-lg"  x-on:click="$openModal('addShippingAddress')" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                </button>
            </div>
            <div class="relative overflow-x-auto border !border-[#008ECC] rounded-[6px]">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 ">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50  ">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Address
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Location
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Edit
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Delete
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($shippingAddresses as $address)
                        <tr class="odd:bg-white even:bg-gray-50 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $address->first_name }} {{ $address->last_name }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $address->line_one }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $address->city }}
                            </td>
                            <td class="px-6 py-4">
                                <button wire:click="editShippingAddress({{ $address->id }})" class="font-medium text-blue-600 hover:underline cursor-pointer"
                                type="button">Edit</button>
                            </td>
                            <td class="text-center">
                               <button
                                    warning
                                    class="p-2 ml-auto text-gray-600 transition-colors rounded-lg hover:bg-gray-100 hover:text-red-700 cursor-pointer"
                                    type="button"
                                    wire:click="dropShippingAddress({{ $address->id }})"
                                    wire:confirm="Are you sure you want to delete this address?"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                               </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">No shipping addresses found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <!-- Shipping Address add modal -->
                <x-wui-modal-card name="addShippingAddress" wire:model="addShippingAddress" title="Shipping Address" description="">
                    <input type="hidden" name="shipping_default">

                    <div class="p-4 md:p-5 space-y-4">
                        <div class="mb-6">
                            <label for="shipping_company" class="block mb-2 text-sm font-medium text-gray-900 ">Company</label>
                            <input type="text" id="shipping_company" wire:model="shipping_company" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Foxergo" required />
                        </div>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="shipping_first_name" class="block mb-2 text-sm font-medium text-gray-900 ">First name</label>
                                <input type="text" id="shipping_first_name" wire:model="shipping_first_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="John" required />
                            </div>
                            <div>
                                <label for="shipping_last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last name</label>
                                <input type="text" id="shipping_last_name" wire:model="shipping_last_name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Doe" required />
                            </div>
                            <div>
                                <label for="shipping_phone" class="block mb-2 text-sm font-medium text-gray-900 ">Phone number</label>
                                <input type="tel" id="shipping_phone" wire:model="shipping_phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                            </div>
                            <div>
                                <label for="shipping_email" class="block mb-2 text-sm font-medium text-gray-900 ">Email address</label>
                                <input type="email" id="shipping_email" wire:model="shipping_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="john.doe@foxergo.com" required />
                            </div>
                            <div>
                                <label for="shipping_streetno" class="block mb-2 text-sm font-medium text-gray-900 ">Street Number or House Number</label>
                                <input type="text" id="shipping_streetno" wire:model="shipping_streetno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="221B" required />
                            </div>
                            <div>
                                <label for="shipping_address" class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                                <input type="text" id="shipping_address" wire:model="shipping_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Baker Street" required />
                            </div>
                            <div>
                                <label for="shipping_city" class="block mb-2 text-sm font-medium text-gray-900 ">City</label>
                                <input type="text" id="shipping_city" wire:model="shipping_city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="London" required />
                            </div>
                            <div>
                                <label for="shipping_postcode" class="block mb-2 text-sm font-medium text-gray-900 ">Postcode</label>
                                <input type="text" id="shipping_postcode" wire:model="shipping_postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="SW1A 1AA" required />
                            </div>
                            <div>
                                <label for="shipping_state" class="block mb-2 text-sm font-medium text-gray-900 ">State</label>
                                <input type="text" id="shipping_state" wire:model="shipping_state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="West Midlands" required />
                            </div>
                            <div>
                                <label for="shipping_countries" class="block mb-2 text-sm font-medium text-gray-900 ">Country</label>
                                <select id="shipping_countries" wire:model="shipping_countries" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option selected>Choose a country</option>
                                    @foreach ($countries as $c)
                                        <option value="{{ $c->iso2 }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <x-slot name="footer" class="flex justify-between gap-x-4">
                        <button type="submit" class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg"  wire:click="saveShippingAddress(null)" primary >
                            <span wire:loading.remove wire:target="saveShippingAddress">Save Address</span>
                            <span wire:loading wire:target="saveShippingAddress">Saving...</span>
                        </button>
                        <button type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg" x-on:click="close">Cancel</button>
                    </x-slot>
                </x-wui-modal-card>

            </div>
        </div>
    </div>

    <!-- Address page scripts -->
    @script
        <script>
            let shippingModal;

            $wire.on('address-modal-open', () => {
                setTimeout(() => {
                    const options = {
                        backdrop: 'dynamic',
                        backdropClasses:
                            'bg-gray-900/50 fixed inset-0 z-40 backdrop',
                        closable: true,
                        onHide: () => {
                            console.log('modal is hidden');
                            document.querySelectorAll('.backdrop').forEach(el => el.style.display = 'none');
                        },
                        onShow: () => {
                            console.log('modal is shown');
                        },
                        onToggle: () => {
                            console.log('modal has been toggled');
                        }
                    };
                    shippingModal = new Modal(document.getElementById('shipping-address-add'), options);
                    shippingModal.show();
                }, 300);
            });

            // Listen for custom close event
            window.addEventListener('close-shipping-modal', () => {
                if (shippingModal) {
                    shippingModal.hide();
                }
            });
        </script>
    @endscript

</div>

