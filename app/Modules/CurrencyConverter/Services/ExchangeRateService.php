<?php

namespace App\Modules\CurrencyConverter\Services;

use App\Modules\CurrencyConverter\Models\Currency;
use Illuminate\Support\Carbon;
use Exception;
use Illuminate\Support\Facades\Log;

class ExchangeRateService
{
    private ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * @throws Exception
     */
    public function updateAllRates(): void
    {
        $currencies = Currency::query()
            ->select('currencies.code')
            ->where('active', true)
            ->pluck('code')
            ->toArray();

        /** @var array $rates */
        $rates = $this->apiService->getLatestRates(implode(',', $currencies));

        foreach ($rates as $currencyCode => $rate) {
            $this->updateRate($currencyCode, $rate);
        }

        Log::info('Exchange rates updated for date: ' . Carbon::now()->toDateTimeString());
    }

    public function updateRate(string $code, float  $rate): void
    {
        Currency::query()
            ->where('code', $code)
            ->update([
                'rate' => $rate,
            ]);
    }
}
