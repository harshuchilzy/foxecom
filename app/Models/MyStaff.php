<?php

namespace App\Models;

use Lunar\Admin\Models\Staff;
use Illuminate\Database\Eloquent\Model;

class MyStaff extends Staff
{
    protected $fillable = [
        'first_name',
        'last_name',
        'admin',
        'email',
        'password',
        'authentication_key'
    ];
}
