<?php

namespace App\Modules\CurrencyConverter\Services;

use App\Modules\CurrencyConverter\Contracts\ConverterInterface;
use App\Modules\CurrencyConverter\Models\Currency;
//use App\Modules\CurrencyConverter\Models\ExchangeRate;
use Illuminate\Support\Facades\Cache;

class CurrencyConverterService implements ConverterInterface
{
    public function convert(float $amount, string $fromCurrency, string $toCurrency): float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        $rate = $this->getRate($fromCurrency, $toCurrency);

        return $amount * $rate;
    }

    public function getRate(string $fromCurrency, string $toCurrency): float
    {
        // Используем кэширование для частых запросов
        $cacheKey = "exchange_rate:{$fromCurrency}:{$toCurrency}:" . now()->toDateString();

        return Cache::remember($cacheKey, 3600, function () use ($fromCurrency, $toCurrency) {
            return $this->calculateRate($fromCurrency, $toCurrency);
        });
    }

    private function calculateRate(string $fromCurrency, string $toCurrency): float
    {
        $from   = Currency::query()->where('code', $fromCurrency)->firstOrFail();
        $to     = Currency::query()->where('code', $toCurrency)->firstOrFail();

        // Прямой курс
        $rate = ExchangeRate::where('base_currency_id', $from->id)
            ->where('target_currency_id', $to->id)
            ->where('date', now()->toDateString())
            ->first();

        if ($rate) {
            return (float) $rate->rate;
        }

        // Кросс-курс через USD
        $usd = Currency::where('code', 'USD')->firstOrFail();

        $fromToUsd = ExchangeRate::where('base_currency_id', $from->id)
            ->where('target_currency_id', $usd->id)
            ->where('date', now()->toDateString())
            ->first();

        $usdToTo = ExchangeRate::where('base_currency_id', $usd->id)
            ->where('target_currency_id', $to->id)
            ->where('date', now()->toDateString())
            ->first();

        if ($fromToUsd && $usdToTo) {
            return (float) $fromToUsd->rate * (float) $usdToTo->rate;
        }

        throw new \Exception("Exchange rate from {$fromCurrency} to {$toCurrency} not found");
    }
}
