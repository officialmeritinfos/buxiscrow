@include('dashboard.merchant.templates.header')
<!--Page header-->
<div class="page-header">
    <div class="page-leftheader">
        <h4 class="page-title">{{$pageName}}</h4>
    </div>
    <div class="page-rightheader ml-auto d-lg-flex d-none">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{url('merchant/dashboard')}}" class="d-flex">
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
<div class="row">
    @foreach($balances as $balance)
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-success"></i></span>
                    <p class=" mb-1 ">{{$balance->currency}} Account Balance </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$balance->currency}} {{number_format($balance->availableBalance,2)}}</h2>
                    @if($balance->currency =='NGN')
                        <a class="btn btn-outline-success btn-sm" href="{{url('merchant/transfers')}}">
                            <i class="mdi mdi-bank" data-toggle="tooltip" title="Transfer"></i> Withdraw
                        </a>
                    @endif
                    @if($balance->currency !='NGN')
                        <small class="mb-1 text-muted">
                            <button class="btn btn-outline-info btn-sm" data-backdrop="static" data-keyboard="false"
                                    data-toggle="modal" data-target="#convert_balance" data-currency="{{$balance->currency}}">Convert to NGN</button>
                        </small>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-primary"></i></span>
                    <p class=" mb-1 ">{{$balance->currency}} Referral Balance </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$balance->currency}} {{number_format($balance->referralBalance,2)}}</h2>
                    <small class="mb-1 text-muted">
                        <button class="btn btn-outline-info btn-sm" data-backdrop="static" data-keyboard="false"
                                data-toggle="modal" data-target="#convert_referral_spcific" data-currency="{{$balance->currency}}">Withdraw</button>
                    </small>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-12">
            <div class="card">
                <div class="card-body text-center">
                    <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-danger"></i></span>
                    <p class=" mb-1 ">{{$balance->currency}} Frozen Balance
                        <i class="fa fa-info-circle text-info" data-container="body" data-toggle="popover" data-popover-color="head-primary"
                           data-placement="top" title="frozen balance"
                           data-content="Funds here are not available for use. There are several reasons for which this could have occurred.
When your you receive funds that are beyond your account limit, they are held here pending account upgrade. Contact our support for more information">
                        </i>
                    </p>
                    <h2 class="mb-1 fs-40 font-weight-bold">{{$balance->currency}} {{number_format($balance->frozenBalance,2)}}</h2>
                    <small>click for more information</small>
                </div>
            </div>
        </div>
    @endforeach
</div>
<!-- Row -->
<!-- Row -->
<div class="row">
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Account Fundings</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($fundings)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Payment Method</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Settled</th>
                                    <th class="border-bottom-0">Time To Settle</th>
                                    <th class="border-bottom-0">Time Settled</th>
                                    <th class="border-bottom-0">Time Paid</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($fundings as $transaction)
                                    <tr>
                                        <td>{{$transaction->fundingRef}}</td>
                                        <td>{{$transaction->currency}}</td>
                                        <td>{{$transaction->amount}}</td>
                                        <td>{{$transaction->paymentMethod}}</td>
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
                                        <td>
                                            @switch($transaction->settled)
                                                @case(1)
                                                <span class="badge badge-info">Settled</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-warning">Pending</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>
                                            <span class="btn btn-outline-info btn-sm">{{date('d-m-Y h:i:s a', $transaction->timeSettle)}}</span>
                                        </td>
                                        <td>
                                            @switch($transaction->settled)
                                                @case(1)
                                                <span class="btn btn-outline-dark btn-sm">{{date('d-m-Y h:i:s a', $transaction->timeSettled)}}</span>
                                                @break
                                                @case(2)
                                                <span class="btn btn-indigo btn-sm">Pending Settlement</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{$transaction->created_at}}</td>

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
</div>
<!-- /Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.dashboard_modal')
@include('dashboard.merchant.templates.footer')
