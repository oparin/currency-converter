<?php

namespace App\Modules\CurrencyConverter\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static float convert(float $amount, string $fromCurrency, string $toCurrency)
 * @see \App\Modules\CurrencyConverter\Services\ConverterService
 */
class CurrencyConverter extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'currency.converter';
    }
}
