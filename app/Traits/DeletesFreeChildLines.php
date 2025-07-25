<?php

namespace App\Traits;

use Lunar\Facades\CartSession;
use Lunar\Models\Discount;

trait DeletesFreeChildLines
{
    protected function cleanupFreeChildren(): void
    {
        $cart = CartSession::current();

        foreach ($cart->lines as $line) {
            if (!data_get($line->meta, 'free', false)) {
                continue;
            }

            $meta = (array)$line->meta;
            $parentId = $meta['parent_line_id'] ?? null;
            $discountId = $meta['discount_id'] ?? null;

            if (!$parentId || !$discountId) {
                continue;
            }

            $parent = $cart->lines->firstWhere('id', $parentId);
            if (!$parent) {
                continue;
            }

            $priority = Discount::find($discountId)?->priority ?? 0;
            if ($parent->quantity < $priority) {
                CartSession::remove($line->id);
            }
        }
    }
}
