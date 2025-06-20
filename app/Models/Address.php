<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Lunar\Models\Address as ModelsAddress;

class Address extends ModelsAddress
{
    protected function formatAddress(){
        return Attribute::make(
            get: fn (string $value) => 'Test'
        );
    }
}
