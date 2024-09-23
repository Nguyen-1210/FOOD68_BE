<?php

namespace App\Http\Helpers;

use Illuminate\Support\Number;

class FormatHelper
{
    function formatPrice($state)
    {
        return Number::currency($state, in: 'VND', locale: 'vi-VN');
    }
}