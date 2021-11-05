<?php

namespace App\Http\Controllers\Api\Merchant;

use App\Custom\CustomChecks;
use App\Custom\RandomString;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Businesses;
use App\Models\GeneralSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Business extends BaseController
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function createBusiness(Request $request){
        $validator = Validator::make($request->all(),
            ['name'=>'required|unique:business,name','email'=>'required|email|unique:business,businessEmail', 'phone'=>'required|unique:business,businessPhone',
            'country'=>'required','state'=>'required','city'=>'required','zip'=>'required', 'address'=>'required|string', 'tag'=>'nullable', 'description'=>'nullable',
            'category'=>['required','integer', Rule::exists('business_category','id')->where(function ($query){return $query->where('status',1);})],
            'subcategory'=>['required','integer', Rule::exists('business_subcategory','id')->where(function ($query){return $query->where('status',1);})]
            ],['required'=>':attribute is required'],
            ['name'=>'Business Name', 'email'=>'Business Email', 'phone'=>'Business Phone number', 'category'=>'Business Category',
                'subcategory'=>'Business Subcategory', 'tag'=>'Business tags', 'description'=>'Business Description',
                'country'=>'Business country of domicile', 'state'=>'Business State of domicile', 'city'=>'Business City of Domicile',
                'zip'=>'Business address/regional postal code'
            ]
        );
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()],'422','Validation Failed');
        }
        $randomString = new RandomString(3);
        $generalSettings = GeneralSettings::find(1);
        $businessRef = $generalSettings->merchantCode.'_'.$randomString->randomNum().time();
        //lets check if the subcategory selected exists within the given category
        $check = new CustomChecks();
        $subcategoryExists = $check::SubcategoryHasCategory($request->subcategory,$request->category);
        if ($subcategoryExists['found']==false){
            return $this->sendError('No data found',['error'=>'No subcategory found'],'404','Not found');
        }
        $user = Auth::user();
        $dataBusiness = [
            'name'=>$request->name, 'businessRef'=>$businessRef, 'category'=>$request->category,'merchant'=>$user->id,'businessEmail'=>$request->email,
            'businessPhone'=>$request->phone,'subcategory'=>$request->subcategory,'businessCountry'=>$request->country, 'businessCity'=>$request->city, 'businessState'=>$request->state,
            'businessAddress'=>$request->address, 'Zip'=>$request->zip, 'businessTag'=>$request->tag, 'businessDescription'=>$request->description,
        ];
        $created = Businesses::create($dataBusiness);
        if (!empty($created)){
            $created = json_decode($created,true);
            $data=Arr::only($created,['name','businessEmail','businessRef']);
            return $this->sendResponse($data,'creation successful');
        }
    }
    /**
     * @param $ref
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBusinessByRef($ref){
        $user = Auth::user();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return $this->sendError('No data found',['error'=>'No Business found'],'404','Not found');
        }
        $check = new CustomChecks();
        $dataBiz= json_decode($businessExists,true);

        $dataBiz['isVerified']=$check::verificationVar($businessExists->isVerified);
        $dataBiz['status']=$check::statusvar($businessExists->status);
        $dataBiz['chargeType']=$check::chargeVar($businessExists->chargeType);
        $dataBiz['category']=$check::categoryVar($businessExists->category);
        $dataBiz['subcategory']=$check::subcategoryVar($businessExists->subcategory);
        $dataBiz['merchant']=$user->name;
        $dataBiz=Arr::except($dataBiz,['deleted_at','updated_at']);
        return $this->sendResponse($dataBiz,'retrieval successful');
    }
    public function getBusinesses(){
        $user = Auth::user();
        $businesses = Businesses::where('merchant',$user->id)->get();
        if (count($businesses)<1){
            return $this->sendError('No data found',['error'=>'No businesses found'],'404','Not found');
        }
        $businessData =[];
        foreach ($businesses as $business) {
            $dataBusiness = ['name'=>$business->name,'businessRef'=>$business->businessRef,'id'=>$business->id];
            array_push($businessData,$dataBusiness);
        }
        return $this->sendResponse($businessData,'retrieval successful');
    }
}
