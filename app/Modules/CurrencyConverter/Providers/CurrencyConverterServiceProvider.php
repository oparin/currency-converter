<?php

namespace App\Modules\CurrencyConverter\Providers;

use App\Modules\CurrencyConverter\Contracts\ConverterInterface;
use App\Modules\CurrencyConverter\Services\ConverterService;
use Illuminate\Support\ServiceProvider;

class CurrencyConverterServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register services
        $this->app->singleton(ConverterInterface::class, ConverterService::class);
        $this->app->singleton('currency.converter', ConverterService::class);

        // Register commands
        $this->commands([
            \App\Modules\CurrencyConverter\Console\Commands\UpdateExchangeRatesCommand::class,
            \App\Modules\CurrencyConverter\Console\Commands\TestCommand::class,
        ]);
    }

    public function boot(): void
    {
        // Publish config and migrations
        $this->publishes(
            [
                __DIR__ . '/../Config/currency-converter.php' => config_path('currency-converter.php'),
                __DIR__ . '/../Database/Migrations/'          => database_path('migrations'),
            ], 'currency-converter-files');

        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../Routes/web.php');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'currency-converter');

        // Load lang
        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'currency-converter');
    }
}
