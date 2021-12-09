<?php
namespace  App\Custom;
use Illuminate\Support\Facades\Http;

/**
 * Class FlutterWave
 * @package App\Custom
 */
class FlutterWave{
    private $pubKey;
    private $priKey;
    private $encKey;
    private $url;

    /**
     * FlutterWave constructor.
     */
    public function __construct()
    {
        $flutterPack = config('constant.flutter_api.isLive');
        $url1 = config('constant.flutter_api.url1');
        $url2 = config('constant.flutter_api.url1');
        switch ($flutterPack){
            case 1:
                $pubKey = config('constant.flutter_api.live.pub_key');
                $priKey = config('constant.flutter_api.live.pri_key');
                $encKey = config('constant.flutter_api.live.enc_key');
                break;
            default:
                $pubKey = config('constant.flutter_api.test.pub_key');
                $priKey = config('constant.flutter_api.test.pri_key');
                $encKey = config('constant.flutter_api.live.enc_key');
                break;
        }
        $this->priKey = $priKey;
        $this->encKey = $encKey;
        $this->pubKey = $pubKey;
        $this->url    = $url1;
    }
    public function returnPublicKey(){
        return $this->pubKey;
    }
    public function fetchBanks($country){
        return Http::withToken($this->priKey,'Bearer')->get($this->url.'banks/'.$country);
    }
    public function chargeNgnAccount($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'charges?type=debit_ng_account',$data);
    }
    public function validateCharge($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'validate-charge',$data);
    }
    public function createBeneficiary($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'beneficiaries',$data);
    }
    public function removeBeneficiary($id){
        return Http::withToken($this->priKey,'Bearer')->delete($this->url.'beneficiaries/'.$id);
    }
    public function initiatePayment($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'payments',$data);
    }
    public function verifyTransactionId($trans_id){
        return Http::withToken($this->priKey,'Bearer')->get($this->url.'transactions/'.$trans_id.'/verify');
    }
    public function verifyTransactionRef($data){
        $data['SECKEY']=$this->priKey;
        return Http::post('https://api.ravepay.co/flwv3-pug/getpaidx/api/v2/verify',$data);
    }
    public function createTransfer($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'transfers',$data);
    }
    public function getTransferCharge($amount,$currency,$type){
        return Http::withToken($this->priKey,'Bearer')
            ->get($this->url.'transfers/fee?amount='.$amount.'&currency='.$currency.'&type='.$type);
    }
    public function getTransferId($trans_id){
        return Http::withToken($this->priKey,'Bearer')->get($this->url.'transfers/'.$trans_id);
    }
    public function verifyBvn($bvn){
        return Http::withToken($this->priKey,'Bearer')->get($this->url.'kyc/bvns/'.$bvn);
    }
    public function createVirtualAccount($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'virtual-account-numbers',$data);
    }
    public function createPlan($data){
        return Http::withToken($this->priKey,'Bearer')->post($this->url.'payment-plans',$data);
    }
}
