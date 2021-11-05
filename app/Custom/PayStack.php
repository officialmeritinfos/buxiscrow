<?php
namespace App\Custom;
use Illuminate\Support\Facades\Http;

/**
 * Class PayStack
 * @package App\Custom
 */
class PayStack{
    private $pubKey;
    private $priKey;
    private $encKey;
    private $url;

    /**
     * PayStack constructor.
     */
    public function __construct(){
        $paystackPack = config('constant.paystack_api.isLive');
        $url1 = config('constant.paystack_api.url1');
        $url2 = config('constant.paystack_api.url1');
        switch ($paystackPack){
            case 1:
                $pubKey = config('constant.paystack_api.live.pub_key');
                $priKey = config('constant.paystack_api.live.pri_key');
                $encKey = config('constant.paystack_api.live.enc_key');
                break;
            default:
                $pubKey = config('constant.paystack_api.test.pub_key');
                $priKey = config('constant.paystack_api.test.pri_key');
                $encKey = config('constant.paystack_api.live.enc_key');
                break;
        }
        $this->priKey = $priKey;
        $this->encKey = $encKey;
        $this->pubKey = $pubKey;
        $this->url    = $url1;
    }
    public function fetchBanks($currency){
        return Http::withToken($this->priKey,'Bearer')->get($this->url.'bank?currency='.$currency);
    }
}
