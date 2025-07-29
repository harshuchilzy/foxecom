<?php

namespace App\Livewire;

use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;
use Lunar\Models\Order;
use Nette\Utils\Random;
use Lunar\Models\Product;
use Lunar\Models\OrderLine;
use Livewire\WithPagination;
use Lunar\Models\ProductVariant;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

        $productsWithDates = [];

        if (!empty($customerId)) {
            $orders = Order::with(['lines']) 
                ->where('user_id', $customerId)
                ->get();

            foreach ($orders as $order) {
                foreach ($order->lines as $line) {
                    if ($line->type === 'physical' && $line->purchasable && $line->purchasable->product) {
                        $productsWithDates[] = [
                            'product' => $line->purchasable->product,
                            'line' => $line,
                            'order_created_at' => $order->created_at,
                        ];
                    }
                }
            }
        }

        $productsWithDates = collect($productsWithDates)
            ->unique(fn($item) => $item['product']->id)
            ->shuffle()
            ->take(3)
            ->values();

        if ($productsWithDates->isEmpty()) {
            return Product::with(['variants.prices', 'thumbnail', 'defaultUrl'])
                ->inRandomOrder()
                ->limit(3)
                ->get()
                ->map(fn($product) => [
                    'product' => $product,
                    'line' => '',
                    'order_created_at' => null,
                ]);
        }

        return $productsWithDates;
    }


    public function render()
    {
        $customerId = Auth::user()->id;
        
        $query = Order::with(['lines', 'customer'])
            ->where('user_id', $customerId);
        
        switch ($this->timeFilter) {
            case 'past-three-months':
                $query->whereBetween('created_at', [
                    now()->subMonths(3)->startOfDay(), 
                    now()->endOfDay()
                ]);
                break;
            case 'past-two-months':
                $query->whereBetween('created_at', [
                    now()->subMonths(2)->startOfDay(),
                    now()->endOfDay()
                ]);
                break;
            case 'past-month':
                $query->whereBetween('created_at', [
                    now()->subMonth()->startOfMonth(),
                    now()->subMonth()->endOfMonth()
                ]);
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

    function downloadInvoice($order_id) : bool | StreamedResponse {
        if(empty($order_id)){
            return false;
        }

        $record = Order::find($order_id);
        
        return response()->streamDownload(function () use ($record) {
            echo Pdf::loadView('lunarpanel::pdf.order', [
                'record' => $record,
            ])->stream();
        }, name: "Order-{$record->reference}.pdf");
    }
}