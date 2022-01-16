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
                        <a class="btn btn-outline-info btn-sm" href="{{url('merchant/payment-link/create-link')}}">
                            <i class="mdi mdi-plus" data-toggle="tooltip" title="New Payment Link"></i>
                        </a>
                    </p>
                    <div class="table-responsive">
                        @isset($links)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Title</th>
                                    <th class="border-bottom-0">Type</th>
                                    <th class="border-bottom-0">Reference</th>
                                    <th class="border-bottom-0">Amount</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Created</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($links as $link)
                                    <tr class="clickable_row" data-href="{{url('merchant/payment-link/'.$link->reference.'/details')}}">
                                        <td>{{$link->title}}</td>
                                        <td>
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
                                        </td>
                                        <td>{{$link->reference}}</td>
                                        <td>{{$link->currency}}{{number_format($link->amount,2)}}</td>
                                        <td>
                                            @switch($link->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @case(2)
                                                <span class="badge badge-primary">Pending</span>
                                                @break
                                            @endswitch
                                        </td>
                                        <td>{{$link->created_at}}</td>
                                        <td>
                                            <a href="{{url('merchant/payment-link/'.$link->reference.'/details')}}"
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

<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.footer')