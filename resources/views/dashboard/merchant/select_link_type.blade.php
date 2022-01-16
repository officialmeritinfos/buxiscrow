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
    <div class="col-md-6">
        <div class="card  mb-5" data-clickable="true"
             data-href="{{url('merchant/payment-link/create?type=donation')}}">
            <div class="card-body">
                <div class="media mt-0">
                    <figure class="rounded-circle align-self-start mb-0 text-danger">

                    </figure>
                    <div class="media-body text-center">
                        <h1 class="time-title p-0 mb-0 font-weight-semibold leading-normal">
                            <i class="fa fa-heart text-danger"></i> Donation</h1>
                        <p>Create really simple links where your customers can easily pay you. </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card  mb-5" data-clickable="true"
             data-href="{{url('merchant/payment-link/create?type=one_time')}}">
            <div class="card-body">
                <div class="media mt-0">
                    <figure class="rounded-circle align-self-start mb-0 text-danger">

                    </figure>
                    <div class="media-body text-center">
                        <h1 class="time-title p-0 mb-0 font-weight-semibold leading-normal">
                            <i class="fa fa-money text-success"></i> One Time Charge</h1>
                        <p>One Time charge allows you create payment links for your customers where they pay once.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--<div class="col-md-4">
        <div class="card  mb-5" data-clickable="true"
             data-href="{{url('merchant/payment-link/create?type=subscription')}}">
            <div class="card-body">
                <div class="media mt-0">
                    <figure class="rounded-circle align-self-start mb-0 text-danger">

                    </figure>
                    <div class="media-body text-center">
                        <h1 class="time-title p-0 mb-0 font-weight-semibold leading-normal">
                            <i class="fa fa-recycle text-primary"></i> Subscription Link</h1>
                        <p>Create links where your customers can subscribe to your services.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
</div>
<!-- /Row -->


<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.footer')
