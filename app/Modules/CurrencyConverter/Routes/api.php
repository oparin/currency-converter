<?php

use Illuminate\Support\Facades\Route;
use App\Modules\CurrencyConverter\Http\Controllers\ConverterController;

Route::post('/api/converter/convert', [ConverterController::class, 'convert']);
