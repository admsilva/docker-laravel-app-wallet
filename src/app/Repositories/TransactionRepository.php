<?php


namespace App\Repositories;


use App\Models\Transaction;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class TransactionRepository
 * @package App\Repositories
 */
class TransactionRepository implements TransactionRepositoryInterface
{
    /**
     * TransactionRepository constructor.
     * @param Transaction $model
     */
    public function __construct(protected Transaction $model)
    {
    }

    /**
     * Get all transactions by wallet by payee id
     *
     * @param int $id
     * @return Collection
     */
    public function getAllTransactionsByWalletPayeeId(int $id): Collection
    {
        return $this->model::with('walletPayee')
            ->where('wallet_payee_id', $id)
            ->get();
    }

    /**
     * Get all transactions by type by wallet payee id
     *
     * @param int $id
     * @param string $type
     * @return Collection
     */
    public function getAllTransactionsByTypeByWalletPayeeId(
        int $id,
        string $type
    ): Collection {
        return $this->model::with('walletPayee')
            ->where(['wallet_payee_id' => $id, 'type' => $type])
            ->get();
    }

    /**
     * Get all transactions by wallet payer id
     *
     * @param int $id
     * @return Collection
     */
    public function getAllTransactionsByWalletPayerId(int $id): Collection
    {
        return $this->model::with('walletPayer')
            ->where('wallet_payer_id', $id)
            ->get();
    }

    /**
     * Get all transactions by type by wallet payer id
     *
     * @param int $id
     * @param string $type
     * @return Collection
     */
    public function getAllTransactionsByTypeByWalletPayerId(
        int $id,
        string $type
    ): Collection {
        return $this->model::with('walletPayer')
            ->where(['wallet_payer_id' => $id, 'type' => $type])
            ->get();
    }

    /**
     * Get transaction by id
     *
     * @param int $id
     * @return Transaction|null
     */
    public function getTransactionById(int $id): ?Transaction
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Create new Transaction
     *
     * @param array $data
     * @return Transaction
     */
    public function createTransaction(array $data): Transaction
    {
        return $this->model->create($data);
    }

    /**
     * Update transaction by transaction model
     *
     * @param Model $transaction
     * @param array $data
     * @return bool
     */
    public function updateTransaction(Model $transaction, array $data): bool
    {
        return $transaction->update($data);
    }
}
