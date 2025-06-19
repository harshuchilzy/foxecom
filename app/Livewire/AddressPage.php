<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Address;
use Lunar\Models\Country;

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

    public function mount()
    {
        $user = auth()->user();
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->countries = Country::orderBy('name')->get();

        $this->billingAddress = \Lunar\Models\Address::where('customer_id', auth()->id())
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

        //for shipping addresses
        $this->shippingAddresses = Address::where('customer_id', $user->id)
            ->where('title', 'shipping')
            ->latest()
            ->get();
    }

    public function saveBillingAddress()
    {
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
            'country' => 'required|string|size:2',
        ]);

        $countryModel = Country::where('iso2', $this->country)->first();

        if (!$countryModel) {
            session()->flash('error', 'Invalid country selected.');
            return;
        }

        // if (!$countryModel) {
        //     logger()->error('Invalid country selected', ['input' => $this->country]);
        //     session()->flash('error', 'Invalid country selected.');
        //     return;
        // }
        // logger()->info('Country resolved', ['country_id' => $countryModel->id]);

        // logger()->info('Creating address', [
        //     'first_name' => $this->first_name,
        //     'last_name' => $this->last_name,
        //     'email' => $this->email,
        // ]);

        // Address::create([
        //     'customer_id' => $user->id,
        //     'first_name' => $this->first_name,
        //     'last_name' => $this->last_name,
        //     'company_name' => $this->company,
        //     'line_one' => $this->streetno,
        //     'line_two' => $this->address_line_two,
        //     'city' => $this->city,
        //     'state' => $this->state,
        //     'postcode' => $this->postcode,
        //     'country_id' => $countryModel->id,
        //     'contact_email' => $this->email,
        //     'contact_phone' => $this->phone,
        //     'billing_default' => true,
        // ]);

        $addressData = [
            'customer_id' => $user->id,
            'title' => 'billing',
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'company_name' => $this->company,
            'line_one' => $this->streetno,
            'line_two' => $this->address_line_two,
            'city' => $this->city,
            'state' => $this->state,
            'postcode' => $this->postcode,
            'country_id' => $countryModel->id,
            'contact_email' => $this->email,
            'contact_phone' => $this->phone,
            'billing_default' => true,
        ];


        if ($this->billingAddressId) {
            \Lunar\Models\Address::where('id', $this->billingAddressId)->update($addressData);
        } else {
            \Lunar\Models\Address::create($addressData);
        }

        session()->flash('success', 'Billing address saved successfully!');
    }

    public function saveShippingAddress(){
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

        $countryModel = Country::where('iso2', $this->country)->first();

        if (!$countryModel) {
            session()->flash('error', 'Invalid country selected.');
            return;
        }

        Address::create([
            'customer_id' => $user->id,
            'title' => 'shipping',
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
            'billing_default' => true,
        ]);

        session()->flash('success', 'Shipping address saved successfully!');
    }

    public function render()
    {
        return view('livewire.address-page', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}
