<?php

namespace App\Livewire;

use Livewire\Component;
use Lunar\Models\Order;
use Lunar\Models\Product;
use Lunar\Models\OrderLine;
use Livewire\WithPagination;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Facades\Auth;
use Nette\Utils\Random;

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

    public function getRandomOrderItems()
    {
        $customerId = Auth::id();

        if (!empty($customerId)) {

            $orders = Order::with(['lines'])
                ->where('user_id', $customerId)
                ->get();

            $product_ids = [];

            if(!empty($orders)) {
                foreach ($orders as $order) {
                    if(!empty($order)) {
                        foreach ($order->lines as $line) {
                            if ($line->purchasable_id) {
                                $product_ids[] = $line->purchasable_id;
                            }
                        }
                    }
                }
            }

            // Remove duplicates just in case
            $product_ids = array_unique($product_ids);
        }
        
        if (!empty($product_ids)) {

            return Product::with([
                'variants.prices', 
                'thumbnail', 
                'defaultUrl',
            ])
            ->whereIn('id', $product_ids)
            ->inRandomOrder()
            ->limit(3)
            ->get();

        } else {

            return Product::with([
                'variants.prices',
                'thumbnail',
                'defaultUrl',
            ])
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        }
        
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