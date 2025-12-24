<?php

namespace App\Modules\CurrencyConverter\Console\Commands;

use App\Modules\CurrencyConverter\Jobs\UpdateExchangeRatesJob;
use Illuminate\Console\Command;

class UpdateExchangeRatesCommand extends Command
{
    protected $signature = 'currency:update-rates';

    protected $description = 'Update currency exchange rates from API';

    public function handle(): void
    {
        $this->info('Starting exchange rates update...');
        UpdateExchangeRatesJob::dispatch();
        $this->info('Exchange rates update job dispatched to queue.');
    }
}
