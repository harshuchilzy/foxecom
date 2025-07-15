<?php

namespace App\Filament\PipeLines\Cart;

use Closure;
use Lunar\DiscountTypes\BuyXGetY;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Lunar\DataTypes\Price;

class BuyXGetYDiscountItems
{
    public function handle(Cart $cart, Closure $next): Cart
    {
        // Ensure currency and lines are loaded
        $cart->loadMissing(['currency', 'lines']);
        if (!$cart->currency) {
            // Pass the cart on without further Buy‑X‑Get‑Y logic
            return $next($cart);
        }

        // Get only the Buy‑X‑Get‑Y discount items on this cart
        $buyXGetYItems = $cart
            ->discountBreakdown
            ->where('discount.type', BuyXGetY::class);

        // If there are no such discounts, delete any leftover free lines and move on
        if ($buyXGetYItems->isEmpty()) {
            // Find and remove every line marked as free
            foreach ($cart->lines->where(fn ($line) => !empty($line->meta['free'])) as $freeLine) {
                $freeLine->delete();
            }
            // Pass the cart on without further Buy‑X‑Get‑Y logic
            return $next($cart);
        }

        // Prepare two maps: one for items the customer pays for, one for items marked as free
        $paidLines = collect(); // variant_id => CartLine for paid items
        $freeLines = collect(); // variant_id => CartLine for free items

        // Loop through every line in the cart and sort it into the correct map
        foreach ($cart->lines as $line) {
            $variantId = $line->purchasable_id;
            if (!empty($line->meta['free'])) {
                // This line is a free gift from a previous discount step
                $freeLines[$variantId] = $line;
            } else {
                // This line is a normal, paid item
                $paidLines[$variantId] = $line;
            }
        }

        // Prepare rule set: variant_id => [min, rew]
        $rules = collect();
        foreach ($buyXGetYItems as $breakdown) {
            $data = $breakdown->discount->data;
            $min = (int)data_get($data, 'min_qty', 1);
            $rew = (int)data_get($data, 'reward_qty', 1);
            foreach ($breakdown->lines as $breakdownLine) {
                if (!$breakdownLine->line) continue;
                $rules[$breakdownLine->line->purchasable_id] = compact('min', 'rew');
            }
        }

        // Keep track of variant IDs that still need free items
        $variantsWithFreeItems = collect();

        // Process each item the customer is paying for
        foreach ($paidLines as $variantId => $paidLine) {
            //  If no discount rule applies, remove any free item and skip
            if (!isset($rules[$variantId])) {
                if ($freeLines->has($variantId)) {
                    $freeLines[$variantId]->delete();
                }
                continue;
            }
            // Read our “buy X, get Y” numbers
            [$minQty, $rewardQty] = [$rules[$variantId]['min'], $rules[$variantId]['rew']];

            // How many full “X” groups did the customer buy?
            $groups = intdiv($paidLine->quantity, $minQty);
            $totalFree = $groups * $rewardQty;

            // If no free items are owed, delete any existing free line
            if ($totalFree <= 0) {
                if ($freeLines->has($variantId)) {
                    $freeLines[$variantId]->delete();
                }
                continue;
            }

            // Otherwise, update or create the free line at zero price
            if ($freeLines->has($variantId)) {
                $free = $freeLines[$variantId];
                $free->quantity = $totalFree;
                $free->unitPrice = new Price(0, $cart->currency, $cart->currency->factor);
                $free->save();
            } else {
                $free = CartLine::create([
                    'cart_id' => $cart->id,
                    'purchasable_type' => $paidLine->purchasable_type,
                    'purchasable_id' => $variantId,
                    'quantity' => $totalFree,
                    'meta' => [
                        'free' => true,
                        'parent_line_id' => $paidLine->id,
                    ],
                ]);
                $free->unitPrice = new Price(0, $cart->currency, $cart->currency->factor);
                $free->save();
                $freeLines[$variantId] = $free;
            }

            // Mark this variant as still needing a free line
            $variantsWithFreeItems->push($variantId);
        }

        // Delete free lines not in keepFree
        foreach ($freeLines as $variantId => $free) {
            if (!$variantsWithFreeItems->contains($variantId)) {
                $free->delete();
            }
        }

        // Capture IDs of paid lines to detect deletions
        $paidLineIds = $paidLines->pluck('id')->all();

        // Additionally, delete child free lines when parent line removed
        foreach ($freeLines as $free) {
            $parentId = data_get($free->meta, 'parent_line_id');
            if (!in_array($parentId, $paidLineIds)) {
                $free->delete();
            }
        }

        return $next($cart);
    }
}
