<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Custom\RandomString;
use App\Http\Controllers\Api\BaseController;
use App\Models\Businesses;
use App\Models\CurrencyAccepted;
use App\Models\GeneralSettings;
use App\Models\IntervalType;
use App\Models\PaymentLinkPayments;
use App\Models\PaymentLinks;
use App\Models\PaymentLinkSubscriptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class PaymentLink extends BaseController
{
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $links = PaymentLinks::where('merchant',$user->id)->paginate(15);
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Payment Links','slogan'=>'- Making safer transactions','user'=>$user,
            'links'=>$links
        ];
        return view('dashboard.merchant.payment_links',$dataView);
    }
    public function linkSelection(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Select Payment Link Type','slogan'=>'- Making safer transactions','user'=>$user
        ];
        return view('dashboard.merchant.select_link_type',$dataView);
    }
    public function showCreateForm(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $type = $request->get('type');
        $currencies = CurrencyAccepted::where('status',1)->get();
        $businesses = Businesses::where('merchant',$user->id)->where('status',1)->get();
        $intervals = IntervalType::where('status',1)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Create Payment Link','slogan'=>'- Making safer transactions','user'=>$user,
            'type'=>$type,'currencies'=>$currencies,'businesses'=>$businesses,'intervals'=>$intervals
        ];
        return view('dashboard.merchant.create_link',$dataView);
    }
    public function doCreate(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $code = new RandomString(5);
        $validator = Validator::make($request->all(),
            [
                'title' => ['bail','required','string'],
                'description' => ['bail','required','string'],
                'currency' => ['bail','nullable','alpha','required_with:amount'],
                'amount' => ['bail','nullable','string'],
                'who_pays_charge' => ['nullable', 'bail','integer',Rule::requiredIf($request->input('input_type'),'!=','3')],
                'link_type' => ['bail','required','numeric','integer'],
                'store' => ['bail','nullable', 'numeric','integer',Rule::exists('business','id')->where(function($query) use ($request){
                    return $query->where('merchant',$request->user()->id);
                })],
                'redirect_url' => ['bail','nullable','numeric','integer'],
                'email' => ['bail','nullable','email'],
                'phone' => ['bail','nullable','string'],
                'charge_interval' => ['bail','nullable','required_with:frequency'],
                'frequency' => ['bail','nullable'],
            ],
            ['required'  =>':attribute is required'],
            ['who_pays_charge'   =>'Who Pays Charge',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422',
                'Validation Failed');
        }
        $input = $request->input();
        $reference = $code->randomStr().date('dmYhis').mt_rand();
        //check if the business selected belongs to the merchant
        if (!empty($input['store'])){
            $businessExists = Businesses::where('merchant',$user->id)->where('id',$input['store'])->first();
            if (empty($businessExists)){
                return $this->sendError('Error validation',['error'=>'Invalid Store selected'],
                    '422','Validation Failed');
            }
        }
        //check if the currency selected is supported
        if (!empty($input['currency'])){
            $currencyExists = CurrencyAccepted::where('code',$input['currency'])->where('status',1)->first();
            if (empty($currencyExists)){
                return $this->sendError('Error validation',['error'=>'Unsupported currency selected'],
                    '422','Validation Failed');
            }
        }
        //check if the interval selected is supported
        if (!empty($input['charge_interval'])){
            $intervalExists = IntervalType::where('id',$input['charge_interval'])->where('status',1)->first();
            if (empty($intervalExists)){
                return $this->sendError('Error validation',['error'=>'Unsupported payment interval selected'],
                    '422','Validation Failed');
            }
        }
        $dataLink = [
            'merchant'=>$user->id,'business'=>$input['store'],'reference'=>$reference,'type'=>$input['link_type'],
            'title'=>$input['title'],'description'=>$input['description'],'amount'=>$input['amount'],'currency'=>$input['currency'],
            'redirect_url'=>$input['redirect_url'],'status'=>1,'whoPays'=>$input['who_pays_charge'],'intervals'=>$input['charge_interval'],
            'number_charge'=>$input['frequency']
        ];
        $add = PaymentLinks::create($dataLink);
        if (!empty($add)){
            $success['added']=true;
            return $this->sendResponse($success, 'Link Created');
        }
    }
    public function details($ref){
        $ref = $ref;
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $paymentLink = PaymentLinks::where('reference',$ref)->where('merchant',$user->id)->first();
        if (empty($paymentLink)){
            return back()->with('error','You lack access to view this page');
        }
        if ($paymentLink->type == 2){
            $payments = PaymentLinkSubscriptions::where('merchant',$user->id)->where('reference',$paymentLink->reference)->get();
        }else{
            $payments = PaymentLinkPayments::where('merchant',$user->id)->where('reference',$paymentLink->reference)->get();
        }
        if (!empty($paymentLink->business)){
            $business = Businesses::where('id',$paymentLink->business)->first();
            $businessName = $business->name;
        }else{
            $businessName ='';
        }
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Payment Links','slogan'=>'- Making safer transactions',
            'user'=>$user,'link'=>$paymentLink,'payments'=>$payments,'business'=>$businessName
        ];
        return view('dashboard.merchant.payment_link_details',$dataView);
    }
    public function deactivate($ref){
        $ref = $ref;
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $paymentLink = PaymentLinks::where('reference',$ref)->where('merchant',$user->id)->first();
        if (empty($paymentLink)){
            return $this->sendError('Error validation',['error'=>'Link not found'],'422',
                'Validation Failed');
        }
        $dataLink =[
            'status'=>2
        ];
        $update = PaymentLinks::where('id',$paymentLink->id)->update($dataLink);
        if ($update){
            $success['updated']=true;
            return $this->sendResponse($success, 'Link Deactivated');
        }
        return $this->sendError('Error validation',['error'=>'Error deactivating'],'422',
            'Validation Failed');
    }
    public function activate($ref){
        $ref = $ref;
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $paymentLink = PaymentLinks::where('reference',$ref)->where('merchant',$user->id)->first();
        if (empty($paymentLink)){
            return $this->sendError('Error validation',['error'=>'Link not found'],'422',
                'Validation Failed');
        }
        $dataLink =[
            'status'=>1
        ];
        $update = PaymentLinks::where('id',$paymentLink->id)->update($dataLink);
        if ($update){
            $success['updated']=true;
            return $this->sendResponse($success, 'Link Activated');
        }
        return $this->sendError('Error validation',['error'=>'Error Activating'],'422',
            'Validation Failed');
    }
    public function delete($ref){
        $ref = $ref;
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();

        $paymentLink = PaymentLinks::where('reference',$ref)->where('merchant',$user->id)->first();
        if (empty($paymentLink)){
            return $this->sendError('Error validation',['error'=>'Link not found'],'422',
                'Validation Failed');
        }
        $deleted = PaymentLinks::where('id',$paymentLink->id)->delete();
        if ($deleted){
            $success['updated']=true;
            return $this->sendResponse($success, 'Link deleted');
        }
        return $this->sendError('Error validation',['error'=>'Error Deleting'],'422',
            'Validation Failed');
    }
}
