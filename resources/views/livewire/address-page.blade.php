{{-- <x-layouts.app.layout> --}}
    <div class="max-w-[1440px] mx-auto px-5 py-12 flex flex-col gap-8 justify-center items-center lg:h-[70vh] bg-white">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 w-full">
            <div class="flex flex-col gap-8">
                <div class="flex justify-between w-full">
                    <p class="font-inter font-semibold text-[22px] text-black">Billing Address</p>
                    @if ($billingAddress)
                        <button class="cursor-pointer" data-modal-target="billing-address-edit" data-modal-toggle="billing-address-edit" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                    @else
                        <button class="cursor-pointer" data-modal-target="billing-address-edit" data-modal-toggle="billing-address-edit" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                        </button>
                    @endif
                </div>
                <div class="border border-[#008ECC] rounded-[6px] p-5 flex flex-col gap-4 items-start justify-start">
                    <div class="w-full">
                        <p class="font-inter font-normal text-[18px] text-black">{{ $billingAddress->company_name ?? '' }}</p>
                        <hr class="my-3">

                        <p class="font-inter font-normal text-[15px] text-black">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
                        <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->line_one ?? '—' }}</p>
                        <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->postcode ?? '—' }} {{ $billingAddress->city ?? '' }}</p>

                        <hr class="my-3">
                        <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->contact_email ?? '—' }}</p>
                        <p class="font-inter font-normal text-[15px] text-black">{{ $billingAddress->contact_phone ?? '—' }}</p>
                    </div>

                    @if (session()->has('success'))
                        <div class="text-green-600 font-medium">{{ session('success') }}</div>
                    @endif

                    <!-- Billing Address Edit modal -->
                    <div id="billing-address-edit" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-lg shadow-sm">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900">
                                        Edit Billing Address
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="billing-address-edit">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <div class="p-4 md:p-5 space-y-4">
                                    <form wire:submit.prevent="saveBillingAddress" novalidate>
                                        @csrf
                                        <input type="hidden" name="billing_default" value="1">
                                        @if (session()->has('success'))
                                            <div class="text-green-600 font-medium">{{ session('success') }}</div>
                                        @endif

                                        @if ($errors->any())
                                            <div class="text-red-600 font-medium">
                                                <ul class="list-disc pl-5">
                                                    @foreach ($errors->all() as $error)
                                                        <li>{{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                        <div class="mb-6">
                                            <label for="company" class="block mb-2 text-sm font-medium text-gray-900 ">Company</label>
                                            <input type="text" id="company" name="company" wire:model="company" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Flowbite" />
                                            @error('company') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                                            <div>
                                                <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900 ">First name</label>
                                                <input type="text" id="first_name" name="first_name" value="{{ auth()->user()->first_name }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                                            </div>
                                            <div>
                                                <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 ">Last name</label>
                                                <input type="text" id="last_name" name="last_name" value="{{ auth()->user()->last_name }}" disabled class="bg-gray-100 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5" />
                                            </div>
                                            <div>
                                                <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 ">Phone number</label>
                                                <input type="tel" id="phone" name="phone" wire:model.defer="phone" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="123-45-678" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" required />
                                                @error('phone') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="email" class="block mb-2 text-sm font-medium text-gray-900 ">Email address</label>
                                                <input type="email" id="email" name="email" wire:model="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="john.doe@company.com" required />
                                                @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="streetno" class="block mb-2 text-sm font-medium text-gray-900 ">Street Number or House Number</label>
                                                <input type="streetno" id="streetno" name="streetno" wire:model="streetno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Nieuw verzenadres 12" required />
                                            </div>
                                            <div>
                                                <label for="address-line-two" class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                                                <input type="address-line-two" id="address-line-two" name="address_line_two" wire:model="address_line_two" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Nieuw verzenadres 12" required />
                                                @error('address-line-two') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="city" class="block mb-2 text-sm font-medium text-gray-900 ">City</label>
                                                <input type="city" id="city" name="city" wire:model="city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Nieuw verzenadres 12" required />
                                                @error('city') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="postcode" class="block mb-2 text-sm font-medium text-gray-900 ">Postcode</label>
                                                <input type="postcode" id="postcode" name="postcode" wire:model="postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="81844" required />
                                                @error('postcode') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="state" class="block mb-2 text-sm font-medium text-gray-900 ">State</label>
                                                <input type="state" id="state" name="state" wire:model="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Soest" required />
                                                @error('state') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="country" class="block mb-2 text-sm font-medium text-gray-900">Country</label>
                                                <select id="country" name="country" wire:model="country" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                                    <option value="">Choose a country</option>
                                                    @foreach ($countries as $c)
                                                        <option value="{{ $c->iso2 }}">{{ $c->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('country') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                        <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                                            <button data-modal-hide="billing-address-edit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Save</button>
                                            <button data-modal-hide="billing-address-edit" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="flex flex-col gap-8">
                <div class="flex justify-between w-full">
                    <p class="font-inter font-semibold text-[22px] text-black">Shipping Address</p>
                    <button class="cursor-pointer" data-modal-target="shipping-address-add" data-modal-toggle="shipping-address-add" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    </button>
                </div>
                <div class="relative overflow-x-auto border border-[#008ECC] rounded-[6px]">

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
                                    <a href="#" class="font-medium text-blue-600 hover:underline"
                                    data-modal-target="shipping-address-edit"
                                    data-modal-toggle="shipping-address-edit"
                                    type="button">Edit</a>
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
                    <div id="shipping-address-add" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-2xl max-h-full">
                            <div class="relative bg-white rounded-lg shadow-sm ">
                                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t  border-gray-200">
                                    <h3 class="text-xl font-semibold text-gray-900 ">
                                        New Shipping Address
                                    </h3>
                                    <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center" data-modal-hide="shipping-address-add">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <form wire:submit.prevent="saveShippingAddress" novalidate>
                                    @csrf
                                    <input type="hidden" name="shipping_default">
                                    @if (session()-> has('success'))
                                        <div class="text-green-600 font-medium">{{ session('success') }}</div>
                                    @endif

                                    @if ($errors->any())
                                        <div class="text-red-600 font-medium">
                                            <ul class="list-disc pl-5">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <div class="p-4 md:p-5 space-y-4">
                                        <div class="mb-6">
                                            <label for="shipping_company" class="block mb-2 text-sm font-medium text-gray-900 ">Company</label>
                                            <input type="text" id="shipping_company" wire:model="shipping_company" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Flowbite" required />
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
                                                <input type="email" id="shipping_email" wire:model="shipping_email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="john.doe@company.com" required />
                                            </div>
                                            <div>
                                                <label for="shipping_streetno" class="block mb-2 text-sm font-medium text-gray-900 ">Street Number or House Number</label>
                                                <input type="text" id="shipping_streetno" wire:model="shipping_streetno" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Nieuw verzenadres 12" required />
                                            </div>
                                            <div>
                                                <label for="shipping_address" class="block mb-2 text-sm font-medium text-gray-900 ">Address</label>
                                                <input type="text" id="shipping_address" wire:model="shipping_address" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Nieuw verzenadres 12" required />
                                            </div>
                                            <div>
                                                <label for="shipping_city" class="block mb-2 text-sm font-medium text-gray-900 ">City</label>
                                                <input type="text" id="shipping_city" wire:model="shipping_city" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="81844" required />
                                            </div>
                                            <div>
                                                <label for="shipping_postcode" class="block mb-2 text-sm font-medium text-gray-900 ">Postcode</label>
                                                <input type="text" id="shipping_postcode" wire:model="shipping_postcode" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="81844" required />
                                            </div>
                                            <div>
                                                <label for="shipping_state" class="block mb-2 text-sm font-medium text-gray-900 ">State</label>
                                                <input type="text" id="shipping_state" wire:model="shipping_state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 " placeholder="Soest" required />
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
                                    <div class="flex justify-end items-center p-4 md:p-5 border-t border-gray-200 rounded-b ">
                                        <button data-modal-hide="shipping-address-edit" type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center ">Save</button>
                                        <button data-modal-hide="shipping-address-edit" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{-- </x-layouts.app.layout> --}}
