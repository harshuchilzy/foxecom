<?php

namespace App\Scout;

use Laravel\Scout\Searchable;
use Lunar\Models\Product;

class LunarSearchProduct extends Product
{
    use Searchable;

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->translateAttribute('name'),
            'description' => $this->translateAttribute('description'),
        ];
    }
}
