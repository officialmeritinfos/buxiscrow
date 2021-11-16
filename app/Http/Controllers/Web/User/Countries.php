<?php

namespace App\Http\Controllers\Web\User;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Cities;
use App\Models\Country;
use App\Models\States;
use Illuminate\Http\Request;

class Countries extends BaseController
{
    public function getCountries(){
        $countries = Country::where('region','Africa')->get();
    }
    public function returnCountries(){
        $countries = Country::where('region','Africa')->get();
        if (count($countries)>0) {
            $stateData = [];
            foreach ($countries as $country) {
                $dataState['name'] = $country->name;
                $dataState['code'] = $country->iso2;
                array_push($stateData, $dataState);
            }
            return $this->sendResponse($stateData, 'Countries fetched');
        }
        return $this->sendError('Error validation',['error'=>'No data found or we do not support this region yet'],'422','Validation Failed');
    }
    public function getCountryStates($country){
        $states = States::where('country_code',strtoupper($country))->orderBy('name','asc')->get();
        if (count($states)>0) {
            $stateData = [];
            foreach ($states as $state) {
                $dataState['name'] = $state->name;
                $dataState['code'] = $state->id;
                array_push($stateData, $dataState);
            }
            return $this->sendResponse($stateData, 'States fetched');
        }
        return $this->sendError('Error validation',['error'=>'No data found or we do not support this region yet'],'422','Validation Failed');
    }
    public function getStateCities($state){
        $cities = Cities::where('state_id',$state)->orderBy('name','asc')->get();
        if (count($cities)>0) {
            $cityData = [];
            foreach ($cities as $city) {
                $dataCity['name'] = $city->name;
                array_push($cityData, $dataCity);
            }
            return $this->sendResponse($cityData, 'City fetched');
        }
        return $this->sendError('Error validation',['error'=>'No data found or we do not support this region yet'],'422','Validation Failed');
    }
}
