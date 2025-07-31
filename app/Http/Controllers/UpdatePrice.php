<?php

namespace App\Http\Controllers;


use Lunar\Models\Price;
use Lunar\Models\Product;
use Illuminate\Http\Request;
use Lunar\Models\ProductVariant;

class UpdatePrice extends Controller
{
    
    public function update() { 
        ProductVariant::with(['prices', 'product'])
            ->chunk(200, function ($variants) {
                foreach ($variants as $variant) {
            
                    $outerBox = (int)($variant->product->attr('outer-box') ?? 1);
                    
                    $variant->prices->each(function ($price) use ($outerBox) {
                        // $updateData = [];
                
                        // if (!is_null($price->price)) {
                        //     $updateData['price'] = $price->price->value * $outerBox;
                        // }
                        
                        // if (!is_null($price->compare_price)) {
                        //     $updateData['compare_price'] = $price->compare_price->value * $outerBox;
                        // }
                        
                        // if (!empty($updateData)) {
                        //     $price->update($updateData);
                        // }
                        echo '<pre>';
                        print_r($price);
                        echo '</pre>';
                        print_r($outerBox);
                    });
                }
            });
    }
}
