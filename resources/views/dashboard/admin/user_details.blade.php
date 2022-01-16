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
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card box-widget widget-user">
            <div class="widget-user-image mx-auto mt-5 text-center">
                @if($users->isUploaded==1)
                    <img alt="User Avatar" class="rounded-circle" src="{{asset('user/photos/'.$users->photo)}}" style="width:100px; height: 100px;">
                @else
                    <img alt="User Avatar" class="rounded-circle" src="https://ui-avatars.com/api/?name={{$users->name}}&rounded=true&background=random">
                @endif
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    <h4 class="pro-user-username text-dark mb-1 font-weight-bold">
                        {{$users->name}}
                        @switch($user->accountType)
                            @case(1)
                            <sup class="badge badge-info">Merchant</sup>
                            @break
                            @default()
                            <sup class="badge badge-primary">User</sup>
                        @endswitch
                    </h4>
                    <h6 class="pro-user-desc text-muted">{{$users->occupation}}</h6>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <button class="btn btn-sm btn-outline-primary" style="margin-bottom:4px;"
                                data-toggle="modal" data-target="#increaseITransLimit">Increase IT Limit</button>
                        <button class="btn btn-sm btn-outline-info" style="margin-bottom:4px;"
                                data-toggle="modal" data-target="#increaseBTransLimit">Increase BT Limit</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn btn-sm btn-outline-primary" style="margin-bottom:4px;"
                                data-toggle="modal" data-target="#increaseIAccountLimit">
                            Increase IA Limit
                        </button>
                        <button class="btn btn-sm btn-outline-info" style="margin-bottom:4px;"
                                data-toggle="modal" data-target="#increaseBAccountLimit">
                            Increase BA Limit
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body text-center">
                <div class="pro-user">
                    @if($users->isVerified ==4)
                        <p class="text-danger" style="font-size:15px;">
                            Verification Details Submitted
                            <a href="{{url('admin/user/view_documents/'.$users->id)}}">
                               View
                            </a>
                        </p>
                    @endif
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <h5 class="description-header mb-1 font-weight-bold">Lv. {{$users->userLevel}}</h5>
                            <span class="text-muted">Level</span>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/users/update_user_level/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-success btn-sm">Upgrade level</a>
                            <a href="{{url('admin/users/downgrade_user_level/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-danger btn-sm">Downgrade level</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/users/activate_two_way/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">Activate 2FA</a>
                            <a href="{{url('admin/users/deactivate_two_way/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-warning btn-sm">Deactivate 2FA</a>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/users/activate_notifications/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">Activate Notification</a>
                            <a href="{{url('admin/users/deactivate_notifications/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-warning btn-sm">Deactivate Notification</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/users/activate_withdrawal/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">Activate Withdrawal</a>
                            <a href="{{url('admin/users/deactivate_withdrawal/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-danger btn-sm">Deactivate Withdrawal</a>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/users/deactivate_user/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-warning btn-sm">Deactivate User</a>
                            <a href="{{url('admin/users/activate_user/'.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">Activate User</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/escrows?sort='.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">View Escrows</a>
                            <a href="{{url('admin/transfers?sort='.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-info btn-sm">View Transfers</a>
                        </div>
                    </div>
                    <div class="col-sm-6 border-right text-center">
                        <div class="description-block p-4">
                            <a href="{{url('admin/account_funding?sort='.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-success btn-sm">View Account Funding</a>
                            <a href="{{url('admin/payment_links?sort='.$users->id)}}" style="margin-bottom:4px;"
                               class="btn btn-outline-info btn-sm">View Payment Link Funding</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer p-0">
                <div class="row">
                    <div class="col-sm-6 text-center mx-auto">
                        <div class="description-block p-4">
                            <button class="btn btn-sm btn-outline-primary" style="margin-bottom:4px;">
                                Send News Letter
                            </button>
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
                                                <td class="py-2 px-0">{{$users->name}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Email </span>
                                                </td>
                                                <td class="py-2 px-0">{{$users->email}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Username </span>
                                                </td>
                                                <td class="py-2 px-0">{{$users->username}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Phone </span>
                                                </td>
                                                <td class="py-2 px-0">{{$users->phoneCode}}{{$users->phone}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Date of Birth </span>
                                                </td>
                                                <td class="py-2 px-0">{{$users->DOB}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Location </span>
                                                </td>
                                                <td class="py-2 px-0">{{$users->country}}</td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Notification Status </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    @if($notification->account_activity ==1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Account Status </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    @if($users->status ==1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                            @if($users->countryCode =='NG')
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Submitted BVN </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        @if($users->hasBvn ==1)
                                                            <span class="badge badge-success">Submitted</span>
                                                        @else
                                                            <span class="badge badge-danger">Unverified</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">Verification </span>
                                                    </td>
                                                    <td class="py-2 px-0">
                                                        @if($users->isVerified ==1)
                                                            <span class="badge badge-success">Verified</span>
                                                        @elseif($users->isVerified == 4)
                                                            <span class="badge badge-info">Submitted</span>
                                                        @else
                                                            <span class="badge badge-danger">Unverified</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">Transfer </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    @if($users->canSend ==1)
                                                        <span class="badge badge-success">Active</span>
                                                    @else
                                                        <span class="badge badge-danger">Deactivated</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="py-2 px-0">
                                                    <span class="font-weight-semibold w-50">2FA </span>
                                                </td>
                                                <td class="py-2 px-0">
                                                    @if($users->twoWay ==1)
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
                                            @foreach($merchantBalances as $balans)
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">{{$balans->code}} B Account Limit </span>
                                                    </td>
                                                    <td class="py-2 px-0">{{$balans->code}} {{number_format($balans->AccountLimit,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <td class="py-2 px-0">
                                                        <span class="font-weight-semibold w-50">{{$balans->code}} B Transaction Limit </span>
                                                    </td>
                                                    <td class="py-2 px-0">{{$balans->code}} {{number_format($balans->TransactionLimit,2)}}</td>
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

        <div class="main-content-body main-content-body-profile mg-b-20">
            <div class="row">
                @forelse($balances as $bal)
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1">
                                    I. Available Balance({{$bal->code}})
                                </p>
                                <h2 class="mb-1 font-weight-bold">
                                    {{number_format($bal->availableBalance,2)}}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1">
                                    I. Pending Balance({{$bal->code}})
                                </p>
                                <h2 class="mb-1 font-weight-bold">
                                    {{number_format($bal->frozenBalance,2)}}
                                </h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <p class="mb-1">
                                    I. Referral Balance({{$bal->code}})
                                </p>
                                <h2 class="mb-1 font-weight-bold">
                                    {{number_format($bal->referralBalance,2)}}
                                </h2>
                            </div>
                        </div>
                    </div>
                @endforeach
                    @forelse($merchantBalances as $bals)
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-1">
                                       B Available Balance({{$bals->code}})
                                    </p>
                                    <h2 class="mb-1 font-weight-bold">
                                        {{number_format($bals->availableBalance,2)}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-1">
                                       B Pending Balance({{$bals->code}})
                                    </p>
                                    <h2 class="mb-1 font-weight-bold">
                                        {{number_format($bals->frozenBalance,2)}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <p class="mb-1">
                                       B Referral Balance({{$bals->code}})
                                    </p>
                                    <h2 class="mb-1 font-weight-bold">
                                        {{number_format($bals->referralBalance,2)}}
                                    </h2>
                                </div>
                            </div>
                        </div>
                @endforeach
            </div>
        </div>

    </div>

    <div class="col-md-6">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Logins As User</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($userLogins)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Ip</th>
                                    <th class="border-bottom-0">Agent</th>
                                    <th class="border-bottom-0">Location</th>
                                    <th class="border-bottom-0">ISP</th>
                                    <th class="border-bottom-0">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($userLogins as $logs)
                                    <tr>
                                        <td>{{$logs->loginIp}}</td>
                                        <td>{{$logs->agent}}</td>
                                        <td>{{$logs->location}}</td>
                                        <td>{{$logs->isp}}</td>
                                        <td>{{$logs->created_at}}</td>
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

    <div class="col-md-6">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">Logins As Merchant</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        @isset($merchantLogins)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Ip</th>
                                    <th class="border-bottom-0">Agent</th>
                                    <th class="border-bottom-0">Location</th>
                                    <th class="border-bottom-0">ISP</th>
                                    <th class="border-bottom-0">Date</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($merchantLogins as $logss)
                                    <tr>
                                        <td>{{$logss->loginIp}}</td>
                                        <td>{{$logss->agent}}</td>
                                        <td>{{$logss->location}}</td>
                                        <td>{{$logss->isp}}</td>
                                        <td>{{$logss->created_at}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{$merchantLogins->links()}}
                        @endisset
                    </div>
                </div>
            </div>
        </div>
        <!--/div-->
    </div>

</div>
</div>

</div><!-- end app-content-->
</div>

@include('dashboard.admin.templates.user_modal')
@include('dashboard.admin.templates.footer')
