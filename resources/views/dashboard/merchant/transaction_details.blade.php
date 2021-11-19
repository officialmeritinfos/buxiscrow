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
<!-- Row-->
<div class="row">
    <div class="col-md-12">
        <div class="card overflow-hidden">
            <div class="card-status bg-primary"></div>
            <div class="card-body">
                <h2 class="text-muted font-weight-bold">{{$transaction->title}}</h2>

                <div class="card-body pl-0 pr-0">
                    <div class="row">
                        <div class="col-sm-6">
                            <span>Payment No.</span><br>
                            <strong>{{$transaction->transId}}</strong>
                        </div>
                        <div class="col-sm-6 text-right">
                            <span>Date Created</span><br>
                            <strong>{{$transaction->created_at}}</strong>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover text-nowrap">
                        <tr class=" ">
                            <th>Transaction Type</th>
                            <th>Amount </th>
                        </tr>
                        <tr>
                            <td>
                                <p class="font-weight-semibold mb-1">
                                    @switch($transaction->transactionType)
                                        @case(1)
                                        <span class="font-weight-bolder font-40">Account Funding</span>
                                        @break
                                        @case(2)
                                        <span class=" font-weight-bolder font-40">Transfer</span>
                                        @break
                                        @case(3)
                                        <span class=" font-weight-bolder font-40">Escrow</span>
                                        @break
                                        @default
                                        <span class=" font-weight-bolder font-40">Bill</span>
                                    @endswitch
                                </p>
                            </td>
                            <td>{{$transaction->currency}} {{number_format($transaction->amount,2)}}</td>
                        </tr>
                        <tr>
                            <td colspan="1" class="font-weight-semibold text-right">Amount Credited</td>
                            <td class="text-left" colspan="1">
                                                <span class="badge badge-primary">
                                                    {{$transaction->currency}}
                                                    {{number_format($transaction->amountCredited,2)}}
                                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1" class="font-weight-semibold text-right">Status</td>
                            <td class="text-left" colspan="1">
                                @switch($transaction->paymentStatus)
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
                        <tr>
                            <td colspan="1" class="font-weight-semibold text-right">Transaction Reference</td>
                            <td class="text-left" colspan="1"><span class="badge badge-primary">{{$transaction->transactionRef}}</span></td>
                        </tr>

                    </table>
                </div>
                @switch($transaction->transactionType)
                    @case(1)
                    <p class="text-muted text-center">Have any Queries about this transaction? Contact us @:
                        <a href="mailto:{{$web->siteSupportMail}}">{{$web->siteSupportMail}}</a>
                    </p>
                    @break
                    @case(2)
                    <p class="text-muted text-center">This is just a preview of the main transaction.
                        Find details <a href="{{url('merchant/transfers/'.$transaction->transactionRef.'/details')}}"
                                        class="text-primary">here</a></p>
                    @break
                    @case(3)
                    <p class="text-muted text-center">This is just a preview of the main transaction.
                        Find details <a href="{{url('merchant/escrows/'.$transaction->transactionRef.'/details')}}"
                                        class="text-primary">here</a></p>
                    @break
                    @case(4)
                    <p class="text-muted text-center">This is just a preview of the main transaction.
                        Find details <a href="{{url('merchant/bills/'.$transaction->transactionRef.'/details')}}"
                                        class="text-primary">here</a></p>
                    @break
                @endswitch
            </div>
        </div>
    </div>
</div>
<!-- End row-->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.footer')
