<?php

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

Route::post('register', [\App\Http\Controllers\Api\AuthController::class,'signup']);
Route::post('login',[\App\Http\Controllers\Api\AuthController::class,'signin']);
Route::post('reset-password',[\App\Http\Controllers\Api\AuthController::class,'resetPassword']);
Route::middleware('auth:sanctum')->group( function () {
    Route::post('email', [\App\Http\Controllers\Api\AuthController::class,'emailVerification']);
    Route::post('resend-email', [\App\Http\Controllers\Api\AuthController::class,'resendEmail']);
    Route::post('verify-reset-code', [\App\Http\Controllers\Api\AuthController::class,'authenticateResetRequest']);
    Route::post('change-password', [\App\Http\Controllers\Api\AuthController::class,'changePassword']);
    Route::post('twoway', [\App\Http\Controllers\Api\AuthController::class,'twoWay']);
    Route::post('resend-twoway', [\App\Http\Controllers\Api\AuthController::class,'resendTwoway']);
    Route::post('resend-resetmail', [\App\Http\Controllers\Api\AuthController::class,'resendPasswordReset']);
    Route::middleware('twoway')->group(function () {
        Route::middleware('isBuyer')->prefix('account')->group(function (){
            Route::get('/dashboard', [\App\Http\Controllers\Api\User\Dashboard::class,'index']);
            Route::get('/get-account-limit/{code}', [\App\Http\Controllers\Api\User\Dashboard::class,'getAccountlimit']);
            Route::get('/get-balance/{code}', [\App\Http\Controllers\Api\User\Dashboard::class,'getBalance']);
            Route::get('/user-profile', [\App\Http\Controllers\Api\User\Dashboard::class,'getUserProfile']);
            Route::get('/last-five-transactions', [\App\Http\Controllers\Api\User\Dashboard::class,'getLastFiveTransactions']);
            Route::get('/transactions', [\App\Http\Controllers\Api\User\Dashboard::class,'getUserTransactions']);
            Route::get('/transactions/{id}', [\App\Http\Controllers\Api\User\Dashboard::class,'getTransactionDetails']);
            Route::get('/businesses', [\App\Http\Controllers\Api\User\Dashboard::class,'getBusinesses']);
        });
        Route::middleware('isMerchant')->prefix('merchant')->group(function (){
            Route::get('/dashboard', [\App\Http\Controllers\Api\Merchant\Dashboard::class,'index']);
            Route::get('/get-account-limit/{code}', [\App\Http\Controllers\Api\Merchant\Dashboard::class,'getAccountlimit']);
            Route::get('/get-balance/{code}', [\App\Http\Controllers\Api\Merchant\Dashboard::class,'getBalance']);
            Route::get('/merchant-profile', [\App\Http\Controllers\Api\Merchant\Dashboard::class,'getUserProfile']);
            Route::get('/subcategory-category/{id}',[\App\Http\Controllers\Api\Merchant\Dashboard::class,'getSubcategories']);
            Route::post('/create-business',[\App\Http\Controllers\Api\Merchant\Business::class,'createBusiness']);
            Route::get('/list-business',[\App\Http\Controllers\Api\Merchant\Business::class,'getBusinesses']);
            Route::get('/list-business/{ref}',[\App\Http\Controllers\Api\Merchant\Business::class,'getBusinessByRef'])
                    ->where('ref','[A-Za-z0-9_]+');
        });
        Route::post('logout', [\App\Http\Controllers\Api\AuthController::class,'logout']);
    });
});
