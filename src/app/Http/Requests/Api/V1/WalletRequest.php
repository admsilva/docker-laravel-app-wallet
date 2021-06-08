<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\FormRequest;

/**
 * Class WalletRequest
 * @package App\Http\Requests
 */
class WalletRequest extends FormRequest
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
        return match ($this->method()) {
            'POST' => [
                'user_id' => 'required|unique:wallets',
                'balance' => 'required',
            ],
            'PUT', 'PATCH' => [
                'user_id' => 'required|unique:wallets,user_id,' . $this->user_id,
                'balance' => 'required',
            ],
            'GET', 'DELETE' => []
        };
    }
}
