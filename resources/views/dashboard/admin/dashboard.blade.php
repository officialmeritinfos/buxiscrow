@include('dashboard.admin.templates.header')
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
<div class="row">
    <div class="col-xl-3 col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-success"></i></span>
                <p class=" mb-1 ">Total Escrows </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($escrows->count(),2)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-info text-info"></i></span>
                <p class=" mb-1 ">Active Escrow </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($active_escrows,2)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-success text-success"></i></span>
                <p class=" mb-1 ">Completed Escrow </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($completed_escrows,2)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-3 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-wallet icon-dropshadow-danger text-danger"></i></span>
                <p class=" mb-1 ">Cancelled Escrow </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($cancelled_escrows,2)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-user icon-dropshadow-primary text-primary"></i></span>
                <p class=" mb-1 ">Total Users </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($total_users,1)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-user icon-dropshadow-success text-success"></i></span>
                <p class=" mb-1 ">Active Users </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($active_users,1)}}
                </h2>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-lg-4 col-md-12">
        <div class="card">
            <div class="card-body text-center">
                <span class="fs-50 icon-muted"><i class="si si-user icon-dropshadow-warning text-warning"></i></span>
                <p class=" mb-1 ">Inactive Users </p>
                <h2 class="mb-1 fs-40 font-weight-bold">
                    {{number_format($inactive_users,1)}}
                </h2>
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

@include('dashboard.admin.templates.footer')
