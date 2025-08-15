<?php

namespace App\Livewire;

use Lunar\Models\Cart;
use Livewire\Component;
use Lunar\Models\Order;
use Illuminate\View\View;
use Lunar\Facades\CartSession;
use Illuminate\Support\Facades\Log;

class CheckoutSuccessPage extends Component
{
    public ?Cart $cart;

    public Order $order;

    public function mount(): void
    {
        $this->cart = CartSession::current();

        $previousCartId = $this->cart->id - 1;
        $newCart = Cart::find($previousCartId);
  
        if (! $newCart || ! $newCart->completedOrder) {
            $this->redirect('/');
            return;
        }
       
        $this->order = $newCart->completedOrder;
       
        CartSession::forget();
    }

    public function render(): View
    {
        return view('livewire.checkout-success-page');
    }
}
