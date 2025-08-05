<?php

namespace App\Filament\PipeLines\Cart;

use Closure;
use Lunar\DiscountTypes\BuyXGetY;
use Lunar\Facades\DB;
use Lunar\Models\Cart;
use Lunar\Models\CartLine;
use Lunar\DataTypes\Price;

class BuyXGetYDiscountItems
{
    public function handle(Cart $cart, Closure $next): Cart
    {
        $cart->loadMissing(['currency', 'lines']);

        if (!$cart->currency) {
            return $next($cart);
        }

        // Original discount logic remains unchanged
        $buyXGetY = $cart->discountBreakdown
            ->where('discount.type', BuyXGetY::class);

        if ($buyXGetY->isEmpty()) {
            foreach ($cart->lines->where(fn ($L) => ($L->meta['free'] ?? false)) as $fl) {
                $fl->delete();
            }
            return $next($cart);
        }

        $paidLines = collect();
        $freeLines = collect();
        foreach ($cart->lines as $line) {
            $vid = $line->purchasable_id;
            if (!empty($line->meta['free']) && isset($line->meta['discount_id'])) {
                $freeLines[$vid] = $line;
            } else {
                $paidLines[$vid] = $line;
            }
        }

        $keepFreeLines = collect();

        foreach ($buyXGetY as $breakdown) {
            $discount = $breakdown->discount;
            $data = $discount->data;
            $minQty = (int)data_get($data, 'min_qty', 10);
            $rewQty = (int)data_get($data, 'reward_qty', 2);
            $maxUses = max(1, $discount->max_uses_per_user);
            $userId = auth()->id();

            $historic = DB::table('lunar_discount_user')
                ->where('user_id', $userId)
                ->where('discount_id', $discount->id)
                ->count();

            if ($historic >= $maxUses) {
                foreach ($freeLines as $vid => $fl) {
                    if (($fl->meta['discount_id'] ?? null) === $discount->id) {
                        $fl->delete();
                        $freeLines->forget($vid);
                    }
                }
                continue;
            }

            $eligibleVariants = collect();
            foreach ($breakdown->lines as $breakdownLine) {
                if ($breakdownLine->line) {
                    $eligibleVariants->push($breakdownLine->line->purchasable_id);
                }
            }

            foreach ($eligibleVariants as $vid) {
                if (!$paidLines->has($vid)) {
                    continue;
                }

                $paid = $paidLines[$vid];
                $totalGroups = intdiv($paid->quantity, $minQty);

                if ($totalGroups <= 0) {
                    if ($freeLines->has($vid) && ($freeLines[$vid]->meta['discount_id'] ?? null) === $discount->id) {
                        $freeLines[$vid]->delete();
                        $freeLines->forget($vid);
                    }
                    continue;
                }

                $allowedGroups = min($totalGroups, $maxUses - $historic);

                if ($allowedGroups <= 0) {
                    if ($freeLines->has($vid) && ($freeLines[$vid]->meta['discount_id'] ?? null) === $discount->id) {
                        $keepFreeLines->push($vid);
                    }
                    continue;
                }

                $freeQty = $allowedGroups * $rewQty;

                if ($freeLines->has($vid) && ($freeLines[$vid]->meta['discount_id'] ?? null) === $discount->id) {
                    $free = $freeLines[$vid];
                    $free->quantity = $freeQty;

                    $zeroPrice = new Price(0, $cart->currency, $cart->currency->factor);
                    $free->unitPrice = $zeroPrice;
                    $free->subTotal = $zeroPrice;
                    $free->discountTotal = $zeroPrice;
                    $free->total = $zeroPrice;

                    $free->save();
                    $keepFreeLines->push($vid);
                } else {
                    if ($freeLines->has($vid)) {
                        $freeLines[$vid]->delete();
                        $freeLines->forget($vid);
                    }

                    $zeroPrice = new Price(0, $cart->currency, $cart->currency->factor);

                    $free = CartLine::create([
                        'cart_id' => $cart->id,
                        'purchasable_type' => $paid->purchasable_type,
                        'purchasable_id' => $vid,
                        'quantity' => $freeQty,
                        'meta' => [
                            'free' => true,
                            'discount_id' => $discount->id,
                            'parent_line_id' => $paid->id,
                        ],
                    ]);

                    $free->unitPrice = $zeroPrice;
                    $free->subTotal = $zeroPrice;
                    $free->discountTotal = $zeroPrice;
                    $free->total = $zeroPrice;

                    $free->save();
                    $freeLines[$vid] = $free;
                    $keepFreeLines->push($vid);
                }
            }
        }

        return $next($cart);
    }
}
