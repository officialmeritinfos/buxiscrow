@include('dashboard.user.templates.header')
<!--Page header-->
<div class="page-header">

        <div class="page-leftheader">

            <h4 class="page-title">{{$pageName}}</h4>
        </div>
        <div class="page-rightheader ml-auto d-lg-flex d-none">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('account/dashboard')}}" class="d-flex">
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
<!-- Row-->
<div class="row">
    <div class="col-xl-8 col-lg-8 col-md-6 mx-auto">
        <div class="main-content-body main-content-body-profile card mg-b-20">
            <!-- main-profile-body -->
            <div class="main-profile-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="about">
                        <div class="card-body">
                            <h4 class="font-weight-bold text-center">Transfer</h4>
                            <h6 class="text-center">
                                On <b class="font-weight-bold">{{date('M d, Y', strtotime($transaction->created_at))}}</b>
                                at <b class="font-weight-bold">{{date('h:i A',strtotime($transaction->created_at))}}</b>
                            </h6>
                        </div>
                        <div class="card-body border-top d-none d-md-block">
                            <div class="row">
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold">{{$transfer->currency}}{{number_format($transfer->amount,2)}}</h5>
                                    <p>{{$transfer->accountName}}</p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold">To</h5>
                                    <p>{{$transfer->bank}}</p>
                                </div>
                                <div class="col-md-4">
                                    <h5 class="font-weight-bold">Narration</h5>
                                    <p>{{$transfer->narration}}</p>
                                </div>
                            </div>
                        </div>
                        <!--Shows on Small Devices-->
                        <div class="card-body border-top d-sm-block d-md-none">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 class="font-weight-bold">{{$transfer->currency}}{{number_format($transfer->amount,2)}}</h5>
                                    <p>{{$transfer->accountName}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top d-sm-block d-md-none ">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="font-weight-lighter">To</p>
                                    <h5 class="font-weight-bolder">{{$transfer->bank}}</h5>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top  d-sm-block d-md-none ">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="font-weight-lighter">Narration</p>
                                    <h5 class="font-weight-bolder">{{$transfer->narration}}</h5>
                                </div>
                            </div>
                        </div>
                        <!--Shows on Small Devices End-->
                        <div class="card-body border-top">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="font-weight-light">Payment Method</p>
                                    <p class="font-weight-bolder">Money Sent</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="font-weight-light">Fees </p>
                                    <p class="font-weight-bolder">{{$transfer->currency}}{{$transaction->charge}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="font-weight-light">Transaction Reference
                                    </p>
                                    <p>
                                        <b class="font-weight-bolder">{{$transfer->reference}}</b>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body border-top">
                            <h5 class="font-weight-bold">Status</h5>
                            <div class="main-profile-contact-list d-lg-flex">
                                <div class="media mr-4">
                                    <div class="media-body">
                                        <div class="font-weight-bold">
                                            @switch($transaction->paymentStatus)
                                                @case(1)
                                                <span class="badge badge-success">Successful</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-primary">Processing</span>
                                                @break
                                                @case(3)
                                                <span class="badge badge-danger">Failed</span>
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                </div>
                            </div><!-- main-profile-contact-list -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.user.templates.footer')
