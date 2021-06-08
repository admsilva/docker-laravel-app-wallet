<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wallet_payer_id');
            $table->foreign('wallet_payer_id')->references('id')->on('wallets');
            $table->unsignedBigInteger('wallet_payee_id')->nullable();
            $table->foreign('wallet_payee_id')->references('id')->on('wallets');
            $table->integer('amount');
            $table->string('description')->nullable();
            $table->enum('type', ['deposit', 'withdraw', 'transfer']);
            $table->enum('status', ['success', 'failure']);
            $table->enum('notify', ['success', 'failure']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
}
