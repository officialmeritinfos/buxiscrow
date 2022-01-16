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
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                @if($user->isUploaded==1)
                    <img alt="User Avatar" class="rounded-circle" src="{{asset('user/photos/'.$user->photo)}}" style="width:100px; height: 100px;">
                @else
                    <img alt="User Avatar" class="rounded-circle" src="https://ui-avatars.com/api/?name={{$user->name}}&rounded=true&background=random">
                @endif
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h4 class="pro-user-username text-dark mb-1 font-weight-bold">{{$user->name}}</h4>
                    <h6 class="pro-user-desc text-muted">{{$user->occupation}}</h6>
                    <a href="{{url('account/settings')}}" class="btn btn-primary btn-sm mt-3">Edit Profile</a>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    @if($user->isVerified ==2)
                        <p class="text-danger" style="font-size:15px;">Your account is unverified.
                            Verify Now to enjoy premium and unlimited features.<a href="{{url('account/documents/verify')}}">
                                Start Now
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold">Lv. {{$user->userLevel}}</h5>
                            <span class="text-muted">Level</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="description-block text-center p-4">
                            <h5 class="description-header mb-1 font-weight-bold">{{$ip}}</h5>
                            <span class="text-muted">Ip Address</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-8 col-lg-8 col-md-12">
        <div class="main-content-body main-content-body-profile card mg-b-20">
            <!-- main-profile-body -->
            <div class="main-profile-body">
                <div class="tab-content">
                    <div class="tab-pane show active" id="about">
                        <div class="card-body">
                            <h4 class="card-title">Personal Details</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Name </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Email </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->email}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Username </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->username}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Phone </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->phoneCode}}{{$user->phone}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Date of Birth </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->DOB}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Location </span>
                                                </td>
                                                <td class="py-2 px-0">{{$user->country}}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                            @if($user->countryCode =='NG')
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Submitted BVN </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        @if($user->hasBvn ==1)
                                                            <span class="badge badge-success">Submitted</span>
                                                        @else
                                                            <span class="badge badge-danger">Unverified</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Account </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    @if($user->canSend ==1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @foreach($balances as $balance)
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">{{$balance->code}} Account Limit </span>
                                                    </td>
                                                    <td class="py-2 px-0">{{$balance->code}} {{number_format($balance->AccountLimit,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">{{$balance->code}} Transaction Limit </span>
                                                    </td>
                                                    <td class="py-2 px-0">{{$balance->code}} {{number_format($balance->TransactionLimit,2)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

</div><!-- end app-content-->
</div>

@include('dashboard.user.templates.footer')
