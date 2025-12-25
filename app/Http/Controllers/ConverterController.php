<?php

namespace App\Http\Controllers;

use App\Modules\CurrencyConverter\Models\Currency;

class ConverterController extends Controller
{
    public function index()
    {
        $currencies = Currency::query()
            ->where('currencies.active', true)
            ->get();

        return view('converter.index', [
            'currencies' => $currencies
        ]);
    }
}
