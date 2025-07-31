<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerWelcomeMail;

new #[Layout('components.layouts.auth')] class extends Component {

    use Livewire\WithFileUploads;

    public string $first_name = '';
    public string $last_name = '';
    public string $country_code = '44'; // Default to UK
    public string $phone = '';
    public string $company_name = '';
    public string $company_type = '';
    public string $company_registration = '';
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
    public string $customer_type = 'retailer'; // default selection

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', 'min:8', Rules\Password::defaults()],
            'country_code' => ['required', 'string', 'max:5'],
            'phone' => ['required', 'string', 'max:15'],// 'regex:/^\d+$/'],
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'string'],
            'company_registration' => ['required', 'string', 'max:50'],
            'store_name' => ['nullable', 'string', 'max:255'],
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'in:uk,uae'],
            'city' => ['required', 'string', 'max:100'],
            'postcode' => ['required', 'string', 'max:20'],
            'company_sector' => ['nullable', 'string', 'max:100'],
            'store_url' => ['nullable', 'string', 'url', 'max:255'],
            'registration_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'vat_certificate' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'proof_of_id' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'proof_of_address' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $validated['registration_certificate'] = $this->registration_certificate?->store('uploads/registration_certificates', 'public');
        $validated['vat_certificate'] = $this->vat_certificate?->store('uploads/vat_certificates', 'public');
        $validated['proof_of_id'] = $this->proof_of_id?->store('uploads/proof_of_id', 'public');
        $validated['proof_of_address'] = $this->proof_of_address?->store('uploads/proof_of_address', 'public');

        event(new Registered(($user = User::create($validated))));

        $customer = Lunar\Models\Customer::create([
                        'first_name' => $validated['first_name'],
                        'last_name' => $validated['last_name'],
                        'company_name' => $validated['company_name'],
                        'vat_no' => null,
                        'meta' => $validated,
                    ]);

        $customer->users()->attach($user); //Assign User to the Customer

        $address = Lunar\Models\Address::create([
            'customer_id' => $customer->id,
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'company_name' => $validated['company_name'],
            'line_one' => $validated['address_line_1'],
            'line_two' => $validated['address_line_2'],
            'city' => $validated['city'],
            'postcode' => $validated['postcode'],
            'country_id' => $validated['country'] == 'uk' ? '235' : '234',
            'delivery_instructions' => 'null',
            'contact_email' => $validated['email'],
            'contact_phone' => $validated['phone'],
            'billing_default' => true,
        ]);

        $groupHandle = $this->customer_type === 'wholesaler' ? 'wholesale' : 'retail';
        $customerGroup = \Lunar\Models\CustomerGroup::where('handle', $groupHandle)->first();
        if ($customerGroup) {
            $customer->customerGroups()->attach($customerGroup);
        }

        Auth::login($user);

        Mail::to($validated['email'])->send(new CustomerWelcomeMail($validated['first_name'], $validated['last_name']));

        $this->redirectIntended(route('home', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6 w-full max-w-xl mx-auto font-zen-kaku-gothic-antique">
    <h2 class="text-center text-3xl font-semibold mt-6">{{__('Sign Up')}}</h2>
    <p class="text-gray-600 text-center">{{__('Helping retailers grow with fast access to high-demand products.')}}</p>

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <div class="border border-theme-zinc p-3">
        <label class="uppercase text-xs">Registration Type <span class="text-red-500 text-xs">*</span></label>
        <div class="flex gap-4 mt-2">
            <label class="flex items-center space-x-2">
                <input type="radio" wire:model="customer_type" value="retailer" />
                <span>Retailer</span>
            </label>
            <label class="flex items-center space-x-2">
                <input type="radio" wire:model="customer_type" value="wholesaler" />
                <span>Wholesaler</span>
            </label>
        </div>
    </div>

    <form wire:submit="register" class="flex flex-col gap-6">
        <div class="grid md:grid-cols-2 gap-4 border border-theme-zinc">
            <div class=" p-3">
                <!-- First Name -->
                <label for="first_name" class="uppercase text-xs">First Name <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="first_name" id="first_name"
                    class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    autofocus autocomplete="first_name" placeholder="{{ __('John') }}" />
                @error('first_name')
                <div class="mt-3 text-sm font-medium text-red-500">
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
                    class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    autofocus autocomplete="last_name" placeholder="{{ __('Doe') }}" />
                @error('last_name')
                <div class="mt-3 text-sm font-medium text-red-500">
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

        <div class="grid md:not-only-of-type:grid-cols-6 gap-4 border border-theme-zinc p-3">
            <div class="col-span-2">
                <label for="country_code" class="uppercase text-xs">Country Code <span
                        class="text-red-500 text-xs">*</span></label>
                <select wire:model="country_code" id="country_code" class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none">
                    <option value="971">+971 (UAE)</option>
                    <option value="44" selected>+44 (UK)</option>
                </select>
                @error('country_code')
                <div class="mt-3 text-sm font-medium text-red-500">
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
                    class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    autofocus autocomplete="phone" placeholder="{{ __('Phone Number* (e.g., 551234567)') }}" />
                @error('phone')
                <div class="mt-3 text-sm font-medium text-red-500">
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

        <div class="border border-theme-zinc p-3">
            <!-- Email -->
            <label for="email" class="uppercase text-xs">Email <span class="text-red-500 text-xs">*</span></label>
            <input type="email" wire:model="email" id="email"
                class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                autofocus autocomplete="email" placeholder="{{ __('user@foxecom.com') }}" />
            @error('email')
            <div class="mt-3 text-sm font-medium text-red-500">
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

        <div class="border border-theme-zinc p-3">
            <!-- Password -->
            <label for="password" class="uppercase text-xs">Password <span class="text-red-500 text-xs">*</span></label>
            <input type="password" wire:model="password" id="password"
                class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                autofocus autocomplete="password" placeholder="{{ __('********') }}" />
            <small class="text-xs text-gray-500">Password must be at least 8 characters long, contain at least one
                uppercase letter and one number.</small>
            @error('password')
            <div class="mt-3 text-sm font-medium text-red-500">
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

        <div class="border border-theme-zinc p-3">
            <!-- Password Confirmation -->
            <label for="password_confirmation" class="uppercase text-xs">Confirm Password</label>
            <input type="password" wire:model="password_confirmation" id="password_confirmation"
                class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                autofocus autocomplete="false" placeholder="{{ __('********') }}" />
            @error('password_confirmation')
            <div class="mt-3 text-sm font-medium text-red-500">
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

        <div class="mt-4">
            <h3 class="text-2xl">Company Details</h3>
        </div>

        <div class="space-y-4">
            <!-- Company Name -->
            <div class="border border-theme-zinc p-3">
                <label for="company_name" class="uppercase text-xs">Company Name <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="company_name" id="company_name"
                    class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="Enter your company name" />
                @error('company_name')
                <div class="mt-3 text-sm font-medium text-red-500">
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
            <div class="grid md:grid-cols-2 gap-4 border border-theme-zinc">
                <div class=" p-3">
                    <label for="company_type" class="uppercase text-xs">Choose Company Type</label>
                    <select wire:model="company_type" id="company_type"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 focus:outline-none">
                        <option value="">-- Select Type --</option>
                        <option value="retail">Retail</option>
                        <option value="fmcg">FMCG</option>
                        <option value="wholesale">Wholesale</option>
                        <option value="importer">Importer</option>
                    </select>
                    @error('company_type')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Company Registration Number -->
                <div class=" p-3">
                    <label for="company_registration" class="uppercase text-xs">Company Registration Number <span
                            class="text-red-500 text-xs">*</span></label>
                    <input type="text" wire:model="company_registration" id="company_registration"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                        placeholder="Enter registration number" />
                    @error('company_registration')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Store Name -->
            <div class="border border-theme-zinc p-3">
                <label for="store_name" class="uppercase text-xs">Store name (trading as)</label>
                <input type="text" wire:model="store_name" id="store_name"
                    class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="Store name" />
                @error('store_name')
                <div class="mt-3 text-sm font-medium text-red-500">
                    <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Address Line 1 -->
            <div class="border border-theme-zinc p-3">
                <label for="address_line_1" class="uppercase text-xs">Address Line 1 <span
                        class="text-red-500 text-xs">*</span></label>
                <input type="text" wire:model="address_line_1" id="address_line_1"
                    class="bg-white rounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="Street and number" />
                @error('address_line_1')
                <div class="mt-3 text-sm font-medium text-red-500"><svg class="shrink-0 size-5 inline"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}</div>
                @enderror
            </div>

            <!-- Address Line 2 -->
            <div class="border border-theme-zinc p-3">
                <label for="address_line_2" class="uppercase text-xs">Address Line 2</label>
                <input type="text" wire:model="address_line_2" id="address_line_2"
                    class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="Apartment, suite, etc." />
                @error('address_line_2')
                <div class="mt-3 text-sm font-medium text-red-500">
                    <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>


            <!-- Country (fixed to UK) -->
            <div class="border border-theme-zinc p-3 mb-3">
                <label class="uppercase text-xs">Country</label>
                <select wire:model="country" id="country" class="bg-whiterounded-0 block w-full py-2 text-zinc-900 focus:outline-none">
                    <option value="uk">United Kingdom</option>
                    <option value="uae">United Arab Emirates</option>
                </select>
            </div>

            <div class="grid md:grid-cols-2 gap-4 border border-theme-zinc">
                <div class="p-3 city-select">
                    <!-- City -->
                    <label for="city" class="uppercase text-xs">Select City <span class="text-red-500 text-xs">*</span></label>
                    <div x-data="{
                            open: false,
                            search: '',
                            selected: @entangle('city'),
                            options: [],
                            country: @entangle('country'),
                            init() {
                                this.fetchOptions();

                                // Watch country and refetch cities when it changes
                                this.$watch('country', value => {
                                    this.search = '';
                                    this.selected = '';
                                    this.fetchOptions();
                                });
                            },
                            fetchOptions() {
                                fetch(`{{ route('api.cities.search') }}?country=${this.country}&search=${encodeURIComponent(this.search)}`)
                                    .then(res => res.json())
                                    .then(data => this.options = data);
                            },
                            selectOption(option) {
                                this.selected = option.value;
                                this.open = false;
                            },
                            selectedLabel() {
                                const option = this.options.find(o => o.value === this.selected);
                                return option ? option.label : '';
                            }
                        }" x-init="init()" class="relative w-full">
                        <button type="button" @click="open = !open"
                            class="w-full px-4 py-2 text-sm text-left bg-white border border-[#6B7280] rounded-0 shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <span x-text="selectedLabel() || 'Select a city...'"></span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline float-right" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <div x-show="open" @click.away="open = false"
                            class="absolute z-10 mt-1 w-full bg-white border border-gray-300 rounded-md shadow-lg max-h-60 overflow-y-auto">
                            <input type="text" x-model="search" @input="fetchOptions()" placeholder="Search city..."
                                class="w-full px-4 py-2 border-b border-gray-300 text-sm focus:outline-none" />

                            <template x-for="option in options" :key="option.value">
                                <div @click="selectOption(option)" class="px-4 py-2 cursor-pointer hover:bg-blue-100"
                                    x-text="option.label"></div>
                            </template>

                            <div x-show="!options.length" class="px-4 py-2 text-gray-500 text-sm">
                                No results found.
                            </div>
                        </div>
                    </div>

                    @error('city')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Postcode -->
                <div class="p-3">
                    <label for="postcode" class="uppercase text-xs">Postcode <span class="text-red-500 text-xs">*</span></label>
                    <input type="text" wire:model="postcode" id="postcode"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                        placeholder="E.g. W1A 1AA" />
                    @error('postcode')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <!-- Sector -->
            <div class="border border-theme-zinc p-3">
                <label for="company_sector" class="uppercase text-xs">What sector is your company in?</label>
                <input type="text" wire:model="company_sector" id="company_sector"
                    class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="E.g. Technology, Retail, Healthcare" />
                @error('company_sector')
                <div class="mt-3 text-sm font-medium text-red-500">
                    <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>

            <!-- Website Link -->
            <div class="border border-theme-zinc p-3">
                <label for="store_url" class="uppercase text-xs">Website Link</label>
                <input type="url" wire:model="store_url" id="store_url"
                    class="bg-whiterounded-0 block w-full py-2 text-zinc-900 placeholder-zinc-400 focus:outline-none"
                    placeholder="https://yourcompany.com" />
                @error('store_url')
                <div class="mt-3 text-sm font-medium text-red-500">
                    <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div x-data="{ customerType: @entangle('customer_type') }" class="my-4">
            <div x-show="customerType === 'wholesaler'" class="grid md:grid-cols-2 gap-4 retailer-hidden-section">
                <!-- Company Registration Certificate -->
                <div class="border border-theme-zinc p-3">
                    <label for="registration_certificate" class="uppercase text-xs">Company Registration
                        Certificate</label>
                    <input type="file" wire:model="registration_certificate" id="registration_certificate"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 file:text-zinc-400 focus:outline-none" />
                    @error('registration_certificate')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- VAT Certificate -->
                <div class="border border-theme-zinc p-3">
                    <label for="vat_certificate" class="uppercase text-xs">VAT Certificate</label>
                    <input type="file" wire:model="vat_certificate" id="vat_certificate"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 file:text-zinc-400 focus:outline-none" />
                    @error('vat_certificate')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Proof of ID -->
                <div class="border border-theme-zinc p-3">
                    <label for="proof_of_id" class="uppercase text-xs">Proof of ID</label>
                    <input type="file" wire:model="proof_of_id" id="proof_of_id"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 file:text-zinc-400 focus:outline-none" />
                    @error('proof_of_id')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <!-- Proof of Address -->
                <div class="border border-theme-zinc p-3">
                    <label for="proof_of_address" class="uppercase text-xs">Proof of Address</label>
                    <input type="file" wire:model="proof_of_address" id="proof_of_address"
                        class="bg-whiterounded-0 block w-full py-2 text-zinc-900 file:text-zinc-400 focus:outline-none" />
                    @error('proof_of_address')
                    <div class="mt-3 text-sm font-medium text-red-500">
                        <svg class="shrink-0 size-5 inline" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end">
            <button type="submit"
                class="w-full text-white bg-themeblue font-semibold hover:bg-blue-600 py-5 px-5">{{__('Sign Up')}}</button>
        </div>
    </form>

    <div class="w-full text-zinc-600 mb-4">
        <p class="text-center overflow-hidden before:h-[1px] after:h-[1px] after:bg-black
           after:inline-block after:relative after:align-middle after:w-1/4
           before:bg-black before:inline-block before:relative before:align-middle
           before:w-1/4 before:right-2 after:left-2 mb-3 py-4">{{ __('Already have an account?') }}</p>
        <a href="{{route('login')}}"
            class="bg-gray-300 hover:bg-gray-500 px-5 py-5 w-full font-semibold text-white block text-center"
            wire:navigate>{{ __('Sign in to your FOXERGO account') }}</a>
    </div>
</div>