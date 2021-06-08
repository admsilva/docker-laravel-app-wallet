<?php

namespace Database\Factories;

use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transaction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(['deposit', 'withdraw', 'transfer']);

        if ($type === 'transfer') {
            $walletPayerId = User::inRandomOrder()
                ->where('type', 'person')
                ->first()
                ->wallet
                ->id;

            $walletPayeeId = Wallet::inRandomOrder()
                ->whereNotIn('id', [$walletPayerId])
                ->first()
                ->id;
        } else {
            $walletPayerId = Wallet::inRandomOrder()->first()->id;
            $walletPayeeId = null;
        }

        return [
            'wallet_payer_id' => $walletPayerId,
            'wallet_payee_id' => $walletPayeeId,
            'amount' => $this->faker->randomNumber(4),
            'description' => $this->faker->text(100),
            'type' => $type,
            'status' => 'success',
            'notify' => 'success',
        ];
    }
}
