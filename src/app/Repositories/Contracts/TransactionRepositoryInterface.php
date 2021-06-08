<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface TransactionRepositoryInterface
 * @package App\Repositories\Contracts
 */
interface TransactionRepositoryInterface
{
    /**
     * Get all transactions by wallet payee id
     *
     * @param int $id
     * @return Collection
     */
    public function getAllTransactionsByWalletPayeeId(int $id): Collection;

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
    ): Collection;

    /**
     * Get all transactions by wallet payer id
     *
     * @param int $id
     * @return Collection
     */
    public function getAllTransactionsByWalletPayerId(int $id): Collection;

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
    ): Collection;

    /**
     * Get Transaction by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getTransactionById(int $id): ?Model;

    /**
     * Create new Transaction
     *
     * @param array $data
     * @return Model
     */
    public function createTransaction(array $data): Model;

    /**
     * Update transaction by transaction model
     *
     * @param Model $transaction
     * @param array $data
     * @return bool
     */
    public function updateTransaction(Model $transaction, array $data): bool;
}
