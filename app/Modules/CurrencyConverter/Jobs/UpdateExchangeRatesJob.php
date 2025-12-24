<?php

namespace App\Modules\CurrencyConverter\Jobs;

use App\Modules\CurrencyConverter\Services\ApiService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class UpdateExchangeRatesJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(ApiService $apiService): void
    {
        try {
            $apiService->updateAllRates();
            Log::info('Exchange rates updated successfully via job');
        } catch (\Exception $e) {
            Log::error('Failed to update exchange rates: ' . $e->getMessage());
            $this->fail($e);
        }
    }

    public function retryUntil()
    {
        return now()->addDay();
    }
}
