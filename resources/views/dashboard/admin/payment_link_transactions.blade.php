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
    <div class="col-lg-12">
        <a href="{{url('admin/payments')}}" class="btn btn-sm btn-info">Payments</a>
    </div>
    <br><br>
    <div class="col-lg-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{$pageName}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($transactions)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Link Reference</th>
                                    <th class="border-bottom-0">Transaction Reference</th>
                                    <th class="border-bottom-0">Transaction Id</th>
                                    <th class="border-bottom-0">Merchant</th>
                                    <th class="border-bottom-0">Payer</th>
                                    <th class="border-bottom-0">Business</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Amount Paid</th>
                                    <th class="border-bottom-0">Charge</th>
                                    <th class="border-bottom-0">Processing Fee</th>
                                    <th class="border-bottom-0">Amount To Credit</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Settled</th>
                                    <th class="border-bottom-0">Time To Settle</th>
                                    <th class="border-bottom-0">Time Settled</th>
                                    <th class="border-bottom-0">Time Paid</th>
                                    <th class="border-bottom-0">Created At</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                @inject('users', 'App\Custom\CustomChecks')
                                    <tr>
                                        <td>
                                            {{$transaction->reference}}
                                        </td>
                                        <td>
                                            {{$transaction->transactionRef}}
                                        </td>
                                        <td>
                                            @if (!empty($transaction->transId))
                                                {{$users->businessId($transaction->transId)}}
                                            @else
                                                No Id yet
                                            @endif
                                        </td>
                                        <td>{{$users->userId($transaction->merchant)}}</td>
                                        <td>{{$transaction->payerName}} ({{$transaction->payerEmail}})</td>
                                        <td>
                                            @if (!empty($transaction->business))
                                                {{$users->businessId($transaction->business)}}
                                            @else
                                                No business
                                            @endif
                                        </td>
                                        <td>{{$transaction->currency}} {{number_format($transaction->amount,2)}}</td>
                                        <td>{{$transaction->currency}} {{number_format($transaction->amountPaid,2)}}</td>
                                        <td>{{$transaction->currency}} {{number_format($transaction->charge,2)}}</td>
                                        <td>{{$transaction->currency}} {{number_format($transaction->flutCharge,2)}}</td>
                                        <td>{{$transaction->currency}} {{number_format($transaction->amountCredit,2)}}</td>
                                        <td>
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
                                        <td>{{date('d-m-Y h:i:s a', $transaction->datePaid)}}</td>
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
@include('dashboard.admin.templates.footer')
