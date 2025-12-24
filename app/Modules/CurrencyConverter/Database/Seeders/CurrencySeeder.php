<?php

namespace App\Modules\CurrencyConverter\Database\Seeders;

use App\Modules\CurrencyConverter\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /** @var array $defaultCurrencies */
        $defaultCurrencies = config('currency-converter.default_currencies');

        foreach ($defaultCurrencies as $code => $label) {
            Currency::create(
                [
                    'code'      => $code,
                    'name'      => $label,
                    'active'    => true,
                ]
            );
        }
    }
}
