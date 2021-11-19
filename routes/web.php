<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/**
 * Home Page and Registration Url
 */
Route::get('/',[\App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('index',[\App\Http\Controllers\HomeController::class,'index'])->name('home');
Route::get('register',[\App\Http\Controllers\Web\RegisterController::class,'index'])->name('register_page');
Route::get('login',[\App\Http\Controllers\Web\LoginController::class,'index'])->name('login');;
Route::get('email_verify',[\App\Http\Controllers\Web\RegisterController::class,'emailVerify'])->name('email_verify');
Route::get('twoway',[\App\Http\Controllers\Web\LoginController::class,'twoFactor'])->name('two_factor');;
Route::get('recoverpassword',[\App\Http\Controllers\Web\ResetController::class,'index'])->name('recover_password');;
Route::get('confirm_reset',[\App\Http\Controllers\Web\ResetController::class,'confirmReset'])->name('confirm_password_reset');;
Route::get('reset',[\App\Http\Controllers\Web\ResetController::class,'resetPassword'])->name('reset_password');

Route::post('login',[\App\Http\Controllers\Web\AuthController::class,'signin']);
Route::post('twoway',[\App\Http\Controllers\Web\AuthController::class,'twoWay']);

Route::post('get-country',[\App\Http\Controllers\Web\User\Countries::class,'returnCountries']);
Route::post('get-country-state/{country}',[\App\Http\Controllers\Web\User\Countries::class,'getCountryStates']);
Route::post('get-state-city/{state}',[\App\Http\Controllers\Web\User\Countries::class,'getStateCities']);
Route::get('get-logistics/{country}/{state}/{city}',[\App\Http\Controllers\Web\Merchant\Logistics::class,'getDeliverySerices']);

Route::middleware('auth')->group( function () {
    Route::middleware(['isUser'])->prefix('account')->group(function (){
        Route::get('dashboard',[\App\Http\Controllers\Web\User\Dashboard::class,'index']);
        Route::get('dashboard/get_deposit_method/{code}',[\App\Http\Controllers\Web\User\Dashboard::class,'getDepositMethod']);
        Route::get('dashboard/get_deposit_method_id/{id}',[\App\Http\Controllers\Web\User\Dashboard::class,'getDepositMethodId']);
        Route::get('dashboard/get_banks/{country}',[\App\Http\Controllers\Web\User\Dashboard::class,'getBanks']);
        Route::get('dashboard/get_banks_currency/{currency}',[\App\Http\Controllers\Web\User\Dashboard::class,'getBanksByCurrency']);
        Route::get('dashboard/get_bank/{code}',[\App\Http\Controllers\Web\User\Dashboard::class,'getBank']);
        Route::post('dashboard/convert_referral',[\App\Http\Controllers\Web\User\Dashboard::class,'convertReferral']);
        Route::post('dashboard/convert_specific_referral',[\App\Http\Controllers\Web\User\Dashboard::class,'convertSpecificReferral']);
        Route::post('dashboard/convert_to_ngn',[\App\Http\Controllers\Web\User\Dashboard::class,'convertToNGN']);
        Route::get('dashboard/get_specific_currency/{currency}',[\App\Http\Controllers\Web\User\Dashboard::class,'getSpecificCurrencyData']);
        Route::post('dashboard/bank-transfer',[\App\Http\Controllers\Web\User\Dashboard::class,'createBankTransferCharge']);
        Route::post('dashboard/charge-otp',[\App\Http\Controllers\Web\User\Dashboard::class,'completeOtpCharge']);
        Route::post('dashboard/set_pin',[\App\Http\Controllers\Web\User\Dashboard::class,'setPin']);
        Route::get('activities',[\App\Http\Controllers\Web\User\Activities::class,'index']);
        Route::get('logins',[\App\Http\Controllers\Web\User\Activities::class,'logins']);
        Route::get('transactions',[\App\Http\Controllers\Web\User\Transactions::class,'index']);
        Route::get('transactions/{ref}/details',[\App\Http\Controllers\Web\User\Transactions::class,'details'])
        ->where('ref','[A-Za-z0-9_]+');
        Route::get('beneficiary',[\App\Http\Controllers\Web\User\Beneficiary::class,'index']);
        Route::post('add-beneficiary',[\App\Http\Controllers\Web\User\Beneficiary::class,'addBeneficiary']);
        Route::post('remove-beneficiary/{id}',[\App\Http\Controllers\Web\User\Beneficiary::class,'removeBeneficiary']);
        Route::get('referrals',[\App\Http\Controllers\Web\User\Referrals::class,'index']);
        Route::get('referrals/earnings',[\App\Http\Controllers\Web\User\Referrals::class,'earnings']);
        Route::get('settings',[\App\Http\Controllers\Web\User\Settings::class,'index']);
        Route::post('settings/profile_change',[\App\Http\Controllers\Web\User\Settings::class,'updateProfilePic']);
        Route::post('settings/change_password',[\App\Http\Controllers\Web\User\Settings::class,'updatePassword']);
        Route::post('settings/update_profile',[\App\Http\Controllers\Web\User\Settings::class,'updateProfile']);
        Route::post('settings/change_account',[\App\Http\Controllers\Web\User\Settings::class,'switchAccount']);
        Route::get('profile',[\App\Http\Controllers\Web\User\Profile::class,'index']);
        Route::get('account_wallet',[\App\Http\Controllers\Web\User\AccountWallet::class,'index']);
        Route::get('more',[\App\Http\Controllers\Web\User\MoreActions::class,'index']);
        Route::get('documents/verify',[\App\Http\Controllers\Web\User\Documents::class,'index']);
        Route::get('documents/get-document-type-id/{id}',[\App\Http\Controllers\Web\User\Documents::class,'getDocumentTypeId'])
            ->whereNumber('id');
        Route::post('documents/verify',[\App\Http\Controllers\Web\User\Documents::class,'verifyAccount']);
        Route::get('documents/documents',[\App\Http\Controllers\Web\User\MoreActions::class,'index']);
        Route::get('documents/error',[\App\Http\Controllers\Web\User\MoreActions::class,'index']);
        Route::get('get_pubkey',[\App\Http\Controllers\Web\User\Dashboard::class,'getFlutterwavePubKey']);
        Route::get('verify_transaction/{id}',[\App\Http\Controllers\Web\User\Dashboard::class,'verifyTransaction']);
        /*=================== ESCROW ROUTES =========================*/
        Route::get('escrows',[\App\Http\Controllers\Web\User\Escrows::class,'index']);
        /*=================== PAYOUT ROUTES =========================*/
        Route::get('transfers',[\App\Http\Controllers\Web\User\Payouts::class,'index']);
        Route::post('new_transfer',[\App\Http\Controllers\Web\User\Payouts::class,'authenticateTransfer']);
        Route::get('get_beneficiary/{id}',[\App\Http\Controllers\Web\User\Payouts::class,'getBeneficiaryId']);
        Route::get('transfers/{ref}/details',[\App\Http\Controllers\Web\User\Payouts::class,'payoutDetails'])
            ->where('ref','[A-Za-z0-9_]+');
        //LOGOUT Route
        Route::get('logout',[\App\Http\Controllers\Web\AuthController::class,'Logout']);
    });
    Route::middleware(['isVendor'])->prefix('merchant')->group(function (){
        Route::get('dashboard',[\App\Http\Controllers\Web\Merchant\Dashboard::class,'index']);
        Route::post('dashboard/set_pin',[\App\Http\Controllers\Web\Merchant\Dashboard::class,'setPin']);
        /*======================= BUSINESS ROUTE ==========================================*/
        Route::get('businesses',[\App\Http\Controllers\Web\Merchant\Business::class,'index']);
        Route::get('business/create-business',[\App\Http\Controllers\Web\Merchant\Business::class,'createBusiness']);
        Route::get('business/get_category_subcategory/{id}',[\App\Http\Controllers\Web\Merchant\Business::class,'getSubcategoryOfCategory']);
        Route::post('add-business',[\App\Http\Controllers\Web\Merchant\Business::class,'doCreation']);
        Route::post('remove-business',[\App\Http\Controllers\Web\Merchant\Business::class,'doRemove']);
        Route::get('business/{ref}',[\App\Http\Controllers\Web\Merchant\Business::class,'businessDetail']);
        Route::post('business/logo_change/{ref}',[\App\Http\Controllers\Web\Merchant\Business::class,'updateLogo']);
        /*======================= ESCROW ROUTE ==========================================*/
        Route::get('escrows',[\App\Http\Controllers\Web\Merchant\Escrow::class,'index']);
        Route::get('new_escrow',[\App\Http\Controllers\Web\Merchant\Escrow::class,'createEscrow']);
        Route::get('escrows/get_currency_charge/{currency}',[\App\Http\Controllers\Web\Merchant\Escrow::class,'getCurrencyChargeInternal']);
        Route::post('add-escrow',[\App\Http\Controllers\Web\Merchant\Escrow::class,'doCreation']);
        Route::get('escrows/{ref}/details',[\App\Http\Controllers\Web\Merchant\Escrow::class,'details']);
        Route::get('escrows/notify_payer_pending_escrow_payment/{ref}',[\App\Http\Controllers\Web\Merchant\Escrow::class,'notifyPayerAboutPendingPayments']);
        Route::post('add-escrow-delivery-service',[\App\Http\Controllers\Web\Merchant\Escrow::class, 'doLogistics']);
        Route::post('cancel-escrow',[\App\Http\Controllers\Web\Merchant\Escrow::class, 'doCancel']);
        Route::post('complete-escrow',[\App\Http\Controllers\Web\Merchant\Escrow::class, 'doComplete']);
        Route::post('refund-escrow',[\App\Http\Controllers\Web\Merchant\Escrow::class, 'doCancel']);
        /*======================= REFERRAL ROUTE ==========================================*/
        Route::get('/referrals',['App\Http\Controllers\Web\Merchant\Referral','index']);
        Route::get('/referrals/earnings',['App\Http\Controllers\Web\Merchant\Referral','earnings']);
        /*======================= ACTIVITY ROUTE ==========================================*/
        Route::get('/activities',['App\Http\Controllers\Web\Merchant\Activities','index']);
        Route::get('/logins',['App\Http\Controllers\Web\Merchant\Activities','logins']);
        /*======================= TRANSACTIONS ROUTE ==========================================*/
        Route::get('/transactions',['App\Http\Controllers\Web\Merchant\Transactions','index']);
        Route::get('/logins',['App\Http\Controllers\Web\Merchant\Transactions','details']);
        //LOGOUT Route
        Route::get('logout',[\App\Http\Controllers\Web\AuthController::class,'Logout']);
    });
});
