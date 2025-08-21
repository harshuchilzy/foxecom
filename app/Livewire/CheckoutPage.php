<?php

namespace App\Livewire;

use Lunar\Models\Cart;
use Livewire\Component;
use Illuminate\View\View;
use Lunar\Models\Address;
use Lunar\Models\Country;
use Lunar\Facades\Payments;
use Lunar\Admin\Models\Staff;
use Lunar\Models\CartAddress;
use Lunar\Facades\CartSession;
use WireUi\Traits\WireUiActions;
use App\Mail\CustomerNewOrderMail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Lunar\Facades\ShippingManifest;
use Illuminate\Support\Facades\Mail;

class CheckoutPage extends Component
{
    use WireUiActions;

    /**
     * The Cart instance.
     */
    public ?Cart $cart;

    /**
     * Address type
     */
    public $type = 'shipping';

    /**
     * Selected ShippingAddress
     */
    public $selectedShippingAddress;

    public $clientPassword;
    public $authentication = false;
    public $staffMemberFound = null;

    /**
     * The shipping address instance.
     */
    public $shipping = [];
    public $delivery = [];

    /**
     * The billing address instance.
     */
    public $billing = [];

    /**
     * The current checkout step.
     */
    public int $currentStep = 1;

    /**
     * Whether the shipping address is the billing address too.
     */
    public bool $shippingIsBilling = true;

    /**
     * The chosen shipping option.
     */
    public $chosenShipping = null;

    

    /**
     * The checkout steps.
     */
    public array $steps = [
        'shipping_option' => 1,
        'payment' => 2,
        'confirmation' => 3,
    ];

    /**
     * Delivery Option Verified
     */
    public $deliveryOptionVerified = false;

    /**
     * Show AddressEdit
     */
    public $showAddressEdit = false;

    /**
     * The payment type we want to use.
     */
    public string $paymentType = 'ngenius';

    /**
     * {@inheritDoc}
     */
    protected $listeners = [
        'cartUpdated' => 'refreshCart',
        'selectedShippingOption' => 'refreshCart',
    ];

    /**
     * Payment intent
     */
    public $payment_intent = null;

    /**
     * Payment intent client secret
     */
    public $payment_intent_client_secret = null;

    /**
     * Payment string
     */
    protected $queryString = [
        'payment_intent',
        'payment_intent_client_secret',
    ];

    /**
     * {@inheritDoc}
     */
    public function rules(): array
    {
        return array_merge(
            $this->getAddressValidation('shipping'),
            $this->getAddressValidation('billing'),
            [
                'shippingIsBilling' => 'boolean',
                'chosenShipping' => 'required',
            ]
        );
    }

    public function mount(): void
    {
        if (!$this->cart = CartSession::current()) {
            $this->redirect('/');

            return;
        }

        if ($this->payment_intent) {
            $payment = Payments::driver($this->paymentType)->cart($this->cart)->withData([
                'payment_intent_client_secret' => $this->payment_intent_client_secret,
                'payment_intent' => $this->payment_intent,
            ])->authorize();

            if ($payment->success) {
                redirect()->route('checkout-success.view');

                return;
            }
        }

        // Do we have a shipping address?
        $this->shipping = $this->cart->shippingAddress ?: new CartAddress;

        $customer = auth()->check() ? auth()->user()->customers->first() : null;

        if (($this->shipping) && $customer) {
            
            $this->shipping = $customer->addresses->where('billing_default', 1)->first()?->toArray();

            if (empty($this->shipping)) {
                $this->redirect('/addresses');
                return;
            }

            $this->cart->setShippingAddress($this->shipping);
            $this->shipping = new CartAddress($this->shipping);
        }

        $this->billing = $this->cart->billingAddress ?: new CartAddress;

        if (($this->billing) && $customer) {
            
            $this->billing = $customer->addresses->where('billing_default', 1)->first()?->toArray();
            $this->cart->setBillingAddress($this->billing);
            $this->billing = new CartAddress($this->billing);

        }
        $this->determineCheckoutStep();

        $this->saveShippingOption();

    }


    public function hydrate(): void
    {
        $this->cart = CartSession::current();
    }

    /**
     * Trigger an event to refresh addresses.
     */
    public function triggerAddressRefresh(): void
    {
        $this->dispatch('refreshAddress');
    }

    /**
     * Determines what checkout step we should be at.
     */
    public function determineCheckoutStep(): void
    {
        $shippingAddress = $this->cart->shippingAddress;
        $this->shipping = $this->cart->shippingAddress?->toArray() ?? [];
        
        if ($shippingAddress) {

            // Do we have a selected option?
            if ($this->shippingOption && $shippingAddress->id) {
                $this->chosenShipping = $this->shippingOption->getIdentifier();
                $this->currentStep = $this->steps['shipping_option'] + 1;
                $this->deliveryOptionVerified = true;
            } else {
                $this->currentStep = $this->steps['shipping_option'];
                $this->chosenShipping = $this->shippingOptions->first()?->getIdentifier();
                return;
            }

        }
       
    }

    public function saveAndContinueToNext()
    {
        $this->determineCheckoutStep();
    }

    /**
     * Refresh the cart instance.
     */
    public function refreshCart(): void
    {
        $this->cart = CartSession::current();
    }

    /**
     * Return the shipping option.
     */
    public function getShippingOptionProperty()
    {
        $shippingAddress = $this->cart->shippingAddress;

        if (!$shippingAddress) {
            return;
        }

        if ($option = $shippingAddress->shipping_option) {
            return ShippingManifest::getOptions($this->cart)->first(function ($opt) use ($option) {
                return $opt->getIdentifier() == $option;
            });
        }

        return null;
    }

    function updatedSelectedShippingAddress(): void
    {
        if (auth()->check()) {
            $customer = auth()->user()->customers->first();
            $this->shipping = $customer->addresses->find($this->selectedShippingAddress)?->toArray();
            $this->cart->setShippingAddress($this->shipping);
        }
    }

    /**
     * Save the address for a given type.
     */
    public function saveAddress(string $type): void
    {
        $validatedData = $this->validate(
            $this->getAddressValidation($type)
        );

        $address = $this->{$type};

        if ($type == 'delivery') {
            $this->shipping = new CartAddress();
            $this->cart->setShippingAddress($address);
            $this->shipping = $this->cart->shippingAddress;
        }

        $this->determineCheckoutStep();
        $this->showAddressEdit = false;
    }

    /**
     * Save the selected shipping option.
     */
    public function saveShippingOption(): void
    {
        $option = $this->shippingOptions->first(fn ($option) => $option->getIdentifier() == $this->chosenShipping);
        CartSession::setShippingOption($option);
        $this->refreshCart();
    }

    public function checkout()
    {
        if( empty($this->clientPassword) ) {
            $this->addError('client-key-error', 'Client password is empty');
            return;
        }

        if( !$this->verifyAuthenticationKey() ) {
            return;
        }

        $payment = Payments::cart($this->cart)->withData([
            'payment_intent_client_secret' => $this->payment_intent_client_secret,
            'payment_intent' => $this->payment_intent,
        ])->authorize();
        
        // CartSession::clear();

        if ($payment->success) {
            //Mail::to($this->cart->order->customer->email)->send(new CustomerNewOrderMail($this->cart->order));
            return redirect()->route('checkout-success.view');
        } 

        return redirect()->route('checkout-success.view');
    }

    /**
     * Return the available countries.
     */
    public function getCountriesProperty(): Collection
    {
        return Country::whereIn('iso3', ['GBR', 'ARE'])->get();
    }

    /**
     * Return available shipping options.
     */
    public function getShippingOptionsProperty(): Collection
    {
        return ShippingManifest::getOptions(
            $this->cart
        );
    }

    /**
     * Return the address validation rules for a given type.
     */
    protected function getAddressValidation(string $type): array
    {
        return [
            "{$type}.first_name" => 'required',
            "{$type}.last_name" => 'required',
            "{$type}.line_one" => 'required',
            "{$type}.country_id" => 'required',
            "{$type}.city" => 'required',
            "{$type}.postcode" => 'required',
            "{$type}.company_name" => 'nullable',
            "{$type}.line_two" => 'nullable',
            "{$type}.line_three" => 'nullable',
            "{$type}.state" => 'nullable',
            "{$type}.delivery_instructions" => 'nullable',
            "{$type}.contact_email" => 'required|email',
            "{$type}.contact_phone" => 'nullable',
        ];
    }

    /**
     * Save the shipping address.
     * This method is called when the user clicks the "Save Address" button.
     */
    public function saveShippingAddress(): void
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

        if ($customer) {
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

    }

    public function confirmPayment(): void
    {
        $this->currentStep = $this->steps['payment'] + 1;
    }

    public function verifyAuthenticationKey() 
    {
        $staff = Staff::get();

        foreach ($staff as $member) {
            if ($member->authentication_key == $this->clientPassword) {
                $this->authentication = true;
                $this->staffMemberFound = $member;
                break; 
            }
        }

        // Log::info($this->authentication);
        Log::info('member: ' . print_r($this->staffMemberFound, true));

        if ($this->authentication && $this->staffMemberFound) { 
            $this->cart->update([
                'meta' => array_merge((array) $this->cart->meta ?? [], [
                    'Authentication Key' => $this->staffMemberFound->authentication_key,
                    'Staff Member' => $this->staffMemberFound->first_name . ' ' . $this->staffMemberFound->last_name,
                    'Authenticated At' => now()->toISOString(),
                ])
            ]);

            //return true;
        } else {
            $this->addError('client-key-error', 'Authentication failed.');
            //return false;
        }

        Log::info('cart: ' . print_r($this->cart, true));
    }

    public function render(): View
    {
        return view('livewire.checkout-page');
    }
}



