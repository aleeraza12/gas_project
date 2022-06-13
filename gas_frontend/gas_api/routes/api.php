<?php

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DepoController;
use App\Http\Controllers\General;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Payment;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\StatesController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
    //Dashboard
    Route::prefix('dashboard')->group(function () {
        Route::controller(General::class)->group(function () {
            Route::post('read_all', 'get_dashboard_stats');
            Route::post('read', 'get_dashboard_all');
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
            Route::post('read_specific_customer', 'read_customer');
            Route::post('read', 'read');
            Route::post('read_all', 'read_all_customer');
        });
    });


    //User CRUD routes
    Route::prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('create', 'create_user')->withoutMiddleware('token');
            Route::post('delete', 'delete_user');
            Route::post('read_specific_user', 'read_user');
            Route::post('read', 'read');
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
            Route::post('read_all', 'read_order');
            Route::post('read', 'read_all_order');
        });
    });

    //Depo route
    Route::prefix('depo')->group(function () {
        Route::controller(DepoController::class)->group(function () {
            Route::post('create', 'create_depo_price');
            Route::post('delete', 'delete_depo_price');
            Route::post('read_one', 'read_depo_price');
            Route::post('read', 'read_all_depo_prices');
        });
    });


    //Purchase route
    Route::prefix('purchase')->group(function () {
        Route::controller(PurchaseController::class)->group(function () {
            Route::post('create', 'create_purchase');
            Route::post('update_purchase_status', 'updatePurchaseStatus');
            Route::post('update', 'update_purchase');
            Route::post('delete', 'delete_purchase');
            Route::post('read_specific_purchase', 'read_purchase');
            Route::post('read', 'read');
            Route::post('read_all', 'read_all_purchases');
        });
    });

    //Company route
    Route::prefix('company')->group(function () {
        Route::controller(CompanyController::class)->group(function () {
            Route::post('create', 'create_company')->withoutMiddleware('token');
            Route::post('delete', 'delete_company');
            Route::post('read_specific_company', 'read_company');
            Route::post('read', 'read');
            Route::post('read_all', 'read_all_companies');
        });
    });

    //Sales route
    Route::prefix('sale')->group(function () {
        Route::controller(SaleController::class)->group(function () {
            Route::post('create', 'create_sale');
            Route::post('update', 'updateSale');
            Route::post('update_sale_status', 'updateSaleStatus');
            Route::post('delete', 'delete_sale');
            Route::post('read_specific_sale', 'read_sale');
            Route::post('read', 'read');
            Route::post('read_all', 'read_all_sale');
        });
    });

    //States route
    Route::prefix('states')->group(function () {
        Route::controller(StatesController::class)->group(function () {
            Route::post('create', 'create_states');
            Route::post('delete', 'delete_states');
            Route::post('read', 'read_sale');
            Route::post('read_all', 'read_all_states')->withoutMiddleware('token');
        });
    });
    //States route
    Route::prefix('transaction')->group(function () {
        Route::controller(TransactionController::class)->group(function () {
            Route::post('read', 'read');
            Route::post('read_all', 'readTransactions');
        });
    });

    //Wallet route
    Route::prefix('wallet')->group(function () {
        Route::controller(WalletController::class)->group(function () {
            Route::post('create', 'create_wallet');
            Route::post('read', 'read');
            Route::post('read_all', 'read');
        });
    });

    //Wallet route

});
Route::controller(MailController::class)->group(function () {
    Route::post('sendbasicemail', 'basic_email');
    Route::post('verify_otp', 'verify_otp');
    Route::post('update_password', 'update_password');
});
