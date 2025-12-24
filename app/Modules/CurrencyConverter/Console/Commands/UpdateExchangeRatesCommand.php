<?php

namespace App\Modules\CurrencyConverter\Console\Commands;

use App\Modules\CurrencyConverter\Jobs\UpdateExchangeRatesJob;
use App\Modules\CurrencyConverter\Services\ExchangeRateService;
use Exception;
use Illuminate\Console\Command;

class UpdateExchangeRatesCommand extends Command
{
    protected $signature = 'currency:update-rates';

    protected $description = 'Update currency exchange rates from API';

    /**
     * @throws Exception
     */
    public function handle(ExchangeRateService $rateService): void
    {
        $this->info('Starting exchange rates update...');
        UpdateExchangeRatesJob::dispatch();
        $this->info('Exchange rates update job dispatched to queue.');
    }
}
