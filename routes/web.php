<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Controllers\Web\Merchant\AccountWallet;
use App\Http\Controllers\Web\Merchant\Beneficiary;
use App\Http\Controllers\Web\Merchant\Business;
use App\Http\Controllers\Web\Merchant\Dashboard;
use App\Http\Controllers\Web\Merchant\Documents;
use App\Http\Controllers\Web\Merchant\Escrow;
use App\Http\Controllers\Web\Merchant\Logistics;
use App\Http\Controllers\Web\Merchant\MoreActions;
use App\Http\Controllers\Web\Merchant\PaymentLink;
use App\Http\Controllers\Web\Merchant\Payments;
use App\Http\Controllers\Web\Merchant\Payouts;
use App\Http\Controllers\Web\Merchant\Profile;
use App\Http\Controllers\Web\Merchant\Settings;
use App\Http\Controllers\Web\RegisterController;
use App\Http\Controllers\Web\ResetController;
use App\Http\Controllers\Web\User\Countries;
use App\Http\Controllers\Web\User\Escrows;
use App\Http\Controllers\Web\User\Merchants;
use App\Http\Controllers\Web\User\Referrals;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Merchant\Activities;
use App\Http\Controllers\Web\Merchant\Customers;
use App\Http\Controllers\Web\Merchant\Referral;
use App\Http\Controllers\Web\Merchant\Transactions;

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
/* ================= LANDING PAGE ROUTE ======================*/
Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('index',[HomeController::class,'index'])->name('home');
Route::get('about',[HomeController::class,'about'])->name('about');
Route::get('career',[HomeController::class,'career'])->name('career');
Route::get('team',[HomeController::class,'team'])->name('team');
Route::get('faq',[HomeController::class,'faq'])->name('faq');
Route::get('faq/{id}/details',[HomeController::class,'faqDetails'])->name('faq_detail');
Route::get('community',[HomeController::class,'community'])->name('community');
Route::get('stores',[HomeController::class,'stores'])->name('stores');
Route::get('payment-link',[HomeController::class,'paymentLink'])->name('payment-link');
Route::get('payment-processing',[HomeController::class,'paymentProcessing'])->name('payment-processing');
Route::get('plugin',[HomeController::class,'plugins'])->name('plugins');
Route::get('contact',[HomeController::class,'contact'])->name('contact');
Route::get('pricing',[HomeController::class,'pricing'])->name('pricing');
Route::get('supported-escrows',[HomeController::class,'supportedEscrows'])->name('supported-escrows');
Route::get('terms',[HomeController::class,'terms'])->name('terms');
Route::get('privacy',[HomeController::class,'privacy'])->name('privacy');
Route::get('developers',[HomeController::class,'developers'])->name('developers');
/* ========================== PAY THROUGH LINK ROUTE =============================*/
Route::get('/send-money/{ref}',[\App\Http\Controllers\Web\PayLink::class,'index']);
Route::post('/send-money/doSend',[\App\Http\Controllers\Web\PayLink::class,'doSend']);
Route::get('/send-money/process_payment/{ref}',[\App\Http\Controllers\Web\PayLink::class,'processPayment']);
Route::get('/send-money/check_status/{ref}',[\App\Http\Controllers\Web\PayLink::class,'checkStatus']);
/* ========================== PAYMENT LINK ROUTE =============================*/
Route::get('/pay/{ref}',[\App\Http\Controllers\Web\Pay_Merchant\Pay::class,'index']);
Route::post('/pay/doPay',[\App\Http\Controllers\Web\Pay_Merchant\Pay::class,'doPay']);
Route::post('/pay/process_payment/{ref}/{linkRef}',[\App\Http\Controllers\Web\Pay_Merchant\Pay::class,'doPay']);
Route::get('/pay/check_status/{ref}',[\App\Http\Controllers\Web\Pay_Merchant\Pay::class,'checkStatus']);


Route::get('register',[RegisterController::class,'index'])->name('register_page');
Route::get('login',[LoginController::class,'index'])->name('login');;
Route::get('email_verify',[RegisterController::class,'emailVerify'])->name('email_verify');
Route::get('twoway',[LoginController::class,'twoFactor'])->name('two_factor');;
Route::get('recoverpassword',[ResetController::class,'index'])->name('recover_password');;
Route::get('confirm_reset',[ResetController::class,'confirmReset'])->name('confirm_password_reset');;
Route::get('reset',[ResetController::class,'resetPassword'])->name('reset_password');
Route::post('login',[AuthController::class,'signin']);
Route::post('twoway',[AuthController::class,'twoWay']);

Route::post('get-country',[Countries::class,'returnCountries']);
Route::post('get-country-state/{country}',[Countries::class,'getCountryStates']);
Route::post('get-state-city/{state}',[Countries::class,'getStateCities']);
Route::get('get-logistics/{country}/{state}/{city}',[Logistics::class,'getDeliverySerices']);

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
        Route::get('referrals',[Referrals::class,'index']);
        Route::get('referrals/earnings',[Referrals::class,'earnings']);
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
        Route::get('escrows',[Escrows::class,'index']);
        Route::get('escrows/{ref}/details',[Escrows::class,'details']);
        Route::get('escrows/pay_for_escrow/{ref}',[Escrows::class,'doPayment']);
        Route::post('complete-escrow',[Escrows::class,'doComplete']);
        /*=================== PAYOUT ROUTES =========================*/
        Route::get('transfers',[\App\Http\Controllers\Web\User\Payouts::class,'index']);
        Route::post('new_transfer',[\App\Http\Controllers\Web\User\Payouts::class,'authenticateTransfer']);
        Route::get('get_beneficiary/{id}',[\App\Http\Controllers\Web\User\Payouts::class,'getBeneficiaryId']);
        Route::get('transfers/{ref}/details',[\App\Http\Controllers\Web\User\Payouts::class,'payoutDetails'])
            ->where('ref','[A-Za-z0-9_]+');
        /*=================== MERCHANTS LIST ROUTES =========================*/
        Route::get('merchants',[Merchants::class,'index']);
        Route::get('merchant/{ref}/details',[Merchants::class,'details'])
            ->where('ref','[A-Za-z0-9_]+');
        Route::post('merchant/send-money',[Merchants::class,'doSendMoney']);

        //LOGOUT Route
        Route::get('logout',[AuthController::class,'Logout']);
    });
    Route::middleware(['isVendor'])->prefix('merchant')->group(function (){
        Route::get('dashboard',[Dashboard::class,'index']);
        Route::post('dashboard/set_pin',[Dashboard::class,'setPin']);
        /*======================= BUSINESS ROUTE ==========================================*/
        Route::get('businesses',[Business::class,'index']);
        Route::get('business/create-business',[Business::class,'createBusiness']);
        Route::get('business/get_category_subcategory/{id}',[Business::class,'getSubcategoryOfCategory']);
        Route::post('add-business',[Business::class,'doCreation']);
        Route::post('remove-business',[Business::class,'doRemove']);
        Route::get('business/{ref}',[Business::class,'businessDetail']);
        Route::post('business/logo_change/{ref}',[Business::class,'updateLogo']);
        Route::get('business/{ref}/verify',[Business::class,'verify']);
        Route::post('business/{ref}/verify',[Business::class,'doVerify']);
        /*======================= ESCROW ROUTE ==========================================*/
        Route::get('escrows',[Escrow::class,'index']);
        Route::get('new_escrow',[Escrow::class,'createEscrow']);
        Route::get('escrows/get_currency_charge/{currency}',[Escrow::class,'getCurrencyChargeInternal']);
        Route::post('add-escrow',[Escrow::class,'doCreation']);
        Route::get('escrows/{ref}/details',[Escrow::class,'details']);
        Route::get('escrows/notify_payer_pending_escrow_payment/{ref}',[Escrow::class,'notifyPayerAboutPendingPayments']);
        Route::post('add-escrow-delivery-service',[Escrow::class, 'doLogistics']);
        Route::post('cancel-escrow',[Escrow::class, 'doCancel']);
        Route::post('complete-escrow',[Escrow::class, 'doComplete']);
        Route::post('refund-escrow',[Escrow::class, 'doRefund']);
        /*======================= REFERRAL ROUTE ==========================================*/
        Route::get('/referrals',[Referral::class,'index']);
        Route::get('/referrals/earnings',[Referral::class,'earnings']);
        /*======================= ACTIVITY ROUTE ==========================================*/
        Route::get('/activities',[Activities::class,'index']);
        Route::get('/logins',[Activities::class,'logins']);
        /*======================= TRANSACTIONS ROUTE ==========================================*/
        Route::get('/transactions',[Transactions::class,'index']);
        Route::get('/transactions/{ref}/details',[Transactions::class,'details']);
        /*======================= CUSTOMERS ROUTE ==========================================*/
        Route::get('/customers',[Customers::class,'index']);
        Route::get('/customers/{id}/details',[Customers::class,'details']);
        /*======================= BENEFICIARY ROUTE ==========================================*/
        Route::get('beneficiary',[Beneficiary::class,'index']);
        Route::post('add-beneficiary',[Beneficiary::class,'addBeneficiary']);
        Route::post('remove-beneficiary/{id}',[Beneficiary::class,'removeBeneficiary']);
        /*=================== PAYOUT ROUTES =========================*/
        Route::get('transfers',[Payouts::class,'index']);
        Route::post('new_transfer',[Payouts::class,'authenticateTransfer']);
        Route::get('get_beneficiary/{id}',[Payouts::class,'getBeneficiaryId']);
        Route::get('transfers/{ref}/details',[Payouts::class,'payoutDetails'])
            ->where('ref','[A-Za-z0-9_]+');
        /*======================= PROFILE ROUTE ==========================================*/
        Route::get('/profile',[Profile::class,'index']);
        Route::get('/account_wallet',[AccountWallet::class,'index']);
        /*======================= ACCOUNT SETTING ROUTE ==========================================*/
        Route::get('/settings',[Settings::class,'index']);
        Route::post('settings/profile_change',[Settings::class,'updateProfilePic']);
        Route::post('settings/change_password',[Settings::class,'updatePassword']);
        Route::post('settings/update_profile',[Settings::class,'updateProfile']);
        Route::post('settings/change_account',[Settings::class,'switchAccount']);
        /*======================= PAYMENT LINK ROUTE ==========================================*/
        Route::get('/payment-link',[PaymentLink::class,'index']);
        Route::get('/payment-link/create-link',[PaymentLink::class,'linkSelection']);
        Route::get('/payment-link/create',[PaymentLink::class,'showCreateForm']);
        Route::post('/payment-link/add-payment-link',[PaymentLink::class,'doCreate']);
        Route::get('payment-link/{ref}/details',[PaymentLink::class,'details']);
        Route::get('payment-link/deactivate/{ref}',[PaymentLink::class,'deactivate']);
        Route::get('payment-link/activate/{ref}',[PaymentLink::class,'activate']);
        Route::get('payment-link/delete/{ref}',[PaymentLink::class,'delete']);
        /*======================= ACCOUNT WALLET ROUTE ==========================================*/
        Route::post('dashboard/convert_referral',[Dashboard::class,'convertReferral']);
        Route::post('dashboard/convert_specific_referral',[Dashboard::class,'convertSpecificReferral']);
        Route::post('dashboard/convert_to_ngn',[Dashboard::class,'convertToNGN']);
        Route::get('dashboard/get_specific_currency/{currency}',[Dashboard::class,'getSpecificCurrencyData']);
        /*======================= PAYMENTS ROUTE ==========================================*/
        Route::get('payments',[Payments::class,'index']);
        Route::get('payments/{ref}/details',[Payments::class,'details'])
            ->where('ref','[A-Za-z0-9_]+');
        /*======================= MERCHANT VERIFICATION =========================================*/
        Route::get('more',[MoreActions::class,'index']);
        Route::get('documents/verify',[Documents::class,'index']);
        Route::get('documents/get-document-type-id/{id}',[Documents::class,'getDocumentTypeId'])
            ->whereNumber('id');
        Route::post('documents/verify',[Documents::class,'verifyAccount']);
        Route::get('documents/documents',[MoreActions::class,'index']);
        Route::get('documents/error',[MoreActions::class,'index']);
        //LOGOUT Route
        Route::get('logout',[AuthController::class,'Logout']);
    });
});
