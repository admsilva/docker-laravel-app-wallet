<?php


namespace App\Services;

use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\Contracts\WalletRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Exception\GuzzleException;
use Exception;
use Throwable;

/**
 * Class TransactionService
 * @package App\Services
 */
class TransactionService
{
    /**
     * TransactionService constructor.
     * @param TransactionRepositoryInterface $transactionRepository
     * @param WalletRepositoryInterface $walletRepository
     * @param AuthorizationService $authorizationService
     * @param NotificationService $notificationService
     */
    public function __construct(
        protected TransactionRepositoryInterface $transactionRepository,
        protected WalletRepositoryInterface $walletRepository,
        protected AuthorizationService $authorizationService,
        protected NotificationService $notificationService
    ) {
    }

    /**
     * Get all transaction by wallet id
     *
     * @param int $id
     * @return array
     * @throws Exception
     */
    public function getAllTransactionsByWalletId(int $id): array
    {
        $wallet = $this->walletRepository->getWalletById($id);

        if (!$wallet) {
            throw new Exception('Wallet not found', 404);
        }

        $payer = $this->transactionRepository->getAllTransactionsByWalletPayerId($id);

        $deposits = $payer->filter(function ($object) {
            return $object->type === 'deposit' ?? $object;
        });

        $withdraws = $payer->filter(function ($object) {
            return $object->type === 'withdraw' ?? $object;
        });

        $transfers = $payer->filter(function ($object) {
            return $object->type === 'transfer' ?? $object;
        });

        return [
            'deposits' => $deposits,
            'withdraws' => $withdraws,
            'transfers' => $transfers
        ];
    }

    /**
     * Get a transaction by id
     *
     * @param int $id
     * @return Model|null
     * @throws Exception
     */
    public function getTransactionById(int $id): ?Model
    {
        $transaction = $this->transactionRepository->getTransactionById($id);

        if (!$transaction) {
            throw new Exception('Transaction not found', 404);
        }

        return $transaction;
    }

    /**
     * Make a new transaction
     *
     * @param array $transaction
     * @return Model
     * @throws Exception
     * @throws GuzzleException
     * @throws Throwable
     */
    public function makeTransaction(array $transaction): Model
    {
        try {
            DB::beginTransaction();

            $walletPayer = $this->walletRepository
                ->getWalletById($transaction['wallet_payer_id']);

            if ($walletPayer->user->status === 'deactivate') {
                DB::rollBack();
                throw new Exception('Not allowed user is deactivate.', 405);
            }

            if ($walletPayer->user->type === 'shopkeeper' &&
                $transaction['type'] === 'transfer'
            ) {
                DB::rollBack();
                throw new Exception('Not allowed transfer for shopkeeper.', 405);
            }

            if ($walletPayer->status === 'close') {
                DB::rollBack();
                throw new Exception('Not allowed wallet is close.', 405);
            }

            $newBalancePayer = ($transaction['type'] === 'deposit') ?
                ($walletPayer->balance + $transaction['amount']) :
                ($walletPayer->balance - $transaction['amount']);

            if (in_array($transaction['type'], ['withdraw', 'transfer'])) {
                if ($newBalancePayer < 0) {
                    DB::rollBack();
                    throw new Exception('Insufficient funds.', 405);
                }
            }

            $walletPayer->balance = $newBalancePayer;
            $walletPayerData = Arr::except(
                $walletPayer->toArray(),
                ['id', 'created_at', 'updated_at']
            );
            $updatedWalletPayer = $this->walletRepository
                ->updateWallet($walletPayer, $walletPayerData);

            if (!$updatedWalletPayer) {
                DB::rollBack();
                throw new Exception('Wallet Payer not updated', 405);
            }

            if ($transaction['type'] === 'transfer') {
                $walletPayee = $this->walletRepository
                    ->getWalletById($transaction['wallet_payee_id']);

                if (!$walletPayee) {
                    DB::rollBack();
                    throw new Exception('Wallet Payee not found.', 404);
                }

                $newBalancePayee = ($walletPayee->balance + $transaction['amount']);
                $walletPayee->balance = $newBalancePayee;
                $walletPayeeData = Arr::except(
                    $walletPayee->toArray(),
                    ['id', 'created_at', 'updated_at']
                );
                $updatedWalletPayee = $this->walletRepository
                    ->updateWallet($walletPayee, $walletPayeeData);

                if (!$updatedWalletPayee) {
                    DB::rollBack();
                    throw new Exception('Wallet Payee not updated', 405);
                }
            }

            $isAuthorization = $this->authorizationService->checkAuthorization();

            if ($isAuthorization !== 'Autorizado') {
                DB::rollBack();
                throw new Exception('Transaction not allowed!', 405);
            }

            $notifyTransaction = $this->notificationService->sendNotify();

            $transaction['notify'] = $notifyTransaction;
            $transaction['status'] = 'success';

            $transactionCreated = $this->transactionRepository
                ->createTransaction($transaction);

            DB::commit();
            return $transactionCreated;
        } catch (Throwable $throwable) {
            DB::rollBack();
            throw $throwable;
        }
    }
}
