<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Address;
use Lunar\Models\Country;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Facades\Log;

class AddressPage extends Component
{
    public $company, $first_name, $last_name, $phone, $email;

    public $streetno, $address_line_two, $city, $postcode, $state, $country, $btw_no, $kvk;

    public $countries;

    public $billingAddress;

    public $billingAddressId;

    public $shipping_company;
    public $shipping_first_name;
    public $shipping_last_name;
    public $shipping_phone;
    public $shipping_email;
    public $shipping_streetno;
    public $shipping_address;
    public $shipping_city;
    public $shipping_postcode;
    public $shipping_state;
    public $shipping_countries;

    public $shippingAddresses;
    public $editingShippingAddressId;

    use WireUiActions;

    public function mount()
    {
        $user = auth()->user();
        $customer = $user->customers->first();
        // dd($user);
        $this->first_name = $customer->first_name;
        $this->last_name = $customer->last_name;
        $this->countries = Country::orderBy('name')->get();

        $this->billingAddress = Address::where('customer_id', $customer->id)
        ->where('billing_default', true)
        ->latest()
        ->first();

        if ($this->billingAddress) {
            $this->billingAddressId = $this->billingAddress->id;
            $this->company = $this->billingAddress->company_name;
            $this->phone = $this->billingAddress->contact_phone;
            $this->email = $this->billingAddress->contact_email;
            $this->streetno = $this->billingAddress->line_one;
            $this->address_line_two = $this->billingAddress->line_two;
            $this->city = $this->billingAddress->city;
            $this->state = $this->billingAddress->state;
            $this->postcode = $this->billingAddress->postcode;
            $this->country = $this->billingAddress->country->iso2 ?? '';
        }

        //for shipping addresses (Assuming if this user has only 1 CUSTOMER)
        $this->shippingAddresses = Address::where('customer_id', $user->customers->first()->id)
            ->where('shipping_default', true)
            ->get();
    }

    public function saveBillingAddress()
    {
        Log::info("fsdfsfsdsdfgsd");
        $user = auth()->user();

        $this->validate([
            'company' => 'nullable|string|max:255',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'streetno' => 'required|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'city' => 'required|string|max:255',
            'postcode' => 'required|string|max:20',
            'state' => 'nullable|string|max:255',
            'country' => 'required|string|size:2'
        ]);

        $country = Country::where('iso2', $this->country)->first();

        if (!$country) {
            session()->flash('error', 'Invalid country selected.');
            return;
        }

        $customer = $user->customers->first();
        $addressData = [
            'customer_id' => $customer->id,
            'title' => '',
            'first_name' => $customer->first_name,
            'last_name' => $customer->last_name,
            'company_name' => $this->company,
            'line_one' => $this->streetno,
            'line_two' => $this->address_line_two,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country_id' => $country->id,
            'contact_email' => $this->email,
            'contact_phone' => $this->phone,
            'billing_default' => true,
        ];

        // $addressData = [
        //     'customer_id' => $customer->id,
        //     'title' => '',
        //     'first_name' => $validatedData['first_name'], 
        //     'last_name' => $validatedData['last_name'],   
        //     'company_name' => $validatedData['company'],
        //     'line_one' => $validatedData['streetno'],
        //     'line_two' => $validatedData['address_line_two'],
        //     'city' => $validatedData['city'],
        //     'state' => $validatedData['state'],
        //     'postcode' => $validatedData['postcode'],
        //     'country_id' => $country->id,
        //     'contact_email' => $validatedData['email'],
        //     'contact_phone' => $validatedData['phone'],
        //     'billing_default' => true,
        // ];

        if ($this->billingAddressId) {
            Address::where('id', $this->billingAddressId)->update($addressData);
        } else {
            Address::create($addressData);
        }

        //session()->flash('success', 'Billing address saved successfully!');
        $this->mount();
    }

    public function saveShippingAddress()
    {
        $user = auth()->user();

        $this->validate([
            'shipping_company' => 'nullable|string|max:255',
            'shipping_first_name' => 'required|string|max:255',
            'shipping_last_name' => 'required|string|max:255',
            'shipping_phone' => 'required|string|max:20',
            'shipping_email' => 'required|email',
            'shipping_streetno' => 'required|string|max:255',
            'shipping_address' => 'nullable|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_postcode' => 'required|string|max:20',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_countries' => 'required|string|size:2',
        ]);

        $countryModel = Country::where('iso2', $this->shipping_countries)->first();

        if (!$countryModel) {
            session()->flash('error', 'Invalid country selected.');
            return;
        }

        $customer = $user->customers->first();

        if ($this->editingShippingAddressId) {
            $address = Address::find($this->editingShippingAddressId);
            if ($address) {
                $address->update([
                    'company_name' => $this->shipping_company,
                    'first_name' => $this->shipping_first_name,
                    'last_name' => $this->shipping_last_name,
                    'contact_phone' => $this->shipping_phone,
                    'contact_email' => $this->shipping_email,
                    'line_one' => $this->shipping_streetno,
                    'line_two' => $this->shipping_address,
                    'city' => $this->shipping_city,
                    'state' => $this->shipping_state,
                    'postcode' => $this->shipping_postcode,
                    'country_id' => $countryModel->id,
                    'shipping_default' => true,
                ]);
            }
        } else {
            Address::create([
                'customer_id' => $customer->id,
                'title' => '',
                'first_name' => $this->shipping_first_name,
                'last_name' => $this->shipping_last_name,
                'company_name' => $this->shipping_company,
                'line_one' => $this->shipping_streetno,
                'line_two' => $this->shipping_address,
                'city' => $this->shipping_city,
                'state' => $this->shipping_state,
                'postcode' => $this->shipping_postcode,
                'country_id' => $countryModel->id,
                'contact_email' => $this->shipping_email,
                'contact_phone' => $this->shipping_phone,
                'shipping_default' => true,
            ]);
        }

        $this->editingShippingAddressId = null;

        session()->flash('success', 'Shipping address saved successfully!');
        $this->mount();
    }

    public function editShippingAddress($addressId)
    {
        $address = Address::find($addressId);
        if (!$address) return;

        $this->editingShippingAddressId = $address->id;
        $this->shipping_company = $address->company_name;
        $this->shipping_first_name = $address->first_name;
        $this->shipping_last_name = $address->last_name;
        $this->shipping_phone = $address->contact_phone;
        $this->shipping_email = $address->contact_email;
        $this->shipping_streetno = $address->line_one;
        $this->shipping_address = $address->line_two;
        $this->shipping_city = $address->city;
        $this->shipping_postcode = $address->postcode;
        $this->shipping_state = $address->state;
        $this->shipping_countries = $address->country->iso2 ?? '';

        $this->dispatch('address-modal-open', id: $addressId);
    }


    public function billingAddressEditDialog(): void
    {
        $this->dialog()->id('billingAddressEdit')->show([
            'icon' => '',
            'accept' => [
                'label' => 'Save address',
                'method' => $this->saveBillingAddress(),
            ],
            'reject' => [
                'label' => 'Cancel',
                'method' => 'cancel',
            ]
        ]);
    }

    public function render()
    {
        return view('livewire.address-page', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}
