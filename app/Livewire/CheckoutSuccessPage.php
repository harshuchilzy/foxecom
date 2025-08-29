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
        $previousCart = null;

        if (auth()->check()) {
            if(auth()->user()->customers) {
                $customer = auth()->user()->customers->first();
            }
        }

        if( !$customer->orders->last() ) {
            $this->redirect('/');
            return;
        }
       
        // $this->order = $secondRecentCart->completedOrder;
        $this->order = $customer->orders->last();
       
        CartSession::forget();
    }

    public function render(): View
    {
        return view('livewire.checkout-success-page');
    }
}
