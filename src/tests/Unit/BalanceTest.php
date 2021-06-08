<?php


namespace Tests\Unit;

use App\Models\Wallet;
use App\Repositories\Contracts\TransactionRepositoryInterface;
use App\Repositories\TransactionRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Services\TransactionService;
use Exception;

class BalanceTest extends TestCase
{
    use RefreshDatabase;

    protected TransactionService $transactionService;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->bind(TransactionRepositoryInterface::class, TransactionRepository::class);

        $this->transactionService = $this->app->make(TransactionService::class);
    }

    /**
     * Test balance logic for transfer in wallet payer.
     *
     * @return void
     * @throws Exception
     */
    public function test_balance_transfer_payer(): void
    {
        $this->seed();

        $userPayer = User::where('type', 'person')->first();
        $oldBalance = User::where('type', 'person')->first()->wallet->balance;
        $walletPayerId = $userPayer->wallet->id;
        $walletPayeeId = Wallet::whereNotIn('id', [$walletPayerId])->first()->id;

        $newDataTransaction = [
            'wallet_payer_id' => $walletPayerId,
            'wallet_payee_id' => $walletPayeeId,
            'amount' => 1000,
            'description' => 'Transfer',
            'type' => 'transfer'
        ];

        $newTransaction = $this->transactionService->makeTransaction($newDataTransaction);
        $newBalance = $newTransaction->walletPayer->balance;
        $transactionAmount = $newTransaction->amount;
        $expectedBalance = ($oldBalance - $transactionAmount);

        $this->assertEquals($expectedBalance, $newBalance, 'actual value is equals to expected');
    }

    /**
     * Test balance logic for deposit.
     *
     * @return void
     * @throws Exception
     */
    public function test_balance_deposit(): void
    {
        $this->seed();

        $userPayer = User::where('type', 'person')->first();
        $oldBalance = User::where('type', 'person')->first()->wallet->balance;
        $walletPayerId = $userPayer->wallet->id;
        $walletPayeeId = Wallet::whereNotIn('id', [$walletPayerId])->first()->id;

        $newDataTransaction = [
            'wallet_payer_id' => $walletPayerId,
            'amount' => 1000,
            'description' => 'Deposit',
            'type' => 'deposit'
        ];

        $newTransaction = $this->transactionService->makeTransaction($newDataTransaction);
        $newBalance = $newTransaction->walletPayer->balance;
        $transactionAmount = $newTransaction->amount;
        $expectedBalance = ($oldBalance + $transactionAmount);

        $this->assertEquals($expectedBalance, $newBalance, 'actual value is equals to expected');
    }

    /**
     * Test balance logic for withdraw.
     *
     * @return void
     * @throws Exception
     */
    public function test_balance_withdraw(): void
    {
        $this->seed();

        $userPayer = User::where('type', 'person')->first();
        $oldBalance = User::where('type', 'person')->first()->wallet->balance;
        $walletPayerId = $userPayer->wallet->id;
        $walletPayeeId = Wallet::whereNotIn('id', [$walletPayerId])->first()->id;

        $newDataTransaction = [
            'wallet_payer_id' => $walletPayerId,
            'amount' => 1000,
            'description' => 'Withdraw',
            'type' => 'withdraw'
        ];

        $newTransaction = $this->transactionService->makeTransaction($newDataTransaction);
        $newBalance = $newTransaction->walletPayer->balance;
        $transactionAmount = $newTransaction->amount;
        $expectedBalance = ($oldBalance - $transactionAmount);

        $this->assertEquals($expectedBalance, $newBalance, 'actual value is equals to expected');
    }

    /**
     * Test balance logic for transfer in wallet payee.
     *
     * @return void
     * @throws Exception
     */
    public function test_balance_transfer_payee(): void
    {
        $this->seed();

        $userPayer = User::where('type', 'person')->first();
        $walletPayerId = $userPayer->wallet->id;
        $walletPayeeId = Wallet::whereNotIn('id', [$walletPayerId])->first()->id;
        $oldBalance = Wallet::where('user_id', $walletPayeeId)->first()->balance;

        $newDataTransaction = [
            'wallet_payer_id' => $walletPayerId,
            'wallet_payee_id' => $walletPayeeId,
            'amount' => 1000,
            'description' => 'Transfer',
            'type' => 'transfer'
        ];

        $newTransaction = $this->transactionService->makeTransaction($newDataTransaction);
        $newBalance = $newTransaction->walletPayee->balance;
        $transactionAmount = $newTransaction->amount;
        $expectedBalance = ($oldBalance + $transactionAmount);

        $this->assertEquals($expectedBalance, $newBalance, 'actual value is equals to expected');
    }
}
