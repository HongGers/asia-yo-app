<?php

namespace App\Http\Requests;

use App\Rules\ContainNonEnglishCharRule;
use App\Rules\NotCaptalizeRule;
use App\Rules\PriceOverLimitRule;
use App\Rules\WrongCurrencyFormatRule;
use Illuminate\Contracts\Validation\Validator as ValidationValidator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string',
            'name' => ['required', 'string', new ContainNonEnglishCharRule(), new NotCaptalizeRule()],
            'address' => 'required|array',
            'address.city' => 'required|string',
            'address.district' => 'required|string',
            'address.street' => 'required|string',
            'price' => ['required', 'numeric', 'min:0', new PriceOverLimitRule(2000)],
            'currency' => ['required', 'string', new WrongCurrencyFormatRule()]
        ];
    }

    /**
     * Handle a failed validation attempt.
     */
    protected function failedValidation(ValidationValidator $validator)
    {
        $errors = $validator->errors();
        $response = response()->json($errors->messages(), 400);

        throw new HttpResponseException($response);
    }
}
