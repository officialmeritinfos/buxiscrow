<?php
namespace App\Custom;

use Illuminate\Support\Facades\Http;

/**
 * Class Regular
 * @package App\Custom
 */
class Regular{
    /**
     * @var \Illuminate\Config\Repository|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public $ip_url;
    public $ip_api;

    /**
     * Regular constructor.
     */
    public function __construct(){
        $this->ip_url = config('constant.ipgeolocation.url');
        $this->ip_api = config('constant.ipgeolocation.api_key');
    }

    /**
     * @return \Illuminate\Http\Client\Response
     * @return only requested country
     */
    public function getUserCountry(){
        $response = Http::get($this->ip_url.'ipgeo?apiKey='.$this->ip_api);
        return $response;
    }
    public function getUserAgent(){
        $response = Http::get($this->ip_url.'user-agent?apiKey='.$this->ip_api);
        return $response;
    }
    public function getUserCountryUserAgent(){
        $response = Http::get($this->ip_url.'ipgeo?apiKey='.$this->ip_api.'&include=useragent');
        return $response;
    }
}

