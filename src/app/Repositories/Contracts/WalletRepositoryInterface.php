<?php


namespace App\Repositories\Contracts;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Interface WalletRepositoryInterface
 * @package App\Repositories\Contracts
 */
interface WalletRepositoryInterface
{
    /**
     * Get all wallets
     *
     * @return Collection
     */
    public function getAllWallets(): Collection;

    /**
     * Get wallet by id
     *
     * @param int $id
     * @return Model|null
     */
    public function getWalletById(int $id): ?Model;

    /**
     * Get wallet by user id
     *
     * @param int $id
     * @return Model|null
     */
    public function getWalletByUserId(int $id): ?Model;

    /**
     * Create new wallet
     *
     * @param array $data
     * @return Model
     */
    public function createWallet(array $data): Model;

    /**
     * Update wallet by wallet model
     *
     * @param Model $wallet
     * @param array $data
     * @return bool
     */
    public function updateWallet(Model $wallet, array $data): bool;
}
