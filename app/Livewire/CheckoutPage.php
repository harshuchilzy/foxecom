<?php

namespace App\Livewire;

use Lunar\Models\Cart;
use Livewire\Component;
use Illuminate\View\View;
use Lunar\Models\Address;
use Lunar\Models\Country;
use Lunar\Facades\Payments;
use Lunar\Models\CartAddress;
use Lunar\Facades\CartSession;
use WireUi\Traits\WireUiActions;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Lunar\Facades\ShippingManifest;

class CheckoutPage extends Component
{
    use WireUiActions;
    
    /**
     * The Cart instance.
     */
    public ?Cart $cart;

    public $type = 'shipping';

    public $selectedShippingAddress;

    /**
     * The shipping address instance.
     */
    // public ?CartAddress $shipping = null;
    public $shipping = [];
    // public $shipping = [
    //     'first_name' => null,
    //     'last_name' => null,
    //     'company_name' => null,
    //     'contact_phone' => null,
    //     'contact_email' => null,
    //     'line_one' => null,
    //     'line_two' => null,
    //     'line_three' => null,
    //     'city' => null,
    //     'state' => null,
    //     'postcode' => null,
    //     'country_id' => null,
    //     'delivery_instructions' => null,
    // ];

    /**
     * The billing address instance.
     */
    // public ?CartAddress $billing = null;
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
     * The shipping address fields.
     */
    // public $countries;
    // public $shipping_company, $shipping_first_name, $shipping_last_name, $shipping_phone, $shipping_email;
    // public $shipping_streetno, $shipping_address, $shipping_city, $shipping_postcode, $shipping_state, $shipping_countries;
    // public $shippingAddressFields = false;

    /**
     * The checkout steps.
     */
    public array $steps = [
        'shipping_address' => 1,
        'shipping_option' => 2,
        'billing_address' => 3,
        'payment' => 4,
    ];

    /**
     * The payment type we want to use.
     */
    public string $paymentType = 'cash-in-hand';

    /**
     * {@inheritDoc}
     */
    protected $listeners = [
        'cartUpdated' => 'refreshCart',
        'selectedShippingOption' => 'refreshCart',
    ];

    public $payment_intent = null;

    public $payment_intent_client_secret = null;

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
        //Render the countries
        //$this->countries = Country::orderBy('name')->get();

        if (! $this->cart = CartSession::current()) {
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

        if(auth()->check()){
            $customer = auth()->user()->customers->first();
        }

        if(($this->shipping) && $customer){
            //$this->shipping = $customer->addresses->where('shipping_default', 0)->first()?->toArray();
            //$this->shipping = new CartAddress($this->shipping);

            $this->shipping = $customer->addresses->where('billing_default', 1)->first()?->toArray();
            
            //$this->shipping['country_id'] = 235;
            $this->cart->setShippingAddress($this->shipping);
            $this->shipping = new CartAddress($this->shipping);
        }

        $this->billing = $this->cart->billingAddress ?: new CartAddress;

        if(($this->billing) && $customer){
            //Log::info($customer->addresses->where('billing_default', 1)->first()?->toArray());
            $this->billing = $customer->addresses->where('billing_default', 1)->first()?->toArray();
            // $this->billing = array(
            //     'first_email' => 'Test'
            // );
            //$this->billing['country_id'] = 235;
            //Log::info($this->billing);
            $this->cart->setBillingAddress($this->billing);
            $this->billing = new CartAddress($this->billing);
            
        }
        //$this->determineCheckoutStep();

        // Log::info($this->shipping);
        //Log::info($this->shipping);
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
        $billingAddress = $this->cart->billingAddress;

        if ($shippingAddress) {
            if ($shippingAddress->id) {
                $this->currentStep = $this->steps['shipping_address'] + 1;
            }

            // Do we have a selected option?
            if ($this->shippingOption) {
                $this->chosenShipping = $this->shippingOption->getIdentifier();
                $this->currentStep = $this->steps['shipping_option'] + 1;
            } else {
                $this->currentStep = $this->steps['shipping_option'];
                $this->chosenShipping = $this->shippingOptions->first()?->getIdentifier();

                return;
            }
        }

        if ($billingAddress) {
            $this->currentStep = $this->steps['billing_address'] + 1;
        }
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

        if (! $shippingAddress) {
            return;
        }

        if ($option = $shippingAddress->shipping_option) {
            return ShippingManifest::getOptions($this->cart)->first(function ($opt) use ($option) {
                return $opt->getIdentifier() == $option;
            });
        }

        return null;
    }

    function updatedSelectedShippingAddress() : void {
        if(auth()->check()){
            $customer = auth()->user()->customers->first();
            $this->shipping = $customer->addresses->find($this->selectedShippingAddress)?->toArray();
            $this->cart->setShippingAddress($this->shipping);
            Log::info('Shipping address updated.');
            Log::info($this->shipping);
        }
    }

    /**
     * Save the address for a given type.
     */
    public function saveAddress(string $type): void
    {
        // $address = new CartAddress();
        // if ($type == 'shipping') {
        //     $this->cart->setShippingAddress($address);
        //     $this->shipping = $this->cart->shippingAddress;
        // }
        $this->shipping = $this->cart->shippingAddress ?: new CartAddress;

        Log::info($this->{$type});
        //Log::info("Address type being saved: " . $type);

        $validatedData = $this->validate(
            $this->getAddressValidation($type)
        );

        //Log::info($validatedData);

        $address = new CartAddress($this->{$type});

        if ($type == 'billing') {
            $this->cart->setBillingAddress($address);
            $this->billing = $this->cart->billingAddress;
        }

        if ($type == 'shipping') {
            $this->cart->setShippingAddress($address);
            $this->shipping = $this->cart->shippingAddress;

            if ($this->shippingIsBilling) {
                // Do we already have a billing address?
                if ($billing = $this->cart->billingAddress) {
                    $billing->fill($validatedData['shipping']);
                    $this->cart->setBillingAddress($billing);
                } else {
                    $address = $address->only(
                        $address->getFillable()
                    );
                    $this->cart->setBillingAddress($address);
                }

                $this->billing = $this->cart->billingAddress;
            }
        }

        //$this->determineCheckoutStep();
    }

    /**
     * Save the selected shipping option.
     */
    public function saveShippingOption(): void
    {
        $option = $this->shippingOptions->first(fn ($option) => $option->getIdentifier() == $this->chosenShipping);

        CartSession::setShippingOption($option);

        $this->refreshCart();

        //$this->determineCheckoutStep();
    }

    public function checkout()
    {
        // Log::info("Checkout initiated with payment type: " . $this->billing);
        // $payment = Payments::cart($this->cart)->withData([
        //     'payment_intent_client_secret' => $this->payment_intent_client_secret,
        //     'payment_intent' => $this->payment_intent,
        // ])->authorize();
        //Log::info("Billing data before checkout:", $this->billing);
    
    try {
        $payment = Payments::cart($this->cart)->withData([
            'payment_intent_client_secret' => $this->payment_intent_client_secret,
            'payment_intent' => $this->payment_intent,
        ])->authorize();
        
    } catch (\Exception $e) {
        Log::error("Checkout failed: " . $e->getMessage());
        throw $e;
    }


        if ($payment->success) {
            redirect()->route('checkout-success.view');

            return;
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
        Log::info("Address type on validation: " . $type);
        Log::info($this->shipping);
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

        if($customer) {
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

    public function render(): View
    {
        return view('livewire.checkout-page');
    }
}



