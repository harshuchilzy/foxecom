<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Order;
use Lunar\Models\Product;
use Lunar\Models\OrderLine;
use Livewire\WithPagination;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;

class OrdersPage extends Component
{
    use WithPagination;

    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $timeFilter = 'all';

    public $orderCount;
    public $totalRevenue;

    public function updatedTimeFilter()
    {
        $this->resetPage(); 
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortField = $field;
    }

    public function getOrderItems($product_id)
    {
        return Product::with([
            'variants.prices', 
            'thumbnail', 
            'defaultUrl',
        ])
        ->where('id', $product_id)
        ->first();
    }
    public function render()
    {
        $customerId = Auth::user()->id;
        
        $query = Order::with(['lines', 'customer'])
            ->where('user_id', $customerId);
        
        switch ($this->timeFilter) {
            case 'past-three-months':
                $query->where('created_at', '>=', now()->subMonths(3));
                break;
            case 'past-two-months':
                $query->where('created_at', '>=', now()->subMonths(2));
                break;
            case 'past-month':
                $query->where('created_at', '>=', now()->subMonth());
                break;
        }
        
        $orders = $query->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage);

        $this->orderCount = $query->count();
        $this->totalRevenue = $query->clone()
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        return view('livewire.orders-page', [
            'orders' => $orders,
        ]);
    }
}