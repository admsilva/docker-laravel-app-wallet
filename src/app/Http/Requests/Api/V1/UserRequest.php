<?php

namespace App\Http\Requests\Api\V1;

use App\Enums\StatusUser;
use App\Enums\TypeUser;
use App\Http\Requests\Api\FormRequest;
use Illuminate\Validation\Rule;

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
                'type' => ['required', Rule::enum(TypeUser::class)],
                'password' => 'required',
            ],
            'PUT', 'PATCH' => [
                'name' => 'required',
                'email' => 'required|unique:users,email,' . $this->email . ',email',
                'cpf_cnpj' => 'required|unique:users,cpf_cnpj,' . $this->cpf_cnpj . ',cpf_cnpj',
                'type' => ['required', Rule::enum(TypeUser::class)],
                'status' => ['required', Rule::enum(StatusUser::class)],
                'password' => 'required',
            ],
            'GET', 'DELETE' => []
        };
    }
}
