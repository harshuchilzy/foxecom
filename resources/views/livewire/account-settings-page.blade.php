<div x-data="{ edit: $wire.entangle('edit'), show: { current: false, new: false, confirm: false } }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex flex-col gap-8">
        <div class="py-5">
            <h2 class="font-inter font-semibold text-[22px] text-black">Login & Security</h2>
        </div>

        @if (session()->has('message'))
            <div x-data="{ message: true }" x-init="setTimeout(() => message = false, 5000)" x-show="message"
                class="p-2 mt-4 text-xs font-medium text-center rounded text-green-700 border-green-600 bg-green-50"
                role="alert">
                {{ session('message') }}
            </div>
        @endif

        <div class="bg-white shadow rounded-lg overflow-hidden">

            <!-- Name (First + Last) -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 font-inter">Name</h3>

                        <!-- Read -->
                        <p class="mt-1 text-lg font-medium text-gray-900 font-inter">
                            {{ $firstName }} {{ $lastName }}
                        </p>

                        <!-- Edit -->
                        <div x-show="edit.name" class="mt-3 space-y-3" x-show="edit.name" x-cloak
                            x-transition.opacity.duration.200ms x-collapse>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">First name</label>
                                    <input type="text"
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                        wire:model="firstName" />
                                </div>
                                <div>
                                    <label class="block text-sm text-gray-600 mb-1">Last name</label>
                                    <input type="text"
                                        class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                        wire:model="lastName" />
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <button type="button" wire:click="updateName"
                                    class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg">
                                    <span wire:loading.remove wire:target="updateName">Save</span>
                                    <span wire:loading wire:target="updateName">Saving...</span>
                                </button>
                                <button @click="edit.name=false"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10  focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <button @click="edit.name=!edit.name"
                        class="text-[#1275EE] hover:text-[#11316d] cursor-pointer font-medium font-inter"
                        x-text="edit.name ? '' : 'Edit'"></button>
                </div>
            </div>

            <!-- Email -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 font-inter">Email</h3>

                        <!-- Read -->
                        <p x-show="!edit.email" class="mt-1 text-lg font-medium text-gray-900 font-inter">
                            {{ $email }}
                        </p>

                        <!-- Edit -->
                        <div x-show="edit.email" class="mt-3 space-y-3" x-show="edit.email" x-cloak
                            x-transition.opacity.duration.200ms x-collapse>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Email</label>
                                <input type="email" wire:model="email"
                                    class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="updateEmail"
                                    class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg">
                                    <span wire:loading.remove wire:target="updateEmail">Save</span>
                                    <span wire:loading wire:target="updateEmail">Saving...</span>
                                </button>
                                <button @click="edit.email=false"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10  focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <button @click="edit.email=!edit.email"
                        class="text-[#1275EE] hover:text-[#11316d] cursor-pointer font-medium font-inter"
                        x-text="edit.email ? '' : 'Edit'"></button>
                </div>
            </div>

            <!-- phone number -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 font-inter">Phone number</h3>

                        <!-- Read -->
                        <p class="mt-1 text-lg font-medium text-gray-900 font-inter">
                            {{ $phone }}
                        </p>
                        <p class="mt-2 text-sm text-gray-600">
                            Receive notifications with this mobile number.
                        </p>

                        <!-- Edit -->
                        <div x-show="edit.phoneNumber" class="mt-3 space-y-3" x-show="edit.phoneNumber" x-cloak
                            x-transition.opacity.duration.200ms x-collapse>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Phone number</label>
                                <input type="text" wire:model="phone"
                                    class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            </div>

                            <div class="flex gap-3">
                                <button wire:click="updatePhone"
                                    class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg">
                                    <span wire:loading.remove wire:target="updatePhone">Save</span>
                                    <span wire:loading wire:target="updatePhone">Saving...</span>
                                </button>
                                <button @click="edit.phoneNumber=false"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10  focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <button @click="edit.phoneNumber=!edit.phoneNumber"
                        class="text-[#1275EE] hover:text-[#11316d] cursor-pointer font-medium font-inter"
                        x-text="edit.phoneNumber ? '' : 'Edit'"></button>
                </div>
            </div>

            <!-- Company -->
            <div class="px-6 py-5 border-b border-gray-100">
                <div class="flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 font-inter">Company Name</h3>

                        <!-- Read -->
                        <p class="mt-1 text-lg font-medium text-gray-900 font-inter">
                            {{ $company }}
                        </p>

                        <!-- Edit -->
                        <div x-show="edit.company" class="mt-3 space-y-3" x-show="edit.name" x-cloak
                            x-transition.opacity.duration.200ms x-collapse>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Company name</label>
                                <input type="text" wire:model="company"
                                    class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" />
                            </div>
                            <div class="flex gap-3">
                                <button wire:click="updateCompany"
                                    class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg">
                                    <span wire:loading.remove wire:target="updateCompany">Save</span>
                                    <span wire:loading wire:target="updateCompany">Saving...</span>
                                </button>
                                <button @click="edit.company=false"
                                    class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10  focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg">Cancel</button>
                            </div>
                        </div>
                    </div>
                    <button @click="edit.company=!edit.company"
                        class="text-[#1275EE] hover:text-[#11316d] cursor-pointer font-medium font-inter"
                        x-text="edit.company ? '' : 'Edit'"></button>
                </div>
            </div>

            <!-- Password -->
            <div class="px-6 py-5">
                <div class="flex justify-between items-start gap-6">
                    <div class="flex-1">
                        <h3 class="text-sm font-medium text-gray-500 font-inter">Password</h3>

                        <!-- Read -->
                        <p x-show="!edit.password" class="mt-1 text-lg font-medium text-gray-900 font-inter">********
                        </p>

                        <!-- Edit -->
                        <div x-show="edit.password" x-cloak x-transition.opacity.duration.200ms x-collapse
                            class="mt-3 space-y-3">
                            <form wire:submit.prevent="updatePassword">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3" x-data="{ show: { current: false, new: false, confirm: false } }">

                                    <!-- Current Password -->
                                    <div class="relative">
                                        <label class="block text-sm text-gray-600 mb-1">Current password</label>
                                        <div class="relative">
                                            <input :type="show.current ? 'text' : 'password'"
                                                wire:model.defer="currentPassword" autocomplete="current-password"
                                                class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" />
                                            <button type="button" @click="show.current = !show.current"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                                <!-- Eye / Eye-off -->
                                                <svg x-show="!show.current" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="show.current" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.34-4.163m3.24-2.235A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.956 9.956 0 01-4.448 5.225M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M3 3l18 18" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- New Password -->
                                    <div class="relative">
                                        <label class="block text-sm text-gray-600 mb-1">New password</label>
                                        <div class="relative">
                                            <input :type="show.new ? 'text' : 'password'" wire:model.defer="password"
                                                autocomplete="new-password"
                                                class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" />
                                            <button type="button" @click="show.new = !show.new"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                                <svg x-show="!show.new" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="show.new" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.34-4.163m3.24-2.235A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.956 9.956 0 01-4.448 5.225M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M3 3l18 18" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="relative">
                                        <label class="block text-sm text-gray-600 mb-1">Confirm password</label>
                                        <div class="relative">
                                            <input :type="show.confirm ? 'text' : 'password'"
                                                wire:model.defer="password_confirmation" autocomplete="new-password"
                                                class="w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500 pr-10" />
                                            <button type="button" @click="show.confirm = !show.confirm"
                                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                                <svg x-show="!show.confirm" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                                <svg x-show="show.confirm" xmlns="http://www.w3.org/2000/svg"
                                                    class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.34-4.163m3.24-2.235A9.953 9.953 0 0112 5c4.478 0 8.269 2.943 9.543 7a9.956 9.956 0 01-4.448 5.225M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M3 3l18 18" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                @if ($errors->has('currentPassword'))
                                    <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
                                        role="alert">
                                        @foreach ($errors->get('currentPassword') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif

                                @if ($errors->has('password'))
                                    <div class="p-2 mt-4 text-xs font-medium text-center text-red-700 rounded bg-red-50"
                                        role="alert">
                                        @foreach ($errors->get('password') as $error)
                                            {{ $error }}
                                        @endforeach
                                    </div>
                                @endif

                                <div class="flex gap-3 mt-4">
                                    <button type="submit"
                                        class="!text-white !bg-[#11316d] hover:!bg-[#1275EE] focus:ring-4 focus:outline-none font-medium rounded-[60px] text-sm font-inter px-5 py-2.5 text-center cursor-pointer hover:shadow-lg">
                                        Save
                                    </button>
                                    <button type="button" @click="edit.password=false"
                                        class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-[60px] border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-gray-100 cursor-pointer font-inter hover:shadow-lg">
                                        Cancel
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>

                    <button @click="edit.password=!edit.password"
                        class="text-[#1275EE] hover:text-[#11316d] cursor-pointer font-medium font-inter"
                        x-text="edit.password ? '' : 'Edit'">
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
