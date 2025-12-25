<?php

namespace App\Modules\CurrencyConverter\Http\Controllers;

use App\Modules\CurrencyConverter\Facades\CurrencyConverter;
use App\Modules\CurrencyConverter\Http\Requests\ConvertRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Modules\CurrencyConverter\Models\Currency;

class ConverterController extends Controller
{
    /**
     * @param ConvertRequest $request
     * @return JsonResponse
     */
    public function convert(ConvertRequest $request): JsonResponse
    {
        try {
            $amount       = (float)$request->amount;
            $fromCurrency = strtoupper($request->from);
            $toCurrency   = strtoupper($request->to);

            $from = Currency::query()
                ->where('code', $fromCurrency)
                ->where('active', true)
                ->first();
            if (!$from) {
                return response()->json([
                    'success' => false,
                    'message' => "Source currency '{$fromCurrency}' is not available or not supported",
                ], 400);
            }

            $to = Currency::query()
                ->where('code', $toCurrency)
                ->where('active', true)
                ->first();
            if (!$to) {
                return response()->json([
                    'success' => false,
                    'message' => "Target currency '{$toCurrency}' is not available or not supported",
                ], 400);
            }

            $rate   = CurrencyConverter::getRate($fromCurrency, $toCurrency);
            $result = CurrencyConverter::convert($amount, $fromCurrency, $toCurrency);

            return response()->json([
                'success'      => true,
                'amount'       => $amount,
                'from'         => $fromCurrency,
                'from_name'    => $from->name,
                'to'           => $toCurrency,
                'to_name'      => $to->name,
                'result'       => $result,
                'rate'         => $rate,
                'inverse_rate' => $rate > 0 ? 1 / $rate : 0,
                'message'      => 'Conversion successful',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Currency conversion failed: ' . $e->getMessage(), [
                'amount'    => $request->amount,
                'from'      => $request->from,
                'to'        => $request->to,
                'exception' => $e,
            ]);

            return response()->json([
                'success'    => false,
                'message'    => 'Conversion failed: ' . $e->getMessage(),
                'error_type' => get_class($e),
            ], 500);
        }
    }
}
