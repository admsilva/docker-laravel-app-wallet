<?php

use App\Http\Controllers\Api\V1\TransactionController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\WalletController;
use Illuminate\Support\Facades\Route;

Route::resource('users', UserController::class)->except(['create', 'edit']);
Route::resource('wallets', WalletController::class)->except(['create', 'edit']);
Route::resource('transactions', TransactionController::class)->only(['show', 'store']);
Route::get('transactions/byWallet/{id}', [TransactionController::class, 'showTransactionsByWalletId']);
