<?php

namespace App\Http\Requests\Api\V1;

use App\Http\Requests\Api\FormRequest;

/**
 * Class UserRequest
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
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
                'name' => 'required',
                'email' => 'required|unique:users',
                'cpf_cnpj' => 'required|unique:users',
                'type' => 'required',
                'password' => 'required'
            ],
            'PUT', 'PATCH' => [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $this->email,
                'cpf_cnpj' => 'required|unique:users,cpf_cnpj,' . $this->cpf_cnpj,
                'type' => 'required',
                'password' => 'required'
            ],
            'GET', 'DELETE' => []
        };
    }
}
