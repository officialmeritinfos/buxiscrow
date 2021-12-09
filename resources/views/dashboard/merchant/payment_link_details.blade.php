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

<!--Row-->
<div class="row">
    <div class="col-md-12">
        <div class="row mr-0 ml-0">
            <div class="col-xl-4 col-lg-4 col-sm-6 col-xs-6 pr-0 pl-0 border-right">
                <p class="mb-1">Amount</p>
                <h2 class="mb-1 font-weight-bold">{{$link->currency}}{{number_format($link->amount,2)}}</h2>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-6 col-xs-6 pr-0 pl-0 border-right">
                <p class="mb-1">Reference</p>
                <h4 class="mb-1 font-weight-bold">{{$link->reference}}</h4>
            </div>
            <div class="col-xl-4 col-lg-4 col-sm-6 col-xs-6 pr-0 pl-0 border-right">
                <p class="mb-1">Status</p>
                <p id="status">
                    @switch($link->status)
                        @case(1)
                        <span class="badge badge-success">Active</span>
                        @break
                        @case(2)
                        <span class="badge badge-danger">Deactivated</span>
                        @break
                    @endswitch
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="row mr-0 ml-0">
                <div class="col-xl-2 col-lg-2 col-sm-6 col-xs-6 pr-0 pl-0 border-right">
                    <div class="card-body text-center">
                        <p class="mb-1">Page Name</p>
                        <span class="mb-0 text-muted">
                            {{$link->title}}
                        </span>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6 col-xs-6 pr-0 pl-0 border-right">
                    <div class="card-body text-center">
                        <p class="mb-1">Page Type</p>
                        <span class="mb-0 text-muted">
                            @switch($link->type)
                                @case(1)
                                <span class="badge badge-info">One Time Charge</span>
                                @break
                                @case(2)
                                <span class="badge badge-primary">Subscription</span>
                                @break
                                @case(3)
                                <span class="badge badge-success">Donation</span>
                                @break
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6 pr-0 pl-0 border-right">
                    <div class="card-body text-center">
                        <p class="mb-1">Date Created</p>
                        <span class="mb-0 text-muted">
                            {{$link->created_at}}
                        </span>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-sm-6 pr-0 pl-0 border-right">
                    <div class="card-body text-center">
                        <p class="mb-1">Payment URl</p>
                        <span class="mb-0 text-muted" id="link">
                            <a href="{{url('pay/'.$link->reference)}}" target="_blank">{{url('pay/'.$link->reference)}}</a>
                        </span>
                        <div class="clipboard-icon" data-clipboard-target="#link">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M14 7H8v14h11v-9h-5z" opacity=".3"/>
                                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4H8c-1.1 0-1.99.9-1.99 2L6 21c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V11l-6-6zm4 16H8V7h6v5h5v9z"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-4 col-sm-6 pr-0 pl-0 border-right">
                    <div class="card-body text-center">
                        <p class="mb-1">
                            <a href="{{url('pay/'.$link->reference)}}" target="_blank"
                               class="btn btn-orange btn-sm" ><i class="fa fa-eye"></i> View</a><br><br>
                            <button class="btn btn-purple btn-sm" data-toggle="modal"
                                    data-target="#download_qr" style="margin-bottom: 5px;">
                               <i class="fa fa-qrcode"></i> Download QR
                            </button>
                            @if($link->status ==1)
                                <button class="btn btn-warning btn-sm" data-ref="{{$link->reference}}"
                                    id="deactivate_link" style="margin-bottom: 5px;">
                                <i class="fa fa-ban"></i> Deactivate
                                </button>
                            @endif
                            @if($link->status !=1)
                                <button class="btn btn-success btn-sm" data-ref="{{$link->reference}}"
                                                     id="activate_link" style="margin-bottom: 5px;">
                                <i class="fa fa-check-circle"></i> Activate
                                </button>
                            @endif
                            <button class="btn btn-danger btn-sm" data-ref="{{$link->reference}}"
                                   id="delete_link" style="margin-bottom: 5px;">
                                <i class="fa fa-times-circle"></i> Delete
                            </button>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End row-->

<!-- Row -->
<div class="row">
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Transaction List</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($payments)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Email</th>
                                    <th class="border-bottom-0">Amount Paid</th>
                                    <th class="border-bottom-0">Charge</th>
                                    <th class="border-bottom-0">Amount Credited</th>
                                    <th class="border-bottom-0">Channel</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Created</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{$payment->transactionRef}}</td>
                                        <td>{{$payment->payerName}}</td>
                                        <td>{{$payment->payerEmail}}</td>
                                        <td>{{$payment->currency}}{{number_format($payment->amountPaid,2)}}</td>
                                        <td>{{$payment->currency}}{{number_format($payment->charge,2)}}</td>
                                        <td>{{$payment->currency}}{{number_format($payment->amountCredit,2)}}</td>
                                        <td>{{$payment->paymentChannel}}</td>
                                        <td>
                                            @switch($payment->paymentStatus)
                                                @case(1)
                                                <span class="badge badge-success">Successful</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-primary">Pending</span>
                                                @break
                                                @case(3)
                                                <span class="badge badge-danger">Failed/Cancelled</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{$payment->created_at}}</td>
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
<!-- Row -->
<div class="row text-md-center ">

</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.merchant.templates.payment_link_modal')
@include('dashboard.merchant.templates.footer')
