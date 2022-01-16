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
    <div class="col-12">
        @if(count($businesses) < 1)
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 mx-auto">
                        <div class="alert alert-info text-black text-center">
                            <strong>No Store Found</strong>
                            <hr class="message-inner-separator">
                            <p>
                                Alas! No store was found in our record belonging to you. Nonetheless, you do not need a store
                                to do business on <b>{{env('APP_NAME')}}</b>; you can receive payments using your payment link.<br><br>

                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">

                @foreach($businesses as $business)
                    <div class="col-xl-4 col-lg-4 col-md-4">
                        <div class="card  mb-5">
                            <div class="card-body">
                                <div class="media mt-0">
                                    <figure class="rounded-circle align-self-start mb-0">
                                        @if($business->logoUploaded==1)
                                            <img alt="User Avatar" class="avatar brround avatar-md mr-3"
                                                 src="{{asset('merchant/photos/'.$business->logo)}}" style="width:50px; height: 50px;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{$business->name}}&rounded=true&background=random"
                                                 alt="Generic placeholder image" class="avatar brround avatar-md mr-3">
                                        @endif
                                    </figure>
                                    <div class="media-body">
                                        <h5 class="time-title p-0 mb-0 font-weight-semibold leading-normal">{{$business->name}}</h5>
                                        {{ucwords(strtolower($business->businessState))}}, {{$business->businessCountry}}
                                    </div>
                                    <a class="btn btn-primary d-sm-block mr-2" href="{{url('admin/business/'.$business->businessRef)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <button class="btn btn-danger d-sm-block mr-2" data-toggle="modal"
                                            data-target="#delete_business" data-ref="{{$business->businessRef}}" data-value="{{$business->name}}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-footer text-secondary border-top">
                                Phone: <span class="text-primary">{{$business->businessPhone}}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.admin.templates.footer')
