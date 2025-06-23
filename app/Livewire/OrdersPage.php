<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Order;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Lunar\Models\ProductVariant;

class OrdersPage extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';

    public $orderCount;
    public $totalRevenue;

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function render()
    {
        // Get the authenticated user's customer ID
        $customerId = Auth::user()->id;
        
        $orders = Order::with(['lines', 'customer'])
                    ->where('user_id', $customerId) // Use user_id instead of user_id
                    ->orderBy($this->sortField, $this->sortDirection)
                    ->paginate($this->perPage);

        $this->orderCount = Order::where('user_id', $customerId)->count();
        $this->totalRevenue = Order::where('user_id', $customerId)
                          ->where('status', '!=', 'cancelled')
                          ->sum('total');

        // dd($orders);
        return view('livewire.orders-page', [
            'orders' => $orders
        ]);
    }
}