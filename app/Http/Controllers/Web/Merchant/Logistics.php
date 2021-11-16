<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\DeliveryService;
use App\Models\States;
use Illuminate\Http\Request;

class Logistics extends BaseController
{
    public function getDeliverySerices($country,$state,$city){
        //get country
        $country = Country::where('iso2',$country)->first();
        $state = States::where('id',$state)->first();
        $deliveries = DeliveryService::join('delivery_locations','delivery_services.id','=','delivery_locations.logisticsId')
            ->where('delivery_locations.countryCode',$country->iso2)
            ->where('delivery_locations.State',$state->name)
            ->orWhere('delivery_locations.City',$city)
            ->where(function ($query){
                $query->where('delivery_services.status',1);
            })
            ->orderBy('name','asc')->get();
        if (count($deliveries)>0) {
            $logData = [];
            foreach ($deliveries as $delivery) {
                $dataLog['name'] = $delivery->name;
                $dataLog['code'] = $delivery->id;
                $dataLog['rate'] = $delivery->Charge;
                $dataLog['currency'] = $delivery->currency;
                $dataLog['city'] = $delivery->City;
                array_push($logData, $dataLog);
            }
            return $this->sendResponse($logData, 'Logistics company fetched');
        }
        return $this->sendError('Error validation',['error'=>'No data found or we do not support this region yet'],'422','Validation Failed');
    }
}
