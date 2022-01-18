<?php
namespace App\Custom;

use App\Models\BusinessApiPayment;
use App\Models\BusinessCategory;
use App\Models\Businesses;
use App\Models\BusinessSubcategory;
use App\Models\Escrows;
use App\Models\FaqCategory;
use App\Models\MerchantPayouts;
use App\Models\PayBusinessTransactions;
use App\Models\PaymentLinkPayments;
use App\Models\Payouts;
use App\Models\SendMoney;
use App\Models\User;

/**
 *  custom checks for data in the database which will
 *  be globally used instead of using yhem in the controller
 */
class CustomChecks{

    public static function CategoryExists($id){
        $category = BusinessCategory::where('id',$id)->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function SubCategoryExists($id){
        $category = BusinessSubcategory::where('id',$id)->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function SubcategoryHasCategory($subid,$catid){
        $category = BusinessSubcategory::where('id',$subid)->where('category_id',$catid) ->where('status',1)->first();
        $dataCate = (!empty($category)) ? ['found'=>true,'data'=>$category] : $dataCate = ['found'=>false];
        return $dataCate;
    }
    public static function statusvar($st){
        switch ($st){
            case 1:
                $status = 'Active';
                break;
            default:
                $status = 'inactive';
                break;
        }
        return $status;
    }
    public static function verificationVar($vt){
        switch ($vt){
            case 1:
                $ver = 'Verified';
                break;
            default:
                $ver = 'Not Verified';
                break;
        }
        return $ver;
    }
    public static function chargeVar($ct){
        switch ($ct){
            case 1:
                $charge = 'Clients Pay';
                break;
            default :
                $charge = 'Business pay';
                break;
        }
        return $charge;
    }
    public static function categoryVar($ct){
        $category = BusinessCategory::where('id',$ct)->where('status',1)->first();
        return $category->category_name;
    }
    public static function subcategoryVar($ct){
        $category = BusinessSubcategory::where('id',$ct)->where('status',1)->first();
        return $category->subcategory_name;
    }
    public static function transactionTypeVar($tT){
        switch ($tT){
            case 2:
                $type = 'Payout';
                break;
            case 3:
                $type = 'Escrow';
                break;
            case 4:
                $type = 'Airtime';
                break;
            case 5:
                $type = 'Bill';
                break;
            case 6:
                $type = 'Remita';
                break;
            case 7:
                $type = 'Payment Link';
                break;
            default :
                $type = 'Funding';
                break;
        }
        return $type;
    }
    public function userId($id)
    {
        $user = User::where('id',$id)->first();
        $name = $user->name;
        return $name.' ('.$user->email.')';
    }
    public function businessId($id)
    {
        $business = Businesses::where('id',$id)->first();
        $name = $business->name;
        return $name;
    }
    public function numberOfPaymentLinkTransactions($reference)
    {
        $transactions = PaymentLinkPayments::where('reference',$reference)->get();
        $counts = $transactions->count();
        return $counts;
    }
    /** FUNCTION TO GET REVENUES GENERATED*/
    public function withdrawalRevenue($currency)
    {
        $merchantPayout = MerchantPayouts::where('currency',$currency)->where('status',1)->count();
        $merchantPayoutCharge = $merchantPayout*10;
        $userPayout = Payouts::where('currency',$currency)->where('status',1)->count();
        $userPayoutCharge = $userPayout*10;
        $revenue = $merchantPayoutCharge+$userPayoutCharge;
        return $revenue;
    }
    public function sendMoneyRevenue($currency)
    {
        $systemCharge = SendMoney::where('paymentStatus',1)->where('currency',$currency)->sum('charge');
        $flutCharge = SendMoney::where('paymentStatus',1)->where('currency',$currency)->sum('flutCharge');
        $revenue = $systemCharge-$flutCharge;
        return $revenue;
    }
    public function paymentLinkPaymentRevenue($currency)
    {
        $systemCharge = PaymentLinkPayments::where('paymentStatus',1)->where('currency',$currency)->sum('charge');
        $flutCharge = PaymentLinkPayments::where('paymentStatus',1)->where('currency',$currency)->sum('flutCharge');
        $revenue = $systemCharge-$flutCharge;
        return $revenue;
    }
    public function escrowRevenue($currency)
    {
        $systemCharge = Escrows::where('status',1)->where('currency',$currency)->sum('charge');
        $revenue = $systemCharge;
        return $revenue;
    }
    public function payBusinessRevenue($currency)
    {
        $systemCharge = PayBusinessTransactions::where('status',1)->where('currency',$currency)->sum('charge');
        $revenue = $systemCharge;
        return $revenue;
    }
    public function businessApiPayments($currency)
    {
        $systemCharge = BusinessApiPayment::where('paymentStatus',1)->where('currency',$currency)->sum('charge');
        $flutCharge = BusinessApiPayment::where('paymentStatus',1)->where('currency',$currency)->sum('flutCharge');
        $revenue = $systemCharge-$flutCharge;
        return $revenue;
    }
    public function totalRevenue($currency)
    {
        $escrow = $this->escrowRevenue($currency);
        $withdrawal = $this->withdrawalRevenue($currency);
        $sendMoney = $this->sendMoneyRevenue($currency);
        $paymentLink = $this->paymentLinkPaymentRevenue($currency);
        $payBusiness = $this->payBusinessRevenue($currency);
        $businessApi = $this->businessApiPayments($currency);

        $total = $escrow+$withdrawal+$sendMoney+$paymentLink+$payBusiness+$businessApi;
        return $total;
    }
    /**CUSTOM CHECKS CONTINUE */
    public function getFaqCategory($id)
    {
        $category = FaqCategory::where('id',$id)->first();
        $name = $category->category_name;
        return $name;
    }
    public function getBusinessCategory($id)
    {
        $category = BusinessCategory::where('id',$id)->first();
        $name = $category->category_name;
        return $name;
    }
}
