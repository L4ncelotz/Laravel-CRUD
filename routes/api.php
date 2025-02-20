<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\BudgetPlanController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    
    // Token Management
    Route::get('/tokens', [TokenController::class, 'index']);
    Route::delete('/tokens/{id}', [TokenController::class, 'destroy']);
    Route::post('/tokens/revoke-all', [TokenController::class, 'revokeAll']);

    // Categories
    Route::apiResource('categories', CategoryController::class);
    
    // SubCategories
    Route::get('categories/{category}/subcategories', [SubCategoryController::class, 'index']);
    Route::post('categories/{category}/subcategories', [SubCategoryController::class, 'store']);
    Route::put('subcategories/{subCategory}', [SubCategoryController::class, 'update']);
    Route::delete('subcategories/{subCategory}', [SubCategoryController::class, 'destroy']);
    
    // Transactions
    Route::apiResource('transactions', TransactionController::class);

    // Payment Methods
    Route::apiResource('payment-methods', PaymentMethodController::class);

    // Budget Plans
    Route::apiResource('budget-plans', BudgetPlanController::class);
}); 