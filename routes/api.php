<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoleController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\WarehouseController;
use App\Http\Controllers\Api\StockController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Auth Routes
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    
    // Roles (Admin only)
    Route::middleware('role:Admin')->group(function () {
        Route::apiResource('roles', RoleController::class);
    });

    // Users (Admin only)
    Route::middleware('role:Admin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::post('/users/{user}/roles', [UserController::class, 'assignRoles']);
    });

    // Products
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{product}', [ProductController::class, 'show']);
    
    Route::middleware('role:Admin,Staff')->group(function () {
        Route::post('/products', [ProductController::class, 'store']);
        Route::put('/products/{product}', [ProductController::class, 'update']);
    });
    
    Route::middleware('role:Admin')->group(function () {
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    });

    // Suppliers
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::get('/suppliers/{supplier}', [SupplierController::class, 'show']);
    
    Route::middleware('role:Admin,Staff')->group(function () {
        Route::post('/suppliers', [SupplierController::class, 'store']);
        Route::put('/suppliers/{supplier}', [SupplierController::class, 'update']);
    });
    
    Route::middleware('role:Admin')->group(function () {
        Route::delete('/suppliers/{supplier}', [SupplierController::class, 'destroy']);
    });

    // Warehouses
    Route::get('/warehouses', [WarehouseController::class, 'index']);
    Route::get('/warehouses/{warehouse}', [WarehouseController::class, 'show']);
    
    Route::middleware('role:Admin')->group(function () {
        Route::post('/warehouses', [WarehouseController::class, 'store']);
        Route::put('/warehouses/{warehouse}', [WarehouseController::class, 'update']);
        Route::delete('/warehouses/{warehouse}', [WarehouseController::class, 'destroy']);
    });

    // Stocks
    Route::get('/stocks', [StockController::class, 'index']);
    
    Route::middleware('role:Owner,Admin')->group(function () {
        Route::get('/stocks/summary', [StockController::class, 'summary']);
    });
    
    Route::middleware('role:Admin')->group(function () {
        Route::post('/stocks/adjustments', [StockController::class, 'adjustment']);
    });

    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show']);
    
    Route::middleware('role:Admin,Staff')->group(function () {
        Route::post('/transactions/in', [TransactionController::class, 'storeIn']);
        Route::post('/transactions/out', [TransactionController::class, 'storeOut']);
    });
    
    Route::middleware('role:Admin')->group(function () {
        Route::post('/transactions/{transaction}/void', [TransactionController::class, 'void']);
    });

    // Reports (Owner only)
    Route::middleware('role:Owner,Admin')->group(function () {
        Route::get('/reports/daily-stock', [ReportController::class, 'dailyStock']);
        Route::get('/reports/monthly-transactions', [ReportController::class, 'monthlyTransactions']);
        Route::get('/reports/fast-moving', [ReportController::class, 'fastMoving']);
    });
});
