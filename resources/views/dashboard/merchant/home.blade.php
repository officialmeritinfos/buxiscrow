@include('dashboard.merchant.templates.header')
@if($user->setPin !=1)
    <!--Row-->
    <div class="row" align="center">
        <div class="col-md-2"></div>
        <div class="col-md-8 mt-5 mb-4 introduction">
            <div class="card ">
                <div class="card-body">
                    <h5 class="font-weight-bold text-danger font-40">
                        Your account is insecure. Create a Transaction Pin to protect your account from intruders.
                    </h5>
                    <p class="text-primary">
                        <button class="btn btn-outline-secondary" data-backdrop="static" data-keyboard="false"
                                data-toggle="modal" data-target="#set_pin"><i class="fa fa-shield"></i>
                            Protect Account</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endif
<!--Row-->
<div class="row" align="center">
    <div class="col-md-2"></div>
    <div class="col-md-8 mt-5 mb-4 introduction">
        <div class="card ">
            <div class="card-body">
                <h4 class="font-weight-bolder text-orange font-40">Hi, {{$user->name}} — Welcome to {{config('app.name')}}!</h4>
                @if($user->isVerified ==1)
                    <p class="text-primary">
                        Your account has been verified — this means you can make higher payments until
                        you reach the account limit designated for your account.
                        <br>
                        <b>Note :</b> This limit can be increased upon request by contacting our support.
                    </p>
                @elseif($user->isVerified == 4)
                    <p class="text-info">
                        Your documents are currently being processed. You will receive a feedback here and via mail.
                    </p>
                @elseif($user->isVerified == 3)
                    <p class="text-danger">
                        One or more of your submitted documents has an issue. Please visit
                        <a href="{{url('merchant/documents/error')}}" class="text-blue">here</a> to view the file(s) that is/are
                        flagged.
                    </p>
                @elseif($user->isVerified == 2)
                    <p class="text-danger">
                        Your account is unverified — this means you cannot make certain transactions such as withdrawal etc,
                        and only a lower amount of funds can be transacted through your account.
                        Please visit
                        <a href="{{url('merchant/documents/verify')}}" class="text-blue">here</a> to submit necessary documents.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if($celebrate_ref ==1)
        <div class="col-xl-8 col-md-8 col-lg-8 mx-auto">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-7 col-md-12 col-lg-6">
                            <div class="d-block card-header border-0 text-center px-0">
                                <h2 class="text-center mb-4">Congratulations </h2>
                                <small>You reached {{number_format($referrals)}} referrals</small>
                            </div>
                            <div class="row text-center">
                                <div class="col-md-12">
                                    <h2 class="mb-0 fs-40 counter font-weight-bold">{{number_format($referrals)}}</h2>
                                    <h6 class="mt-4 text-white-50">Thank you for trusting <b>{{config('app.name')}}</b> </h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-5 col-md-12 col-lg-6">
                            <img class="mx-auto text-center w-90" alt="img" src="{{ asset('dashboard/public/assets/images/photos/award.png') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @foreach($balance as $bal)
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-success"></i></span>
                <p class=" mb-1 ">Available Balance </p>
                <h2 class="mb-1 fs-40 font-weight-bold">{{$bal->currency}} {{number_format($bal->availableBalance,2)}}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-danger"></i></span>
                <p class=" mb-1 ">Pending Balance </p>
                <h2 class="mb-1 fs-40 font-weight-bold">{{$bal->currency}} {{number_format($bal->frozenBalance,2)}}</h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12 mx-auto">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-info"></i></span>
                <p class=" mb-1 ">Referral Balance </p>
                <h2 class="mb-1 fs-40 font-weight-bold">{{$bal->currency}} {{number_format($bal->referralBalance,2)}}</h2>
            </div>
        </div>
    </div>
    @endforeach
    <div class="col-xl-12 col-md-12 col-lg-12">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card" data-clickable="true" data-href="{{url('merchant/businesses')}}">
                    <div class="card-body">
                        <i class="fa fa-shopping-basket card-custom-icon icon-dropshadow-primary text-primary fs-60"></i>
                        <p class=" mb-1"></p>
                        <h2 class="mb-1 font-weight-bold">Manage Businesses</h2>
                        <small class="mb-1 text-muted"><span class="text-info">Add, and manage a store</span></small>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card" data-clickable="true" data-href="{{url('merchant/transfers')}}">
                    <div class="card-body" >
                        <i class="mdi mdi-send-secure card-custom-icon icon-dropshadow-warning text-warning fs-60"></i>
                        <p class=" mb-1"></p>
                        <h2 class="mb-1 font-weight-bold">Send Money</h2>
                        <small class="mb-1 text-muted"><span class="text-info">Send money to friends/account</span></small>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card"  data-toggle="modal" data-target="#modaldemo4">
                    <div class="card-body">
                        <i class="mdi mdi-link card-custom-icon icon-dropshadow-info text-info fs-60"></i>
                        <p class=" mb-1"></p>
                        <h2 class="mb-1 font-weight-bold">Payment Link</h2>
                        <small class="mb-1 text-muted"><span class="text-info">Receive money easily from friends</span></small><br>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<!--Row-->
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Most Recent Escrow Transactions</h3>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="table-responsive">
                        <table class="table card-table table-vcenter text-nowrap mb-0 border">
                            <thead>
                            <tr>
                                <th class="wd-lg-10p">Title</th>
                                <th class="wd-lg-20p text-center">Reference</th>
                                <th class="wd-lg-20p text-center">Currency</th>
                                <th class="wd-lg-20p text-center">Amount</th>
                                <th class="wd-lg-20p text-center">Date</th>
                                <th class="text-center">Preview</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($escrows as $escrow)
                                <tr>
                                    <td>{{$escrow->title}}</td>
                                    <td class="text-center">{{$escrow->reference}}</td>
                                    <td class="text-center">{{$escrow->currency}}</td>
                                    <td class="text-center">{{number_format($escrow->amount,2)}} <i class="fa fa-caret-down text-danger"></i></td>
                                    <td class="text-center">{{$escrow->created_at}}</td>
                                    <td class="text-center">
                                        <a href="{{url('account/escrows/'.$escrow->reference.'/details')}}"
                                           class="btn btn-outline-warning"><i class="fa fa-eye"></i> </a>
                                    </td>
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
<!--End row-->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.dashboard_modal')
@include('dashboard.merchant.templates.footer')
