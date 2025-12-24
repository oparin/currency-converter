<?php

namespace Database\Seeders;

use App\Enums\Currency;
use App\Models\Currency as CurrencyModel;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Currency::cases() as $currency) {
            CurrencyModel::Create(
                [
                    'code'      => $currency->value,
                    'name'      => $currency->label(),
                    'active' => true,
                ]
            );
        }
    }
}
