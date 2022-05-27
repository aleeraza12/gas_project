<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepoController;
use App\Http\Controllers\General;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Payment;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('token')->group(function () {
    Route::post('login', [General::class, 'Login'])->withoutMiddleware('token');
    Route::post('logout', [General::class, 'Logout']);

    //Customer Type routes
    Route::prefix('customer_type')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::post('create', 'create_customer_type');
            Route::post('delete', 'delete_customer_type');
            Route::post('read', 'read_customer_type');
            Route::post('read_all', 'read_all_customer_type');
        });
    });

    //User Type routes
    Route::prefix('user_type')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('create', 'create_user_type');
            Route::post('delete', 'delete_user_type');
            Route::post('read', 'read_user_type');
            Route::post('read_all', 'read_all_user_type');
        });
    });

    //Customer CRUD routes
    Route::prefix('customer')->group(function () {
        Route::controller(CustomerController::class)->group(function () {
            Route::post('create', 'create_customer');
            Route::post('delete', 'delete_customer');
            Route::post('read', 'read_customer');
            Route::post('read_all', 'read_all_customer');
        });
    });


    //User CRUD routes
    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('create', 'create_user')->withoutMiddleware('token');
            Route::post('delete', 'delete_user');
            Route::post('read', 'read_user');
            Route::post('read_all', 'read_all_user');
        });
    });

    //Payment Mode route
    Route::prefix('payment/mode')->group(function () {
        Route::controller(Payment::class)->group(function () {
            Route::post('create', 'create_payment_mode');
            Route::post('delete', 'delete_payment_mode');
            Route::post('read', 'read_payment_mode');
            Route::post('read_all', 'read_all_payment_mode');
        });
    });

     //Payment Status route
     Route::prefix('payment/status')->group(function () {
        Route::controller(Payment::class)->group(function () {
            Route::post('create', 'create_payment_status');
            Route::post('delete', 'delete_payment_status');
            Route::post('read', 'read_payment_status');
            Route::post('read_all', 'read_all_payment_status');
        });
    });

    //Payment Status route
    Route::prefix('order')->group(function () {
        Route::controller(OrderController::class)->group(function () {
            Route::post('create', 'create_order');
            Route::post('delete', 'delete_order');
            Route::post('read', 'read_order');
            Route::post('read_all', 'read_all_order');
        });
    });

     //Depo route
     Route::prefix('depo')->group(function () {
        Route::controller(DepoController::class)->group(function () {
            Route::post('create', 'create_depo_price');
            Route::post('delete', 'delete_depo_price');
            Route::post('read', 'read_depo_price');
            Route::post('read_all', 'read_all_depo_prices');
        });
    });


       //Purchase route
       Route::prefix('purchase')->group(function () {
        Route::controller(PurchaseController::class)->group(function () {
            Route::post('create', 'create_purchase');
            Route::post('delete', 'delete_purchase');
            Route::post('read', 'read_purchase');
            Route::post('read_all', 'read_all_purchases');
        });
    });

     //Company route
     Route::prefix('company')->group(function () {
        Route::controller(CompanyController::class)->group(function () {
            Route::post('create', 'create_company')->withoutMiddleware('token');
            Route::post('delete', 'delete_company');
            Route::post('read', 'read_company');
            Route::post('read_all', 'read_all_companies');
        });
    });
});






