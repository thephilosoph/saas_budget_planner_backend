<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('auth')->group(function () {
    Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
//    Route::post('refresh', [AuthController::class, 'refresh']);
//    Route::post('forgot-password', [PasswordController::class, 'sendResetLink']);
//    Route::post('reset-password', [PasswordController::class, 'reset']);
});

Route::get("invite/{token}", [\App\Http\Controllers\Auth\TenantInvitationController::class, 'show']);
Route::post('invite/{invitation}', [\App\Http\Controllers\Auth\TenantInvitationController::class, 'accept']);

Route::middleware('auth:api')->group(function () {
    Route::prefix('category')->group(function () {
        Route::get('/{id}', [\App\Http\Controllers\Core\CategoryController::class, 'show']);
        Route::get('/', [\App\Http\Controllers\Core\CategoryController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Core\CategoryController::class, 'create']);
        Route::patch('/{id}', [\App\Http\Controllers\Core\CategoryController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Core\CategoryController::class, 'delete']);
    });
    Route::prefix('budget')->group(function () {
        Route::get('/{id}', [\App\Http\Controllers\Core\BudgetController::class, 'show']);
        Route::get('/', [\App\Http\Controllers\Core\BudgetController::class, 'index']);
        Route::post('/', [\App\Http\Controllers\Core\BudgetController::class, 'create']);
        Route::patch('/{id}', [\App\Http\Controllers\Core\BudgetController::class, 'update']);
        Route::delete('/{id}', [\App\Http\Controllers\Core\BudgetController::class, 'delete']);
    });

    Route::apiResource('transactions', \App\Http\Controllers\Finance\TransactionController::class);

    Route::prefix("invite")->group(function () {
        Route::post("/", [\App\Http\Controllers\Auth\TenantInvitationController::class, 'create']);
        Route::delete("/", [\App\Http\Controllers\Auth\TenantInvitationController::class, 'delete']);
    });
});
