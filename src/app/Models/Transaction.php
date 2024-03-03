<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 * @package App\Models
 */
class Transaction extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'wallet_payer_id',
        'wallet_payee_id',
        'amount',
        'description',
        'type',
        'status',
        'notify',
    ];

    /**
     * @return BelongsTo
     */
    public function walletPayer(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_payer_id', 'id');
    }

    /**
     * @return BelongsTo
     */
    public function walletPayee(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_payee_id', 'id');
    }
}
