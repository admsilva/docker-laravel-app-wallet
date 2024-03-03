<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class TransactionResource
 * @package App\Http\Resources
 */
class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        if ($this["deposits"] ||
            $this["withdraws"] ||
            $this["transfers"]
        ) {
            $deposits = [];
            $withdraws = [];
            $transfers = [];

            foreach ($this["deposits"] as $deposit) {
                $deposits[] = [
                    'id' => $deposit->id,
                    'wallet_payer_id' => $deposit->wallet_payer_id,
                    'amount' => $deposit->amount,
                    'description' => $deposit->description,
                    'type' => $deposit->type,
                    'status' => $deposit->status,
                    'notify' => $deposit->notify,
                ];
            }

            foreach ($this["withdraws"] as $withdraw) {
                $withdraws[] = [
                    'id' => $withdraw->id,
                    'wallet_payer_id' => $withdraw->wallet_payer_id,
                    'amount' => $withdraw->amount,
                    'description' => $withdraw->description,
                    'type' => $withdraw->type,
                    'status' => $withdraw->status,
                    'notify' => $withdraw->notify,
                ];
            }

            foreach ($this["transfers"] as $transfer) {
                $transfers[] = [
                    'id' => $transfer->id,
                    'wallet_payer_id' => $transfer->wallet_payer_id,
                    'wallet_payee_id' => $transfer->wallet_payee_id,
                    'amount' => $transfer->amount,
                    'description' => $transfer->description,
                    'type' => $transfer->type,
                    'status' => $transfer->status,
                    'notify' => $transfer->notify,
                ];
            }

            return [
                'deposits' => $deposits,
                'withdraws' => $withdraws,
                'transfers' => $transfers,
            ];
        }

        $transfer = [
            'id' => $this->id,
            'wallet_payer_id' => $this->wallet_payer_id,
            'wallet_payee_id' => $this->wallet_payee_id,
            'amount' => $this->amount,
            'description' => $this->description,
            'type' => $this->type,
            'status' => $this->status,
            'notify' => $this->notify,
        ];

        if ($this->type !== 'transfer') {
            $transfer = [
                'id' => $this->id,
                'wallet_payer_id' => $this->wallet_payer_id,
                'amount' => $this->amount,
                'description' => $this->description,
                'type' => $this->type,
                'status' => $this->status,
                'notify' => $this->notify,
            ];
        }

        return $transfer;
    }
}
