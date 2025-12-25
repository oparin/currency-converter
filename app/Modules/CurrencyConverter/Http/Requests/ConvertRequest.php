<?php

namespace App\Modules\CurrencyConverter\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class ConvertRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'amount' => [
                'required',
                'numeric',
            ],
            'from'   => [
                'required',
                'string',
                'size:3',
            ],
            'to'     => [
                'required',
                'string',
                'size:3',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'amount.required' => 'Amount is required',
            'amount.numeric'  => 'Amount must be a number',
            'from.required'   => 'Source currency is required',
            'from.size'       => 'Currency code must be 3 characters',
            'to.required'     => 'Target currency is required',
            'to.size'         => 'Currency code must be 3 characters',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            response()->json([
                'success' => false,
                'errors'  => $validator->errors()->all(),
                'message' => 'Validation failed',
            ], 422)
        );
    }
}
