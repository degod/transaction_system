<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BalanceController;
use App\Http\Controllers\TransactionController;

Route::prefix('v1')->group(function () {
    Route::get('balance', [BalanceController::class, 'show'])->name('balance.show');
    Route::post('transaction', [TransactionController::class, 'store'])->name('transaction.store');
});
