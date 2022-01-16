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


<!-- Row -->
<div class="row">
    <div class="col-xl-4 col-lg-4">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                @if($business->logoUploaded==1)
                    <img alt="User Avatar" class="rounded-circle" src="{{asset('merchant/photos/'.$business->logo)}}" style="width:100px; height: 100px;">
                @else
                    <img alt="User Avatar" class="rounded-circle" src="https://ui-avatars.com/api/?name={{$business->name}}&rounded=true&background=random">
                @endif
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h3 class="pro-user-username text-dark mb-1">{{$business->name}}</h3>
                    <h6 class="pro-user-desc text-muted">{{$business->businessDescription}}</h6>

                </div>
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    @if($business->isVerified ==2)
                        <p class="text-danger" style="font-size:15px;">
                            This business is unverified.
                        </p>
                    @endif
                    @if($business->isVerified ==4)
                        <p class="text-info" style="font-size:15px;">We are currently reviewing your submitted documents.<br>
                            <a href="{{url('admin/business/'.$business->businessRef.'/verify')}}">
                                View Submitted Documents
                            </a>
                        </p>
                    @endif
                    @if($business->isVerified ==1)
                        <p class="text-success" style="font-size:15px;">Business has been verified <br>
                            <a href="{{url('admin/business/'.$business->businessRef.'/verify')}}">
                                View Submitted Documents
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$category}}</h5>
                            <span class="text-muted">Category</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block text-center p-4">
                            @if($business->isCrypto ==1)
                                <h5 class="description-header mb-1 font-weight-bold">
                                    {{$type->name}}
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="For Nigerian based businesses,
                                    the CBN has restricted trades in cryptocurrency. Therefore, to prevent accounts being flagged,
                                    cryptocurrency transactions will be made in USD and out of the Nigerian Banking System."></i>
                                </h5>
                            @else
                                <h6 class="description-header mb-1 font-weight-bold">
                                    {{$type->name}}
                                </h6>
                            @endif
                            <span class="text-muted">Business Type</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessEmail}}</h5>
                            <span class="text-muted">Email</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessPhone}}</h5>
                            <span class="text-muted">Phone</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessState}}</h5>
                            <span class="text-muted">State</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessCity}}</h5>
                            <span class="text-muted">City</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessCountry}}</h5>
                            <span class="text-muted">Country</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessAddress}}</h5>
                            <span class="text-muted">Address</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->Zip}}</h5>
                            <span class="text-muted">ZIP</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold"> {{$business->businessTag}}</h5>
                            <span class="text-muted">Tags</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold">
                                <a href="{{url('admin/business/'.$business->businessRef.'/update_verify/4')}}"
                                   class="btn btn-sm btn-info" style="margin-bottom:4px;">Mark Submitted</a>
                                <a href="{{url('admin/business/'.$business->businessRef.'/update_verify/2')}}"
                                   class="btn btn-sm btn-primary" style="margin-bottom:4px;">Mark Pending</a>
                                <a href="{{url('admin/business/'.$business->businessRef.'/update_verify/1')}}"
                                   class="btn btn-sm btn-success" style="margin-bottom:4px;">Mark verified</a>
                            </h5>
                            <span class="text-muted">Verification Action</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block text-center p-4">
                            <h5 class="description-header mb-1 font-weight-bold">
                                <a href="{{url('admin/business/'.$business->businessRef.'/status/2')}}"
                                   class="btn btn-sm btn-danger" style="margin-bottom:4px;">Deactivate</a>
                                <a href="{{url('admin/business/'.$business->businessRef.'/status/1')}}"
                                   class="btn btn-sm btn-success" style="margin-bottom:4px;">Activate</a>
                            </h5>
                            <span class="text-muted">Business Activity</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8">
        <div class="main-content-body main-content-body-profile  mg-b-20">
            <div class="row">
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Total Escrow</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$escrows->count()}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Total Customers</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$customers->count()}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Total Refunds</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$refunds->count()}}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content-body main-content-body-profile mg-b-20">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">
                                Amount Received(NGN)
                            </p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$completed_payments}}
                            </h2>
                            <span class="mb-1 text-muted"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 43.2</span> last month</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">
                                Amount Received(USD)
                            </p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$completed_payments_usd}}
                            </h2>
                            <span class="mb-1 text-muted"><span class="text-danger"><i class="fa fa-caret-down  mr-1"></i> 43.2</span> last month</span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">
                                Pending Amount(NGN)
                            </p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$pending_payments}}
                            </h2>
                            <span class="mb-1 text-muted"><span class="text-success">
                                    <i class="fa fa-caret-up  mr-1"></i> 19.8</span> last month
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">
                                Pending Amount(USD)
                            </p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$pending_payments_usd}}
                            </h2>
                            <span class="mb-1 text-muted"><span class="text-success">
                                    <i class="fa fa-caret-up  mr-1"></i> 19.8</span> last month
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.admin.templates.footer')
