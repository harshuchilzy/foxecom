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
                $customerId = auth()->user()->customers->first()->id;
                $newCart = Cart::where('customer_id', $customerId)
                            ->orderBy('id', 'desc')
                            ->first();
            }
            // Get previous cart (one before the newest)
            
            if ($newCart) {
                $previousCart = Cart::where('id', '<', $newCart->id)
                                ->when(auth()->user()->customers, function($query) use ($customerId) {
                                    return $query->where('customer_id', $customerId);
                                })
                                ->orderBy('id', 'desc')
                                ->first();
            }
        }

        if (! $previousCart || ! $previousCart->completedOrder) {
            $this->redirect('/');
            return;
        }
       
        $this->order = $previousCart->completedOrder;
       
        CartSession::forget();
    }

    public function render(): View
    {
        return view('livewire.checkout-success-page');
    }
}
