<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserResource
 * @package App\Http\Resources
 */
class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        $user_wallet = null;

        if ($this->wallet) {
            $user_wallet = [
                "wallet_id" => $this->wallet->id,
                "user_id" => $this->wallet->user_id,
                "balance" => $this->wallet->balance,
                "status" => $this->wallet->status,
            ];
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'cpf_cnpj' => $this->cpf_cnpj,
            'type' => $this->type,
            'status' => $this->status,
            'wallet' => $user_wallet,
        ];
    }
}
