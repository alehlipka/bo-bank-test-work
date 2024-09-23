<?php

use App\Http\Controllers\TransferController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::prefix('users')->group(function () {
        Route::patch('/{id}', [UserController::class, 'update'])->whereNumber('id');
        Route::post('/{id}/deposit', [UserController::class, 'deposit'])->whereNumber('id');
    });

    Route::prefix('transfers')->group(function () {
        Route::post('/', [TransferController::class, 'store']);
    });
});
