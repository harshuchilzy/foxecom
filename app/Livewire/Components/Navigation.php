<?php

namespace App\Livewire\Components;

use Illuminate\View\View;
use Livewire\Component;
use Lunar\Models\Collection;

class Navigation extends Component
{
    public $billingAddress;

    public function mount(){

        $user = auth()->user();

        if ( !empty($user) ) {
            $customer = $user->customers->first();
        }
        
        if (!empty($customer)) {

            $this->billingAddress = \Lunar\Models\Address::where('customer_id', $customer->id)
                ->whereNotNull('line_two')
                ->where('line_two', '!=', '')
                ->latest()
                ->first();

        }    

    }
    /**
     * The search term for the search input.
     *
     * @var string
     */
    public $term = null;

    /**
     * {@inheritDoc}
     */
    protected $queryString = [
        'term',
    ];

    /**
     * Return the collections in a tree.
     */
    public function getCollectionsProperty()
    {
        return Collection::with(['defaultUrl'])->get()->toTree();
    }

    public function render(): View
    {
        return view('livewire.components.navigation');
    }
}
