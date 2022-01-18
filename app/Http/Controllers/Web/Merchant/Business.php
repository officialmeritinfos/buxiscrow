<?php

namespace App\Http\Controllers\Web\Merchant;

use App\Custom\CustomChecks;
use App\Custom\RandomString;
use App\Custom\Regular;
use App\Events\AccountActivity;
use App\Events\SendNotification;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\BusinessApiKey;
use App\Models\BusinessCategory;
use App\Models\BusinessCustomers;
use App\Models\BusinessDocuments;
use App\Models\BusinessDocumentTypes;
use App\Models\Businesses;
use App\Models\BusinessSubcategory;
use App\Models\BusinessType;
use App\Models\EscrowPayments;
use App\Models\Escrows;
use App\Models\GeneralSettings;
use App\Models\MerchantDocument;
use App\Models\Refunds;
use App\Models\User;
use App\Models\UserDocumentTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class Business extends BaseController
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $businesses = Businesses::where('merchant',$user->id)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Stores','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses
        ];
        return view('dashboard.merchant.businesses',$dataView);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function createBusiness(){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $businesses = Businesses::where('merchant',$user->id)->get();
        $businessCategories = BusinessCategory::where('status',1)->get();
        $businessTypes = BusinessType::where('status',1)->get();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Stores','slogan'=>'- Making safer transactions','user'=>$user,
            'businesses'=>$businesses,'categories'=>$businessCategories,'businessTypes'=>$businessTypes
        ];
        return view('dashboard.merchant.create_business',$dataView);
    }
    public function getSubcategoryOfCategory($id){
        $user=Auth::user();
        $subcategories = BusinessSubcategory::where('category_id',$id)->get();
        if (count($subcategories)<1){
            return $this->sendError('Fetch Error',['error'=>'No data found.'],
                '422','Fetch Failed');
        }
        $cateData = [];
        foreach ($subcategories as $subcategory) {
            $dataCate['id']=$subcategory->id;
            $dataCate['name']=$subcategory->subcategory_name;
            array_push($cateData,$dataCate);
        }
        return $this->sendResponse($cateData,'Subcategories fetched');
    }
    public function doCreation(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            [
                'name' => ['bail','required','string'], 'business_type' => ['bail','required','numeric','integer'], 'category' => ['bail','required','numeric','integer'],
                'subcategory' => ['bail','nullable','alpha_num'], 'phone' => ['bail','nullable','string'], 'email' => ['bail','nullable','email'],
                'country' => ['bail','required','string'], 'state' => ['bail','required','string'], 'city' => ['bail','required','string'],
                'zip' => ['bail','required','alpha_num'], 'address' => ['bail','required','string'], 'description' => ['bail','required','string'],
                'tags' => ['bail','required','string'],
            ],
            ['required'  =>':attribute is required'],
            ['business_type'   =>'Business type',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();
        //first check if the business is crypto
        $businessType = BusinessType::where('id',$input['business_type'])->where('status',1)->first();
        if ($businessType->count()<1){
            return $this->sendError('Validation Error',['error'=>'Invalid Business type'],
                '422','Creation Failed');
        }
        //check if the business name already exists
        $businesses = Businesses::where('name',$input['name'])->first();
        if (!empty($businesses)){
            return $this->sendError('Validation Error',['error'=>'Business name already taken. Is this an error? Please
            contact support.'],
                '422','Creation Failed');
        }
        $code = new RandomString('6');
        $reference = $generalSettings->merchantCode.$code->randomStr().time();
        $dataBusiness = [
            'name'=>$input['name'],'businessRef'=>$reference,'category'=>$input['category'],'subcategory'=>$input['subcategory'],
            'merchant'=>$user->id,'businessEmail'=>$input['email'],'businessPhone'=>$input['phone'],'businessCountry'=>$input['country'],
            'businessState'=>$input['state'],'businessCity'=>$input['city'],'businessAddress'=>$input['address'],'Zip'=>$input['zip'],
            'businessTag'=>$input['tags'],'businessDescription'=>$input['description'],'businessType'=>$input['business_type'],
            'isCrypto'=>$businessType->isCrypto
        ];
       $add = Businesses::create($dataBusiness);
       if (!empty($add)){
           $details = 'A new store with name <b>'.$input['name'].'</b> has been created on your account.' ;
           $dataActivity = ['merchant' => $user->id, 'activity' => 'Store creation', 'details' => $details,
               'agent_ip' => $request->ip()];
           event(new AccountActivity($user, $dataActivity));
           event(new SendNotification($user, $details, '3'));
           $success['created']=true;
           return $this->sendResponse($success, 'Store created');
       }
        return $this->sendError('Creation Error',['error'=>'An error occurred while creating your store'],
            '422','Creation Failed');
    }
    public function doRemove(Request $request){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $validator = Validator::make($request->all(),
            ['store_ref' => ['bail','required','string'], 'pin' => ['bail','required','digits:6','integer'],],
            ['required'  =>':attribute is required'],
            ['pin'   =>'Account Pin',]
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return $this->sendError('Error validation',['error'=>$validator->errors()->all()],'422','Validation Failed');
        }
        $input = $request->input();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$input['store_ref'])->first();
        if (empty($businessExists)){
            return $this->sendError('Deletion Error',['error'=>'Store does not belong to you.'],
                '422','Deletion Failed');
        }
        //check if business has escrow
        $hasEscrow = Escrows::where('business',$businessExists->id)->first();
        if (!empty($hasEscrow)){
            return $this->sendError('Deletion Error',['error'=>'A transaction has been carried out by this store.'],
                '422','Deletion Failed');
        }
        $deleted = Businesses::where('id',$businessExists->id)->delete();
        if (!$deleted){
            return $this->sendError('Deletion Error',['error'=>'An error occurred while deleting your store'],
                '422','Deletion Failed');
        }
        $success['removed']=true;
        return $this->sendResponse($success, 'Store removed');
    }
    public function businessDetail($ref){
        $generalSettings = GeneralSettings::where('id',1)->first();
        $user=Auth::user();
        $regular = new Regular();
        $checks = new CustomChecks();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found or does not belong to you.');
        }
        $category = $checks::categoryVar($businessExists->category);
        $subcategory = $checks::subcategoryVar($businessExists->subcategory);
        $businessType = BusinessType::where('id',$businessExists->businessType)->first();
        $escrows = Escrows::where('merchant',$user->id)->where('business',$businessExists->id)->get();
        $customers = BusinessCustomers::where('merchant',$user->id)->where('business',$businessExists->id)->get();
        $refunds = Refunds::where('business',$businessExists->id)->get();
        $escrowPayments = EscrowPayments::where('merchant',$user->id)
            ->where('business',$businessExists->id)->where('currency','NGN')
            ->where('paymentStatus',1)->sum('amountPaid');
        $escrowPaymentsUSD = EscrowPayments::where('merchant',$user->id)
            ->where('business',$businessExists->id)->where('currency','USD')
            ->where('paymentStatus',1)->sum('amountPaid');
        $escrowPaymentsPending = EscrowPayments::where('merchant',$user->id)
            ->where('business',$businessExists->id)->where('paymentStatus','!=', 1)
            ->where('currency','NGN')
            ->sum('amountPaid');
        $escrowPaymentsPendingUSD = EscrowPayments::where('merchant',$user->id)
            ->where('business',$businessExists->id)
            ->where('currency','USD')
            ->where('paymentStatus','!=', 1)->sum('amountPaid');
        $businessApiKeys = BusinessApiKey::where('merchant',$user->id)->where('business',$businessExists->id)->first();
        $dataView=[
            'web'=>$generalSettings,'pageName'=>'Store Data','slogan'=>'- Making safer transactions','user'=>$user,
            'business'=>$businessExists,'type'=>$businessType,'category'=>$category,'subcategory'=>$subcategory,
            'escrows'=>$escrows,'customers'=>$customers,'refunds'=>$refunds,
            'completed_payments'=>$regular->formatNumbers($escrowPayments),
            'completed_payments_usd'=>$regular->formatNumbers($escrowPaymentsUSD),
            'pending_payments'=> $regular->formatNumbers($escrowPaymentsPending),
            'pending_payments_usd'=> $regular->formatNumbers($escrowPaymentsPendingUSD),
            'apiKeys'=>$businessApiKeys
        ];
        return view('dashboard.merchant.business_details',$dataView);
    }
    public function updateLogo(Request $request,$ref)
    {
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            ['logo' => ['bail', 'required', 'mimes:jpg,png,jpeg', 'max:3000']],
            ['required' => ':attribute is required'],
            ['logo' => 'Business Logo']
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422',
                'Validation Failed');
        }
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return $this->sendError('Error validation', ['error' => 'Store not found'], '422',
                'Validation Failed');
        }
        $fileName = time() . '_' . $request->file('logo')->getClientOriginalName();
        $move = $request->file('logo')->move(public_path('merchant/photos/'), $fileName);
        if ($move) {
            $dataBusiness = ['logoUploaded' => 1, 'logo' => $fileName];
            $updated = Businesses::where('id', $businessExists->id)->update($dataBusiness);
            if (!empty($updated)) {
                $success['uploaded'] = true;
                return $this->sendResponse($success, 'Logo successfully updated');
            } else {
                return $this->sendError('File Error ', ['error' => 'An error occurred. Please try again or contact support'], '422', 'File Upload Fail');
            }
        } else {
            return $this->sendError('File Error ', ['error' => $move], '422', 'File Upload Fail');
        }
    }
    public function verify($ref){
        $generalSettings = GeneralSettings::where('id', 1)->first();
        $user = Auth::user();
        $documentsNeeded = BusinessDocumentTypes::where('country',$user->countryCode)->orWhere('country','all')->get();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return back()->with('error','Store not found or does not belong to you.');
        }
        $documents = BusinessDocuments::where('business',$businessExists->id)->where('merchant',$user->id)->first();
        $dataView = ['web' => $generalSettings, 'pageName' => 'Business Verification', 'slogan' => '- Making safer transactions',
            'user' => $user,'documents'=>$documentsNeeded,'business'=>$businessExists,'document'=>$documents];
        return view('dashboard.merchant.business_verification', $dataView);
    }
    public function doVerify(Request $request,$ref){
        $user = Auth::user();
        $validator = Validator::make($request->all(),
            [
                'certificate' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg','max:5000'],
                'proof_of_address' => ['bail', 'required', 'mimes:jpg,bmp,png,jpeg','max:5000'],
                'registration_type' => ['bail', 'required','numeric'],
                'tin' => ['bail', 'required_unless:registration_type,1','string'],
            ],
            ['required' => ':attribute is required'],
            ['proof_of_address' => 'Proof of Address','tin' => 'Tax ID or Employer ID','registration_type' => 'Type of Registration']
        )->stopOnFirstFailure(true);
        if ($validator->fails()) {
            return $this->sendError('Error validation', ['error' => $validator->errors()->all()], '422', 'Validation Failed');
        }
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$ref)->first();
        if (empty($businessExists)){
            return $this->sendError('Error validation', ['error' => 'Invalid Business submitted'],
                '422', 'Validation Failed');
        }
        if ($businessExists->isVerified ==4){
            return $this->sendError('Error validation', ['error' => 'Your business is currently being reviewed.
            Contact support if you have any questions'], '422', 'Validation Failed');
        }

        //move the certificate
        $certificate = $request->file('certificate')->hashName();
        $move_certificate = $request->file('certificate')->move(public_path('merchant/documents/'),$certificate);
        //move the proof of address
        $proof_of_address = $request->file('proof_of_address')->hashName();
        $move_proof_of_address = $request->file('proof_of_address')->move(public_path('merchant/documents/'),$proof_of_address);

        if ($move_certificate && $move_proof_of_address){
            $dataUserDocument = ['merchant'=>$user->id,
                'business'=>$businessExists->id ,'businessRef'=>$businessExists->businessRef,
                'certificate'=>$certificate,'proofAddress'=>$proof_of_address,'tin'=>$request->input('tin'),
                'businessRegType'=>$request->input('registration_type')];
            $addDocument = BusinessDocuments::create($dataUserDocument);
            if (!empty($addDocument)){
                $dataBusiness=['isVerified'=>4];
                Businesses::where('id', $businessExists->id)->update($dataBusiness);
                $details = 'Your ' . config('app.name') . ' verification documents for '.$businessExists->name.' has been submitted';
                $dataActivity = ['merchant' => $user->id, 'activity' => 'Business Verification submission',
                    'details' => $details, 'agent_ip' => $request->ip()];
                event(new AccountActivity($user, $dataActivity));
                $success['submitted'] = true;
                return $this->sendResponse($success, 'Verification document successfully submitted.
                You will be contacted if there is ever any need.');
            }else {
                return $this->sendError('File Error ', ['error' => 'An error occurred.
                Please try again or contact support'], '422', 'File Upload Fail');
            }
        } else {
            return $this->sendError('File Error ', ['error' => $move_certificate], '422', 'File Upload Fail');
        }
    }
    public function doGenerateApiKeys(Request $request)
    {
        $user = Auth::user();
        $webSettings = GeneralSettings::where('id',1)->first();
        $validator = Validator::make($request->all(),
            [
                'secret_key' => ['bail', 'required', 'string'],
                'ipn_url' => ['bail', 'nullable', 'url'],
                'allow_withdrawal' => ['bail', 'required','numeric'],
                'pin' => ['bail', 'required','numeric','digits:6','integer'],
                'store_ref' => ['bail', 'required','string'],
            ],
            ['required' => ':attribute is required'],
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$input['store_ref'])->first();
        if (empty($businessExists)){
            return back()->with('error','Store does not belong to you.');
        }
        //check if business has api key
        $hasApiKey = BusinessApiKey::where('business',$businessExists->id)->where('merchant',$user->id)->first();
        if (!empty($hasApiKey)) {
            return back()->with('error','API KEY has already been generated for this business. Please use the
            regenerate option before proceeding.');
        }
        //generating keys
        $secret_key = $webSettings->siteAbbr.'_SEC_'.time().mt_rand();
        $pub_key = $webSettings->siteAbbr.'_PUB_'.time().mt_rand();
        $dataKey=[
            'merchant'=>$user->id,
            'business'=>$businessExists->id,
            'secretKey'=>Crypt::encryptString($secret_key),
            'publicKey'=>$pub_key,
            'allowWithdrawal'=>$input['allow_withdrawal'],
            'hashKey'=>Crypt::encryptString($input['secret_key']),
            'ipn_url'=>$input['ipn_url']
        ];
        //create
        $create = BusinessApiKey::create($dataKey);
        if (!empty($create)) {
            return back()->with('success','Keys Generated');
        }
        return back()->with('error','Something went wrong. Try again or contact support.');
    }
    public function doReGenerateApiKeys(Request $request)
    {
        $user = Auth::user();
        $webSettings = GeneralSettings::where('id',1)->first();
        $validator = Validator::make($request->all(),
            [
                'secret_key' => ['bail', 'required', 'string'],
                'ipn_url' => ['bail', 'nullable', 'url'],
                'allow_withdrawal' => ['bail', 'required','numeric'],
                'pin' => ['bail', 'required','numeric','digits:6','integer'],
                'store_ref' => ['bail', 'required','string'],
            ],
            ['required' => ':attribute is required'],
        )->stopOnFirstFailure(true);
        if($validator->fails()){
            return back()->with('error',$validator->errors());
        }
        $input = $request->input();
        $businessExists = Businesses::where('merchant',$user->id)->where('businessRef',$input['store_ref'])->first();
        if (empty($businessExists)){
            return back()->with('error','Store does not belong to you.');
        }
        //check if business has api key
        $hasApiKey = BusinessApiKey::where('business',$businessExists->id)->where('merchant',$user->id)->first();
        if (empty($hasApiKey)) {
            return back()->with('error','API KEY has not been generated for this business. Please use the
            generate option before proceeding.');
        }
        //generating keys
        $secret_key = $webSettings->siteAbbr.'_SEC_'.time().mt_rand();
        $pub_key = $webSettings->siteAbbr.'_PUB_'.time().mt_rand();
        $dataKey=[
            'merchant'=>$user->id,
            'business'=>$businessExists->id,
            'secretKey'=>Crypt::encryptString($secret_key),
            'publicKey'=>$pub_key,
            'allowWithdrawal'=>$input['allow_withdrawal'],
            'hashKey'=>Crypt::encryptString($input['secret_key']),
            'ipn_url'=>$input['ipn_url']
        ];
        //create
        $create = BusinessApiKey::where('id',$hasApiKey->id)->update($dataKey);
        if (!empty($create)) {
            return back()->with('success','Keys Regenerated');
        }
        return back()->with('error','Something went wrong. Try again or contact support.');
    }
}
