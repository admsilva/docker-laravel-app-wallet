<?php

namespace App\Services;

use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;
use Throwable;

/**
 * Class WalletService
 * @package App\Services
 */
class WalletService
{
    /**
     * WalletService constructor.
     * @param WalletRepositoryInterface $walletRepository
     */
    public function __construct(protected WalletRepositoryInterface $walletRepository)
    {
    }

    /**
     * Get all wallets
     *
     * @return Collection
     */
    public function getAllWallets(): Collection
    {
        return $this->walletRepository->getAllWallets();
    }

    /**
     * Get wallet by id
     *
     * @param int $id
     * @return Model
     * @throws Exception
     */
    public function getWalletById(int $id): Model
    {
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            throw new Exception('Wallet not found', 404);
        }

        return $wallet;
    }

    /**
     * Get wallet by user id
     *
     * @param int $id
     * @return Model
     * @throws Exception
     */
    public function getWalletByUserId(int $id): Model
    {
        $wallet = $this->walletRepository->getWalletByUserId($id);

        if (!$wallet) {
            throw new Exception('Wallet not found', 404);
        }

        return $wallet;
    }

    /**
     * Make a new wallet
     *
     * @param array $wallet
     * @return Model
     * @throws Exception
     * @throws Throwable
     */
    public function makeWallet(array $wallet): Model
    {
        try {
            DB::beginTransaction();
            $newWallet = $this->walletRepository->createWallet($wallet);
            DB::commit();
            return $newWallet;
        } catch (Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
    }

    /**
     * Changed wallet by id
     *
     * @param int $id
     * @param array $dataWallet
     * @return bool|null
     * @throws Exception
     */
    public function changeWallet(int $id, array $dataWallet): ?bool
    {
        DB::beginTransaction();
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            DB::rollBack();
            throw new Exception('Wallet not found.', 404);
        }

        if (isset($dataWallet['status'])) {
            if ($dataWallet['status'] === 'close' && $wallet->balance !== 0) {
                DB::rollBack();
                throw new Exception('Not possible close wallet because his balance not is zero!', 409);
            }

            if ($dataWallet['status'] === 'close' && $dataWallet['balance'] !== 0) {
                DB::rollBack();
                throw new Exception('Not possible close wallet because his new balance not is zero!', 409);
            }
        }

        $isUpdatedWallet = $this->walletRepository
            ->updateWallet($wallet, $dataWallet);

        if (!$isUpdatedWallet) {
            DB::rollBack();
            throw new Exception('Wallet not updated.', 409);
        }

        DB::commit();
        return true;
    }

    /**
     * Delete wallet by id
     *
     * @param int $id
     * @return bool
     * @throws Exception
     */
    public function deleteWallet(int $id): bool
    {
        DB::beginTransaction();
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            DB::rollBack();
            throw new Exception(
                'Wallet not found.',
                404
            );
        }

        if ($wallet->balance !== 0) {
            DB::rollBack();
            throw new Exception(
                'Not possible close wallet because his balance not is zero!',
                409
            );
        }

        $wallet->status = 'close';
        $walletData = Arr::except(
            $wallet->toArray(),
            ['id', 'created_at', 'updated_at']
        );
        $isUserUpdated = $this->walletRepository
            ->updateWallet($wallet, $walletData);

        if (!$isUserUpdated) {
            DB::rollBack();
            throw new Exception(
                'Wallet not closed.',
                409
            );
        }

        DB::commit();
        return true;
    }
}
