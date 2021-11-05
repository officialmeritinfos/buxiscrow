<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\MerchantBalances;
use App\Models\Transactions;
use App\Models\UserBalances;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class Dashboard extends BaseController
{
    /**
     * @param Request $request
     */
    public function index(Request $request){
        $user = Auth::user();
    }

    /**
     * @param $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBalance($currency){
        $user = Auth::user();
        $balances = UserBalances::where('user',$user->id)->where('currency',strtoupper($currency))->first();
        $dataBalance = [
            'availableBalance'=>$balances->availableBalance,'transactionLimit'=>$balances->TransactionLimit,
            'accountLimit'=>$balances->AccountLimit,'referralBalance'=>$balances->referralBalance
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
            'country'=>$user->country,'accountType'=>'user','accountCurrency'=>$user->majorCurrency,'photo'=>$user->photo
        ];
        return $this->sendResponse($dataUser,'retrieval successful');
    }

    /**
     * @param $currency
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccountlimit($currency){
        $user = Auth::user();
        $balances = UserBalances::where('user',$user->id)->where('currency',strtoupper($currency))->first();
        $dataLimit = ['accountLimit'=>$balances->AccountLimit,'transactionLimit'=>$balances->TransactionLimit ];
        return $this->sendResponse($dataLimit,'retrieval successful');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * get last five transactions carried out by user
     */
    public function getLastFiveTransactions(){
        $user = Auth::user();
        $dataTransaction=[];
        $transactions = Transactions::where('user',$user->id)->orderBy('id','desc')->limit(5)->get();
        foreach ($transactions as $transaction){
            switch ($transaction->transactionType){
                case 1:
                    $types = 'incoming';
                    break;
                case 2:
                    $types = 'outgoing';
                    break;
                case 3:
                    $types = 'invoice';
                    break;
            }
            $dataTransactions = [
                'transactionRef'=>$transaction->transactionRef,
                'currency'=>$transaction->currency,
                'amount'=>$transaction->amount,
                'type' =>$types,
            ];
            array_push($dataTransaction,$dataTransactions);
        }
        return $this->sendResponse($dataTransaction,'retrieval successful');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * get all transactions carried out by user
     */
    public function getUserTransactions(){
        $user = Auth::user();
        $dataTransaction=[];
        $transactions = Transactions::where('user',$user->id)->orderBy('id','desc')->get();
        foreach ($transactions as $transaction){
            switch ($transaction->transactionType){
                case 1:
                    $types = 'incoming';
                    break;
                case 2:
                    $types = 'outgoing';
                    break;
                case 3:
                    $types = 'invoice';
                    break;
            }
            $dataTransactions = [
                'transactionRef'=>$transaction->transactionRef,
                'currency'=>$transaction->currency,
                'amount'=>$transaction->amount,
                'type' =>$types,
            ];
            array_push($dataTransaction,$dataTransactions);
        }
        return $this->sendResponse($dataTransaction,'retrieval successful');
    }
    public function getTransactionDetails($id){
        $user = Auth::user();
        $transactions = Transactions::where('user',$user->id)->where('id',$id)->first();
        if (empty($transactions)){
            return $this->sendError('Transaction not found',['error'=>'Invalid transaction'],'404','Not found');
        }
        switch ($transactions->status){
            case 1:
                $status = 'successful';
                break;
            case 2:
                $status = 'pending';
                break;
            case 3:
                $status = 'cancelled';
                break;
        }
        if ($transactions->invoiceRef != null){
            switch ($transactions->paymentStatus){
                case 1:
                    $pstatus = 'successful';
                    break;
                case 2:
                    $pstatus = 'pending';
                    break;
                case 3:
                    $pstatus = 'cancelled';
                    break;
            }
            $transactions['paymentStatus']=$pstatus;
        }
        switch ($transactions->transactionType){
            case 1:
                $types = 'incoming';
                Arr::except($transactions,['withdrawalRef']);
                Arr::except($transactions,['invoiceRef']);
                Arr::except($transactions,['paymentStatus']);
                break;
            case 2:
                $types = 'outgoing';
                Arr::except($transactions,['paymentStatus']);
                Arr::except($transactions,['invoiceRef']);
                break;
            case 3:
                $types = 'invoice';
                Arr::except($transactions,['withdrawalRef']);
                break;
        }
        $transactions['user']=$user->name;
        $transactions['transactionType']=$types;
        $transactions['status']=$status;
        return $this->sendResponse($transactions,'retrieval successful');
    }
    public function getBusinesses(){
        $businesses = Businesses::where('status','=',1)->orderBy('isVerified','asc')->orderBy('created_at','desc')->get();
        $businessData = [];
        if (count($businesses)<1){
            return $this->sendError('No data found',['error'=>'No business found'],'404','Not found');
        }
        foreach ($businesses as $business){
            $dataBusiness = ['name'=>$business->name,'id'=>$business->id,'ref'=>$business->businessRef];
            array_push($businessData,$dataBusiness);
        }
        return $this->sendResponse($businessData,'retrieval successful');
    }
}
