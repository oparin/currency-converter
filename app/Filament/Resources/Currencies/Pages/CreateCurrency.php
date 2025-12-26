<?php

namespace App\Filament\Resources\Currencies\Pages;

use App\Filament\Resources\Currencies\CurrencyResource;
use App\Modules\CurrencyConverter\Services\ApiService;
use App\Modules\CurrencyConverter\Services\ExchangeRateService;
use Filament\Resources\Pages\CreateRecord;

class CreateCurrency extends CreateRecord
{
    protected ExchangeRateService $rateService;
    protected ApiService          $apiService;

    public function __construct()
    {
        $this->rateService = app(ExchangeRateService::class);
        $this->apiService  = app(ApiService::class);
    }

    protected static string $resource = CurrencyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $code         = strtoupper($data['code']);
        $data['code'] = $code;

        $currency = $this->apiService->getAvailableCurrencies($code);
        if (isset($currency[$code])) {
            $data['name']   = $currency[$code]['name'];
            $data['symbol'] = $currency[$code]['symbol'];
        }

        return $data;
    }

    /**
     * @throws \Exception
     */
    protected function afterCreate(): void
    {
        $this->rateService->updateAllRates();
    }
}
