<?php


namespace App\Repositories;


use App\Models\Wallet;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


/**
 * Class WalletRepository
 * @package App\Repositories
 */
class WalletRepository implements WalletRepositoryInterface
{
    /**
     * @var Wallet
     */
    protected Wallet $model;

    /**
     * TransactionRepository constructor.
     * @param Wallet $wallet
     */
    public function __construct(Wallet $wallet)
    {
        $this->model = $wallet;
    }

    /**
     * Get All wallets
     *
     * @return Collection
     */
    public function getAllWallets(): Collection
    {
        return $this->model->all();
    }

    /**
     * Get wallet by id
     *
     * @param int $id
     * @return Wallet|null
     */
    public function getWalletById(int $id): ?Wallet
    {
        return $this->model->where('id', $id)->first();
    }

    /**
     * Get wallet by user id
     *
     * @param int $id
     * @return Wallet|null
     */
    public function getWalletByUserId(int $id): ?Wallet
    {
        return $this->model->where('user_id', $id)->first();
    }

    /**
     * Create new wallet
     *
     * @param array $data
     * @return Wallet
     */
    public function createWallet(array $data): Wallet
    {
        return $this->model->create($data);
    }

    /**
     * Update wallet by wallet model
     *
     * @param Model $wallet
     * @param array $data
     * @return bool
     */
    public function updateWallet(Model $wallet, array $data): bool
    {
        return $wallet->update($data);
    }
}
