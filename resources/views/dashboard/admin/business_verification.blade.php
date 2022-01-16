@include('dashboard.admin.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('admin/dashboard')}}" class="d-flex">
                    <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                        <path d="M0 0h24v24H0V0z" fill="none"/><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3zm5 15h-2v-6H9v6H7v-7.81l5-4.5 5 4.5V18z"/>
                        <path d="M7 10.19V18h2v-6h6v6h2v-7.81l-5-4.5z" opacity=".3"/>
                    </svg>
                    <span class="breadcrumb-icon"> Home</span></a>
            </li>
            <li class="breadcrumb-item active"><a href="#">{{$pageName}}</a></li>
        </ol>
    </div>
</div>
<!--End Page header-->
<div class="card col-md-8 mx-auto text-center" id="tabs-style3">
    <div class="card-header">
        <div class="card-title">
            {{$pageName}}
        </div>
    </div>
    <div class="card-body">
        @if($business->isVerified == 2)
            <p class="text-center text-indigo">Fill the form below to submit your business for verification</p>
            <form method="Post" action="{{url('admin/business/'.$business->businessRef.'/verify')}}" id="businessVerificationForm"
                  enctype="multipart/form-data">
                @csrf
                <div class="">
                    <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Business Registration</label>
                        <select  class="form-control" id="exampleInputEmail1" name="registration_type">
                            <option value="">Select Type</option>
                            <option value="1">Business Name</option>
                            <option value="2">Limited Liability Company (LLC)</option>
                            <option value="3">Cooperative Society</option>
                            <option value="4"> Partnership</option>
                        </select>
                    </div>
                    @foreach($documents as $document)
                        @if($document->type ==2)
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">{{$document->name}}
                                    <i class=" fa fa-info-circle" data-toggle="tooltip" title="{{$document->note}}"></i>
                                </label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="{{$document->code}}"
                                           accept="image/*" id="ImageBrowse" {{ ($document->isRequired == 1) ? 'required':'' }} >
                                    <label class="custom-file-label">{{$document->name}}</label>
                                </div>
                            </div>
                        @endif
                    @endforeach
                    @foreach($documents as $doc)
                        @if($doc->type ==1)
                            <div class="form-group">
                                <label for="exampleInputPassword1" class="form-label">{{$doc->name}}
                                    <i class=" fa fa-info-circle" data-toggle="tooltip" title="{{$doc->note}}"></i>
                                </label>
                                <input type="text" class="form-control" id="exampleInputPassword1"
                                       name="{{$doc->code}}">
                            </div>
                        @endif
                    @endforeach
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-4 mb-0" id="submit_business_verify">Submit</button>
                </div>
            </form>
        @endif
        @if($business->isVerified ==1)
            <p class="text-success">
                Your account has been verified — this means you can make higher payments until
                you reach the account limit designated for your account.
                <br>
            </p>
            <div class="row w-100">
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Certificate of Registration</h5>
                        </div>
                        <img  src="{{asset('merchant/documents/'.$document->certificate)}}"
                              alt="image" class="img-height" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Proof Of Address</h5>
                        </div>
                        <img  src="{{asset('merchant/documents/'.$document->proofAddress)}}"
                              alt="image" class="img-height" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">TIN/EIN</h5>
                        </div>
                        <p class="font-weight-bolder text-info">
                            {{$document->tin}}
                        </p>
                    </div>
                </div>
            </div>
        @elseif($business->isVerified == 4)
            <p class="text-info">
                Your documents are currently being processed. You will receive a feedback soon.<br>
                Take a moment to view your submitted documents below.
            </p>
            <div class="row w-100">
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Certificate of Registration</h5>
                        </div>
                        <img  src="{{asset('merchant/documents/'.$document->certificate)}}"
                              alt="image" class="img-height" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Proof Of Address</h5>
                        </div>
                        <img  src="{{asset('merchant/documents/'.$document->proofAddress)}}"
                              alt="image" class="img-height" >
                    </div>
                </div>
                <div class="col-md-4 col-lg-4">
                    <div class="card overflow-hidden text-center">
                        <div class="card-body">
                            <h5 class="card-title mb-3">TIN/EIN</h5>
                        </div>
                        <p class="font-weight-bolder text-info">
                            {{$document->tin}}
                        </p>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>



<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.admin.templates.footer')
