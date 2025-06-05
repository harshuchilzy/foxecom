<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('components.layouts.auth')] class extends Component {
    public string $first_name = '';
    public string $last_name = '';
    public string $country_code = '44'; // Default to UK
    public string $phone = '';
    public string $company_name = '';
    public string $company_type = '';
    public string $company_registration_number = '';
    public string $store_name = '';
    public string $address_line_1 = '';
    public string $address_line_2 = '';
    public string $country = 'uk'; // Default to UK
    public string $city = '';
    public string $postcode = '';
    public string $company_sector = '';
    public string $store_url = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public $registration_certificate, $vat_certificate, $proof_of_id, $proof_of_address;


    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', 'min:8', 'alpha_num:ascii' , Rules\Password::defaults()],
            'country_code' => ['required', 'string', 'max:5'],
            'phone' => ['required', 'string', 'max:15', 'regex:/^\d+$/'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string', 'in:retail,fmcg,wholesale,importer'],
            'company_registration_number' => ['required', 'string', 'max:50'],
            'store_name' => ['nullable', 'string', 'max:255'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'in:uk,uae'],
            'city' => ['required', 'string', 'max:100'],
            'postcode' => ['required', 'string', 'max:20'],
            'company_sector' => ['nullable', 'string', 'max:100'],
            'store_url' => ['nullable', 'string', 'url', 'max:255'],
            'registration_certificate' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'vat_certificate' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'proof_of_id' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'proof_of_address' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered(($user = User::create($validated))));

        Auth::login($user);

        $this->redirectIntended(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6 w-full max-w-xl mx-auto font-zen-kaku-gothic-antique">
    <x-auth-header :title="__('Sign Up')"
        :description="__('Helping retailers grow with fast access to high-demand products.')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="register" class="flex flex-col gap-6">
        <div class="grid grid-cols-2 gap-4 border border-theme-zinc dark:border-neutral-700">
            <div class=" p-3">
                <!-- First Name -->
                <label for="first_name" class="uppercase text-xs">First Name <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="first_name" id="first_name"
                    class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    autofocus autocomplete="first_name" placeholder="{{ __('John') }}" />
                @error('first_name')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class=" p-3">
                <!-- Last Name -->
                <label for="last_name" class="uppercase text-xs">Last Name <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="last_name" id="last_name"
                    class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    autofocus autocomplete="last_name" placeholder="{{ __('Doe') }}" />
                @error('last_name')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="grid grid-cols-5 gap-4">
            <div>
                <label for="country_code" class="uppercase text-xs">Country Code <span
                        class="text-red-500 text-xs">*</span></label>
                <select wire:model="country_code" id="country_code"
                    class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none">
                    {{-- <option value="">Country Phone Code* (e.g., 971)</option> --}}
                    <option value="971">+971 (UAE)</option>
                    <option value="44" selected>+44 (UK)</option>
                </select>
                @error('country_code')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="col-span-4">
                <!-- Phone -->
                <label for="phone" class="uppercase text-xs">Phone Number <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="tel" wire:model="phone" id="phone"
                    class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    autofocus autocomplete="phone" placeholder="{{ __('Phone Number* (e.g., 551234567)') }}" />
                @error('phone')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon=""
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"
                        data-slot="icon">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div class="border border-theme-zinc dark:border-neutral-700 p-3">
            <!-- Email -->
            <label for="email" class="uppercase text-xs">Email <span class="text-red-500 text-xs">*</span></label>
            <input type="email" wire:model="email" id="email"
                class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                autofocus autocomplete="email" placeholder="{{ __('user@foxecom.com') }}" />
            @error('email')
            <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="border border-theme-zinc dark:border-neutral-700 p-3">
            <!-- Password -->
            <label for="password" class="uppercase text-xs">Password <span class="text-red-500 text-xs">*</span></label>
            <input type="password" wire:model="password" id="password"
                class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                autofocus autocomplete="password" placeholder="{{ __('********') }}" />
            <small class="text-xs text-gray-500">Password must be at least 8 characters long, contain at least one
                uppercase letter and one number.</small>
            @error('password')
            <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="border border-theme-zinc dark:border-neutral-700 p-3">
            <!-- Password Confirmation -->
            <label for="password_confirmation" class="uppercase text-xs">Confirm Password</label>
            <input type="password" wire:model="password" id="password_confirmation"
                class="bg-white dark:bg-neutral-800  rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                autofocus autocomplete="false" placeholder="{{ __('********') }}" />
            @error('password_confirmation')
            <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                <svg class="shrink-0 [:where(&amp;)]:size-5 inline" data-flux-icon="" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                    <path fill-rule="evenodd"
                        d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                        clip-rule="evenodd"></path>
                </svg>
                {{ $message }}
            </div>
            @enderror
        </div>

        <div>
            <h3>Company Details</h3>
        </div>

        <div class="space-y-4">
            <!-- Company Name -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="company_name" class="uppercase text-xs">Company Name <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="company_name" id="company_name"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="Enter your company name" />
                @error('company_name')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                    <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Company Type -->
            <div class="grid grid-cols-2 gap-4 border border-theme-zinc dark:border-neutral-700">
                <div class=" p-3">
                    <label for="company_type" class="uppercase text-xs">Choose Company Type</label>
                    <select wire:model="company_type" id="company_type"
                        class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white focus:outline-none">
                        <option value="">-- Select Type --</option>
                        <option value="retail">Retail</option>
                        <option value="fmcg">FMCG</option>
                        <option value="wholesale">Wholesale</option>
                        <option value="importer">Importer</option>
                    </select>
                    @error('company_type')
                    <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="..." />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Company Registration Number -->
                <div class=" p-3">
                    <label for="company_registration_number" class="uppercase text-xs">Company Registration Number <span
                            class="text-red-500 text-xs">*</span></label>
                    <input type="text" wire:model="company_registration_number" id="company_registration_number"
                        class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                        placeholder="Enter registration number" />
                    @error('company_registration_number')
                    <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Store Name -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="store_name" class="uppercase text-xs">Store name (trading as)</label>
                <input type="text" wire:model="store_name" id="store_name"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="Store name" />
                @error('store_name')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address Line 1 -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="address_line_1" class="uppercase text-xs">Address Line 1 <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="address_line_1" id="address_line_1"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="Street and number" />
                @error('address_line_1')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Address Line 2 -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="address_line_2" class="uppercase text-xs">Address Line 2</label>
                <input type="text" wire:model="address_line_2" id="address_line_2"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="Apartment, suite, etc." />
                @error('address_line_2')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <div x-data="{
                        country: 'uk',
                        city: '',
                        cities: {
                            uk: [
                                { 'value': 'london', 'label': 'London' },
                                { 'value': 'manchester', 'label': 'Manchester' },
                                { 'value': 'birmingham', 'label': 'Birmingham' },
                                { 'value': 'liverpool', 'label': 'Liverpool' },
                                { 'value': 'leeds', 'label': 'Leeds' },
                                { 'value': 'glasgow', 'label': 'Glasgow' },
                                { 'value': 'edinburgh', 'label': 'Edinburgh' },
                                { 'value': 'bristol', 'label': 'Bristol' },
                                { 'value': 'sheffield', 'label': 'Sheffield' },
                                { 'value': 'nottingham', 'label': 'Nottingham' }
                            ],
                            uae: [
                                { 'value': 'dubai', 'label': 'Dubai' },
                                { 'value': 'abu_dhabi', 'label': 'Abu Dhabi' },
                                { 'value': 'sharjah', 'label': 'Sharjah' },
                                { 'value': 'ajman', 'label': 'Ajman' },
                                { 'value': 'fujairah', 'label': 'Fujairah' },
                                { 'value': 'ras_al_khaimah', 'label': 'Ras Al Khaimah' },
                                { 'value': 'umm_al_quwain', 'label': 'Umm Al Quwain' },
                                { 'value': 'al_ain', 'label': 'Al Ain' },
                                { 'value': 'khorfakkan', 'label': 'Khor Fakkan' },
                                { 'value': 'dibba', 'label': 'Dibba' }
                            ]
                        }
                    }">
                <!-- Country (fixed to UK) -->
                <div class="border border-theme-zinc dark:border-neutral-700 p-3 mb-3">
                    <label class="uppercase text-xs">Country</label>
                    <select x-model="country" wire:model="country" id="country"
                        class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white focus:outline-none">
                        <option value="uk">United Kingdom</option>
                        <option value="uae">United Arab Emirates</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 border border-theme-zinc dark:border-neutral-700">
                    <div class=" p-3">
                        <!-- City -->
                        <label for="city" class="uppercase text-xs">Select City <span
                                class="text-red-500 text-xs">*</span></label>
                        <select x-model="city" wire:model="city" id="city"
                            class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white focus:outline-none">
                            {{-- <option value="">-- Select City --</option>
                            <option value="london">London</option>
                            <option value="manchester">Manchester</option>
                            <option value="birmingham">Birmingham</option> --}}
                            <option value="">-- Select City --</option>
                            <template x-for="option in cities[country] ?? []" :key="option.value">
                                <option :value="option.value" x-text="option.label"></option>
                            </template>
                            <!-- Add more as needed -->
                        </select>
                        @error('city')
                        <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Postcode -->
                    <div class="p-3">
                        <label for="postcode" class="uppercase text-xs">Postcode <span
                                class="text-red-500 text-xs">*</span></label>
                        <input type="text" wire:model="postcode" id="postcode"
                            class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                            placeholder="E.g. W1A 1AA" />
                        @error('postcode')
                        <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Sector -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="company_sector" class="uppercase text-xs">What sector is your company in?</label>
                <input type="text" wire:model="company_sector" id="company_sector"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="E.g. Technology, Retail, Healthcare" />
                @error('company_sector')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Website Link -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="store_url" class="uppercase text-xs">Website Link</label>
                <input type="url" wire:model="store_url" id="store_url"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white placeholder-zinc-400 dark:placeholder-neutral-500 focus:outline-none"
                    placeholder="https://yourcompany.com" />
                @error('store_url')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="my-4 grid grid-cols-2 gap-4">
            <!-- Company Registration Certificate -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="registration_certificate" class="uppercase text-xs">Company Registration Certificate</label>
                <input type="file" wire:model="registration_certificate" id="registration_certificate"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white file:text-zinc-400 dark:file:text-neutral-500 focus:outline-none" />
                @error('registration_certificate')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- VAT Certificate -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="vat_certificate" class="uppercase text-xs">VAT Certificate</label>
                <input type="file" wire:model="vat_certificate" id="vat_certificate"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white file:text-zinc-400 dark:file:text-neutral-500 focus:outline-none" />
                @error('vat_certificate')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Proof of ID -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="proof_of_id" class="uppercase text-xs">Proof of ID</label>
                <input type="file" wire:model="proof_of_id" id="proof_of_id"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white file:text-zinc-400 dark:file:text-neutral-500 focus:outline-none" />
                @error('proof_of_id')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>

            <!-- Proof of Address -->
            <div class="border border-theme-zinc dark:border-neutral-700 p-3">
                <label for="proof_of_address" class="uppercase text-xs">Proof of Address</label>
                <input type="file" wire:model="proof_of_address" id="proof_of_address"
                    class="bg-white dark:bg-neutral-800 rounded-0 block w-full py-2 text-zinc-900 dark:text-white file:text-zinc-400 dark:file:text-neutral-500 focus:outline-none" />
                @error('proof_of_address')
                <div class="mt-3 text-sm font-medium text-red-500 dark:text-red-400">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit"
                class="w-full text-white bg-themeblue font-semibold hover:bg-blue-600 py-5 px-5">{{__('Sign
                Up')}}</button>
        </div>
    </form>

    <div class="w-full text-zinc-600 dark:text-zinc-400 mb-4">
        <p class="text-center overflow-hidden before:h-[1px] after:h-[1px] after:bg-black 
           after:inline-block after:relative after:align-middle after:w-1/4 
           before:bg-black before:inline-block before:relative before:align-middle 
           before:w-1/4 before:right-2 after:left-2 mb-3 py-4">{{ __('Already have an account?') }}</p>
        <a href="{{route('login')}}"
            class="bg-gray-300 hover:bg-gray-500 px-5 py-5 w-full font-semibold text-white block text-center"
            wire:navigate>{{ __('Sign in to your FOXERGO account') }}</a>
    </div>
</div>