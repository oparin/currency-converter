<?php

namespace App\Modules\CurrencyConverter\Services;

use App\Modules\CurrencyConverter\Contracts\ConverterInterface;
use App\Modules\CurrencyConverter\Models\Currency;
use Exception;

class ConverterService implements ConverterInterface
{
    /**
     * @param float $amount
     * @param string $fromCurrency
     * @param string $toCurrency
     * @return float
     * @throws Exception
     */
    public function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        try {
            $from = Currency::query()->where('code', $fromCurrency)->firstOrFail();
            $to   = Currency::query()->where('code', $toCurrency)->firstOrFail();
        } catch (Exception $e) {
            throw new Exception("Exchange rate from {$fromCurrency} to {$toCurrency} not found");
        }

        return $amount / $from->rate * $to->rate;
    }

    public function getRate(string $fromCurrency, string $toCurrency): float
    {
        $from = Currency::query()
            ->where('code', $fromCurrency)
            ->first();

        $to = Currency::query()
            ->where('code', $toCurrency)
            ->first();

        if ($from && $to) {
            return $to->rate / $from->rate;
        }

        throw new \Exception("Exchange rate from {$fromCurrency} to {$toCurrency} not found");
    }
}
