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


<!-- Row -->
<div class="row">
    <div class="col-xl-4 col-lg-4">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                @if($business->logoUploaded==1)
                    <img alt="User Avatar" class="rounded-circle"
                         src="{{asset('merchant/photos/'.$business->logo)}}" style="width:100px; height: 100px;">
                    @if($business->isVerified ==1)
                        <sup data-toggle="tooltip" title="verified" class="text-success">
                            <i class="fa fa-check-circle fa-2x"></i></sup>
                    @endif
                @else
                    <img alt="User Avatar" class="rounded-circle"
                         src="https://ui-avatars.com/api/?name={{$business->name}}&rounded=true&background=random">
                    @if($business->isVerified ==2)
                        <sup data-toggle="tooltip" title="unverified" class="text-danger">
                            <i class="fa fa-times-circle fa-2x"></i></sup>
                    @endif
                    @if($business->isVerified ==1)
                        <sup data-toggle="tooltip" title="verified" class="text-success">
                            <i class="fa fa-check-circle fa-2x"></i></sup>
                    @endif
                @endif
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h3 class="pro-user-username text-dark mb-1">{{$business->name}}</h3>
                    <h6 class="pro-user-desc text-muted">{{$business->businessDescription}}</h6>
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
                    <div class="col-sm-12">
                        <div class="description-block text-center p-4">
                            <button class="btn btn-outline-dark" data-toggle="modal" data-target="#sendMoney"
                            data-business="{{$business->businessRef}}">
                                <i class="payment payment-visa"></i>
                                Send Money
                            </button>
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
                            <p class="mb-1">Total Transactions</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$escrows->count()}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Completed Transactions</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$completed_transactions}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Pending Transactions</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$pending_transactions}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Cancelled Transactions</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$cancelled_transactions}}
                            </h2>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <p class="mb-1">Credit Score</p>
                            <h2 class="mb-1 font-weight-bold">
                                {{$credit_score}}
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Payments Sent to {{$business->name}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($transactionsWithBusiness)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Narration</th>
                                    <th class="border-bottom-0">Time</th>
                                    <th class="border-bottom-0">Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactionsWithBusiness as $transaction)
                                    <tr>
                                        <td>{{$transaction->reference}}</td>
                                        <td>{{$transaction->currency}}</td>
                                        <td>{{$transaction->amount}}</td>
                                        <td>{{$transaction->narration}}</td>
                                        <td>{{$transaction->created_at}}</td>
                                        <td>
                                            @switch($transaction->status)
                                                @case(1)
                                                <span class="badge badge-success">Successful</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-primary">Pending</span>
                                                @break
                                                @case(3)
                                                <span class="badge badge-danger">Failed</span>
                                                @break
                                            @endswitch
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

    <div class="col-md-6">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Escrow With {{$business->name}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($escrowsWithBusiness)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Title</th>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Created</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($escrowsWithBusiness as $escrow)
                                    <tr>
                                        <td>{{$escrow->title}}</td>
                                        <td>{{$escrow->reference}}</td>
                                        <td>{{$escrow->currency}}</td>
                                        <td>{{$escrow->amount}}</td>
                                        <td>
                                            @switch($escrow->status)
                                                @case(1)
                                                <span class="badge badge-success">Successful</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-primary">Pending</span>
                                                @break
                                                @case(3)
                                                <span class="badge badge-danger">Failed</span>
                                                @break
                                                @case(4)
                                                <span class="badge badge-info">Paid</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{$escrow->created_at}}</td>
                                        <td>
                                            <a href="{{url('account/escrows/'.$escrow->reference.'/details')}}"
                                               class="btn btn-outline-warning"><i class="fa fa-eye"></i> </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$escrowsWithBusiness->links()}}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.user.templates.business_modal')
@include('dashboard.user.templates.footer')
