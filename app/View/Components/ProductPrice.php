<?php

namespace App\View\Components;

use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\View;
use Lunar\Facades\Pricing;
use Lunar\Models\Price;
use Lunar\Models\ProductVariant;

class ProductPrice extends Component
{
    public ?Price $price = null;

    public ?ProductVariant $variant = null;

    public $priceAmount = 0;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($product = null, $variant = null)
    {
            $this->price = Pricing::for(
                $variant ?: $product->variants->first()
            )->get()->matched;

            if($this->price->compare_price->value > 0 && !isset($this->price->updated)){
                $this->price->compare_price->value = ($this->price->compare_price->value / $variant->product->attr('outer-box'));
                $this->price->price->value = ($this->price->price->value / $variant->product->attr('outer-box'));
                $this->price->updated = true;
            }if(!isset($this->price->updated)){
                $this->price->updated = true;
                $this->price->price->value = ($this->price->price->value / $variant->product->attr('outer-box'));
            }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.product-price');
    }
}
