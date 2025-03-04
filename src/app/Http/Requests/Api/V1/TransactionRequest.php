<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\TypeTransaction;
use App\Http\Requests\Api\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Class TransactionRequest
 * @package App\Http\Requests
 */
class TransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = $this->rules;

        $rules['wallet_payer_id'] = 'required|exists:wallets,id';
        $rules['amount'] = 'required|numeric|gt:0';
        $rules['type'] = ['required', Rule::enum(TypeTransaction::class)];

        if ($this->type === 'transfer') {
            $rules['wallet_payee_id'] = 'required|exists:wallets,id';
        }

        return $rules;
    }
}
