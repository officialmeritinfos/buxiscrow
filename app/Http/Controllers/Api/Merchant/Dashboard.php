<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Custom\CustomChecks;
use App\Custom\Regular;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BusinessCategory;
use App\Models\Businesses;
use App\Models\BusinessSubcategory;
use App\Models\MerchantBalances;
use App\Models\Transactions;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseController
{
    public function getBalance($currency){
        $user = Auth::user();
        $balances = MerchantBalances::where('merchant',$user->id)->where('currency',strtoupper($currency))->first();
        $dataBalance = [
            'availableBalance'=>$balances->availableBalance,'transactionLimit'=>$balances->TransactionLimit,
            'accountLimit'=>$balances->AccountLimit,'referralBalance'=>$balances->referralBalance,
            'frozenBalance'=>$balances->frozenBalance,'balanceRef'=>$balances->balanceRef
        ];
        return $this->sendResponse($dataBalance,'Balance Retrieved successfully');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUserProfile(){
        $user = Auth::user();
        $dataUser = [
            'name'=>$user->name,'email'=>$user->email,'username'=>$user->username,'phone'=>$user->phone,
            'country'=>$user->country,'accountType'=>'Merchant','accountCurrency'=>$user->majorCurrency,'photo'=>$user->photo
        ];
        return $this->sendResponse($dataUser,'retrieval successful');
    }

    /**
     * @param $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountlimit($currency){
        $user = Auth::user();
        $balances = MerchantBalances::where('merchant',$user->id)->where('currency',strtoupper($currency))->first();
        $dataLimit = ['accountLimit'=>$balances->AccountLimit,'transactionLimit'=>$balances->TransactionLimit ];

        return $this->sendResponse($dataLimit,'retrieval successful');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCategories(){
        $categories = BusinessCategory::where('status',1)->get();
        $categoryData = [];
        if (count($categories)<1){
            return $this->sendError('No data found',['error'=>'No category found'],'404','Not found');
        }
        foreach ($categories as $category){
            $dataCategory = ['name'=>$category->category_name,'id'=>$category->id];
            array_push($categoryData,$dataCategory);
        }
        return $this->sendResponse($categoryData,'retrieval successful');
    }
    public function getSubcategories($cateId){
        $checks = new CustomChecks();
        $categoryExists = $checks::CategoryExists($cateId);
        if ($categoryExists['found']==false){
            return $this->sendError('No data found',['error'=>'No category found'],'404','Not found');
        }
        $categoryData = [];
        $subcategories = BusinessSubcategory::where('status',1)->where('category_id',$cateId)->get();
        if (count($subcategories)<1){
            return $this->sendError('No data found',['error'=>'No subcategory found'],'404','Not found');
        }
        foreach ($subcategories as $subcategory) {
            $dataCategory = ['name'=>$subcategory->subcategory_name,'id'=>$subcategory->id];
            array_push($categoryData,$dataCategory);
        }
        return $this->sendResponse($categoryData,'retrieval successful');
    }

}
