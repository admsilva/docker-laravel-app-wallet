<?php

namespace App\Models;

use App\Enums\StatusWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 * @package App\Models
 */
class Wallet extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'user_id',
        'balance',
        'status',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'balance' => 'integer',
        'status' => StatusWallet::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * @return HasOne
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return HasMany
     */
    public function transactionsPayer(): HasMany
    {
        return $this->hasMany(Transaction::class, 'wallet_payer_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function transactionsPayee(): HasMany
    {
        return $this->hasMany(Transaction::class, 'wallet_payee_id', 'id');
    }
}
