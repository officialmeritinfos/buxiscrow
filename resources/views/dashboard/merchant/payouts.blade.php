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
<div class="row">
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{$pageName}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <p class="text-center">
                        <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#new_transfer">
                            <i class="mdi mdi-bank" data-toggle="tooltip" title="Transfer"></i>
                        </button>
                    </p>
                    <div class="table-responsive">
                        @isset($transfers)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Created</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transfers as $transfer)
                                    <tr>
                                        <td>{{$transfer->reference}}</td>
                                        <td>{{$transfer->currency}}</td>
                                        <td>{{$transfer->amount}}</td>
                                        <td>
                                            @switch($transfer->status)
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
                                        </td>
                                        <td>{{$transfer->created_at}}</td>
                                        <td>
                                            <a href="{{url('merchant/transfers/'.$transfer->reference.'/details')}}"
                                               class="btn btn-outline-warning"><i class="fa fa-eye"></i> </a>
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
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.transfer_modal')
@include('dashboard.merchant.templates.footer')
