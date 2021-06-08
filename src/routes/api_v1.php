<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\WalletController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\TransactionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::resource('wallets', WalletController::class)->except([
    'create', 'edit'
]);

Route::resource('users', UserController::class)->except([
    'create', 'edit'
]);

Route::resource('transactions', TransactionController::class)->only([
    'show', 'store'
]);

Route::get('transactions/byWallet/{id}', [TransactionController::class, 'showTransactionsByWalletId']);
