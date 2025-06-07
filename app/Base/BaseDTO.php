<?php

namespace App\Base;
use Illuminate\Support\Arr;


class BaseDTO
{
    private const UNDEFINED = 'undefined';
    private const UNDEFINED_NUMBER = NAN;
    public function toArray(): array
    {
        return array_filter(
            (array)$this,
            fn($item) => ($item !== self::UNDEFINED && $item !== self::UNDEFINED_NUMBER)
        );
    }
}
