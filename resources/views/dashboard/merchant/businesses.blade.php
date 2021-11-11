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
        @if(count($businesses) < 1)
            <div class="col-xl-12 col-md-12 col-lg-12">
                <div class="row">
                    <div class="col-xl-8 col-lg-8 col-md-12 mx-auto">
                        <div class="alert alert-info text-black text-center">
                            <strong>No Store Found</strong>
                            <hr class="message-inner-separator">
                            <p>
                                Alas! No store was found in our record belonging to you. Nonetheless, you do not need a store
                                to do business on <b>{{env('APP_NAME')}}</b>; you can
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            @foreach($businesses as $businesses)
                <div class="col-xl-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-xl-4 col-lg-4 col-md-6">
                            <div class="card" data-clickable="true" data-href="{{url('merchant/businesses')}}">
                                <div class="card-body">
                                    <i class="fa fa-shopping-basket card-custom-icon icon-dropshadow-primary text-primary fs-60"></i>
                                    <p class=" mb-1"></p>
                                    <h2 class="mb-1 font-weight-bold">Add Business</h2>
                                    <small class="mb-1 text-muted"><span class="text-info">Add a business</span></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@include('dashboard.merchant.templates.footer')
