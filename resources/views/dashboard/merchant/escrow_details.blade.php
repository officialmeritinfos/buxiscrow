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


<!-- Row -->
<div class="row text-md-center ">
    <div class="col-xl-12 col-lg-12">
        <div class="card box-widget widget-user">
            <div class="card-body">
                <div class="pro-user">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="pro-user-username text-dark mb-1">Title</h4>
                            <p>{{$escrow->title}}</p>
                            <h6 class="pro-user-desc font-weight-bolder">Description</h6>
                            <p>{{$escrow->description}}</p>
                            <h6 class="pro-user-desc font-weight-bolder">Reference</h6>
                            <p class="badge badge-dark">#{{$escrow->reference}}</p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="pro-user-username text-dark mb-1">Amount</h4>
                            <p>
                                {{$escrow->currency}} {{number_format($escrow->amount,2)}}
                            </p>
                            <h6 class="pro-user-desc font-weight-bolder">Charge</h6>
                            <p>
                                {{$escrow->currency}} {{number_format($escrow->charge,2)}}
                            </p>
                            <h4 class="pro-user-username text-dark mb-1">Amount To Settle</h4>
                            <p>
                                {{$escrow->currency}} {{number_format($escrow->amountToPay - $escrow->charge,2)}}
                            </p>
                        </div>
                        <div class="col-md-4">
                            <h4 class="pro-user-username text-dark mb-1">Amount To Pay</h4>
                            <p>
                                {{$escrow->currency}} {{number_format($escrow->amountToPay,2)}}
                            </p>
                            <h6 class="pro-user-desc font-weight-bolder">Who Pays Charge</h6>
                            <p>
                               @switch($escrow->whoPaysCharge)
                                   @case(1)
                                        <span class="badge badge-info">Merchant</span>
                                    @break
                                   @case(2)
                                        <span class="badge badge-primary">Buyer</span>
                                    @break
                                   @default
                                        <span class="badge badge-dark">
                                            Both ( Merchant - {{$escrow->currency}} {{number_format($escrow->chargePaidBySeller,2)}} ({{$escrow->percentChargePaidByMerchant}}%) &
                                            Buyer - {{$escrow->currency}} {{number_format($escrow->chargePaidByBuyer,2)}} ({{$escrow->percentChargePaidByUser}}%) )
                                        </span>
                                @endswitch
                            </p>
                            <h4 class="pro-user-username text-dark mb-1">Payer</h4>
                            <p>
                                {{$payer->name}} ({{$payer->email}})
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-12 col-lg-12 text-center">
        <div class="card box-widget widget-user">
            <div class="card-body ">
                <div class="pro-user">
                    <div class="row">
                        <div class="col-md-3">
                            <h4 class="pro-user-username text-dark mb-1">Date Created</h4>
                            <p>{{date('d/m/Y h:i:s a',strtotime($escrow->created_at))}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="pro-user-username text-dark mb-1">Deadline To Deliver</h4>
                            <p>{{date('d/m/Y h:i:s a',$escrow->deadline)}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="pro-user-username text-dark mb-1">Inspection period</h4>
                            <p>{{date('d/m/Y h:i:s a',$escrow->inspectionPeriod)}}</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="pro-user-username text-dark mb-1">Is Cryptocurrency Transaction</h4>
                            <p>
                                @switch($escrow->isCrypto)
                                    @case(1)
                                    <span class="badge badge-danger">Yes</span>
                                    @break
                                    @default
                                    <span class="badge badge-dark">No</span>
                                @endswitch
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @if(!empty($payment))
        <div class="col-xl-12 col-lg-12 ">
            <div class="card box-widget widget-user">
                <div class="card-body">
                    <div class="pro-user">
                        <div class="row">
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Amount Paid</h4>
                                <p>{{$payment->currency}} {{number_format($payment->amountPaid,2)}}</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Payment Channel</h4>
                                <p>{{$payment->paidThrough}}</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Date Paid</h4>
                                <p>{{date('d/m/Y h:i:s a',$payment->datePaid)}}</p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Transaction Reference</h4>
                                <p><span class="badge badge-dark">{{$payment->transactionRef}}</span></p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Payment Status</h4>
                                <p>
                                    @switch($payment->paymentStatus)
                                        @case(1)
                                            <span class="badge badge-success">Successful</span>
                                        @break
                                        @case(2)
                                            <span class="badge badge-primary">Pending</span>
                                        @break
                                        @case(3)
                                        <span class="badge badge-danger">Failed</span>
                                        @break
                                        @case(5)
                                        <span class="badge badge-warning">Refunded</span>
                                        @break
                                    @endswitch
                                </p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-12 col-lg-12 ">
            <div class="card box-widget widget-user">
                <div class="card-body text-center">
                    <div class="pro-user">
                        <div class="alert alert-info">
                            <strong>Pending Payment</strong>
                            <hr class="message-inner-separator">
                            <p>
                                No Payment has been made for this transaction. Click the link below to notify the payer
                                about this pending payment.
                            </p>
                            <br>
                            @if($escrow->deadline > time())
                                <button class="btn btn-outline-info" id="notify_escrow_payer_pending_payment" data-value="{{$escrow->reference}}">
                                    Send Reminder
                                </button>
                            @else
                                <button class="btn btn-outline-danger" >
                                    Transaction Expired
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($escrow->useDelivery !=1)
        <div class="col-xl-12 col-lg-12 ">
            <div class="card box-widget widget-user">
                <div class="card-body text-center">
                    <div class="pro-user">
                        <div class="alert alert-primary">
                            <strong>Delivery Service</strong>
                            <hr class="message-inner-separator">
                            <p>
                                You are not using any of our Delivery partners. This is optional nonetheless and charge is dependednt on the
                                delivery location as well as the Delivery partner used. Using one of our delivery partners ensures that your
                                transaction is carried out faster than ever.
                            </p>
                            <br>
                            <button class="btn btn-outline-primary" data-toggle="modal" data-target="#add-delivery-service"
                            data-value="{{$escrow->reference}}">
                                Add Delivery Service
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="col-xl-12 col-lg-12 ">
            <div class="card box-widget widget-user">
                <div class="card-header">
                    <h4>Delivery Details</h4>
                </div>
                <div class="card-body">
                    <div class="pro-user">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Logistics Company</h4>
                                <p> {{$logistics->name}} </p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Location</h4>
                                <p> {{$logisticsLocation->City}}, {{$logisticsLocation->State}} </p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Delivery Cost</h4>
                                <p> {{$escrow->deliveryCurrency}} {{number_format($escrow->deliveryAmount,2)}} </p>
                            </div>
                            <div class="col-md-3">
                                <h4 class="pro-user-username text-dark mb-1">Delivery Point</h4>
                                <p> {{$escrow_delivery->address}}, {{$logisticsLocation->country}} </p>
                            </div>
                            <div class="col-md-3 mx-auto">
                                <h4 class="pro-user-username text-dark mb-1">Delivery Status</h4>
                                <p>
                                    @switch($escrow_delivery->status)
                                        @case(1)
                                            <span class="badge badge-success">Delivered</span>
                                        @break
                                        @case(2)
                                        <span class="badge badge-info">Pending</span>
                                        @break
                                        @case(3)
                                        <span class="badge badge-danger">cancelled</span>
                                        @break
                                    @endswitch()
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-xl-12 col-lg-12 ">
        <div class="card box-widget widget-user">
            <div class="card-header">
                <h4>More</h4>
            </div>
            <div class="card-body">
                <div class="pro-user">
                    <div class="row">
                        @if(!empty($payment))
                            @if($payment->paymentStatus == 1)
                                <div class="col-md-3">
                                    <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#markDelivered" data-value="{{$escrow->reference}}">
                                        Mark Delivered</button>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-outline-info btn-sm" data-toggle="modal" data-target="#refundPayment" data-value="{{$escrow->reference}}">
                                        Refund</button>
                                </div>
                            @endif
                        @endif
                        @if($escrow->status != 1 && $escrow->status != 3)

                            <div class="col-md-3 mx-auto">
                                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancel_transaction" data-value="{{$escrow->reference}}">
                                    Cancel Transaction</button>
                            </div>
                        @endif
                    </div><br><br>
                    <div class="row">
                        <div class="col-md-3 mx-auto">
                            <h4 class="pro-user-username text-dark mb-1">Transaction Status</h4>
                            <p>
                                @switch($escrow->status)
                                    @case(1)
                                    <span class="badge badge-success">Completed</span>
                                    @break
                                    @case(2)
                                    <span class="badge badge-info">Active</span>
                                    @break
                                    @case(3)
                                    <span class="badge badge-danger">cancelled</span>
                                    @break
                                @endswitch()
                            </p>
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
@include('dashboard.merchant.templates.escrow_modal')
@include('dashboard.merchant.templates.footer')
