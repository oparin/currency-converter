<?php

namespace App\Modules\CurrencyConverter\Database\Seeders;

use App\Modules\CurrencyConverter\Models\Currency as CurrencyModel;
use App\Modules\CurrencyConverter\Enums\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Currency::cases() as $currency) {
            CurrencyModel::create(
                [
                    'code'      => $currency->value,
                    'name'      => $currency->label(),
                    'active'    => true,
                ]
            );
        }
    }
}
