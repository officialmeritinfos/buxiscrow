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
    <div class="col-12">
        <!--div-->
        <div class="card">
            <div class="card-header">
                <div class="card-title">{{$pageName}}</div>
            </div>
            <div class="card-body">
                <div class="">
                    <div class="text-center">
                        <button class="btn btn-sm btn-info text-center" data-toggle="modal"
                        data-target="#add_faq">Add Currency</button>
                    </div>
                    <div class="table-responsive">
                        @isset($currencies)
                            <table id="example" class="table table-bordered text-nowrap key-buttons">
                                <thead>
                                <tr>
                                    <th class="border-bottom-0">Currency</th>
                                    <th class="border-bottom-0">Code</th>
                                    <th class="border-bottom-0">country</th>
                                    <th class="border-bottom-0">USD Rate</th>
                                    <th class="border-bottom-0">NGN Rate</th>
                                    <th class="border-bottom-0">Charge</th>
                                    <th class="border-bottom-0">Base Charge</th>
                                    <th class="border-bottom-0">Min Charge</th>
                                    <th class="border-bottom-0">Max Charge</th>
                                    <th class="border-bottom-0">Internal Charge</th>
                                    <th class="border-bottom-0">Minimum Send Money Charge</th>
                                    <th class="border-bottom-0">Maximum Send Money Charge</th>
                                    <th class="border-bottom-0">Non-Escrow Charge</th>
                                    <th class="border-bottom-0">Minimum Non-Escrow Charge</th>
                                    <th class="border-bottom-0">Maximum Non-Escrow Charge</th>
                                    <th class="border-bottom-0">Verified Business Limit</th>
                                    <th class="border-bottom-0">Unverified Business Limit</th>
                                    <th class="border-bottom-0">Verified Individual Limit</th>
                                    <th class="border-bottom-0">Unverified Individual Limit</th>
                                    <th class="border-bottom-0">Verified Business Transaction Limit</th>
                                    <th class="border-bottom-0">Unverified Business Transaction Limit</th>
                                    <th class="border-bottom-0">Verified Individual Transaction Limit</th>
                                    <th class="border-bottom-0">Unverified Individual Transaction Limit</th>
                                    <th class="border-bottom-0">Settlement Period</th>
                                    <th class="border-bottom-0">Status</th>
                                    <th class="border-bottom-0">Date Added</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($currencies as $curr)
                                    <tr>
                                        <td>{{$curr->currency}}</td>
                                        <td>{{$curr->code}}</td>
                                        <td>{{$curr->country}}</td>
                                        <td>{{$curr->rateUsd}}</td>
                                        <td>{{$curr->rateNGN}}</td>
                                        <td>{{$curr->charge}}%</td>
                                        <td>{{$curr->baseCharge}}</td>
                                        <td>{{$curr->minCharge}}</td>
                                        <td>{{number_format($curr->maxCharge,2)}}</td>
                                        <td>{{$curr->internalCharge}}%</td>
                                        <td>{{$curr->sendMoneyChargeMin}}</td>
                                        <td>{{number_format($curr->sendMoneyChargeMax,2)}}</td>
                                        <td>{{$curr->nonEscrowCharge}}%</td>
                                        <td>{{$curr->nonEscrowChargeMin}}</td>
                                        <td>{{number_format($curr->nonEscrowChargeMax,2)}}</td>
                                        <td>{{number_format($curr->verifiedBusinessLimit,2)}}</td>
                                        <td>{{number_format($curr->unverifiedBusinessLimit,2)}}</td>
                                        <td>{{number_format($curr->verifiedIndividualLimit,2)}}</td>
                                        <td>{{number_format($curr->unverifiedIndividualLimit,2)}}</td>
                                        <td>{{number_format($curr->verifiedBusinessTransactionLimit,2)}}</td>
                                        <td>{{number_format($curr->unverifiedBusinessTransactionLimit,2)}}</td>
                                        <td>{{number_format($curr->verifiedIndividualTransactionLimit,2)}}</td>
                                        <td>{{number_format($curr->unverifiedIndividualTransactionLimit,2)}}</td>
                                        <td>{{$curr->settlementPeriod}}</td>
                                        <td>
                                            @switch($curr->status)
                                                @case(1)
                                                <span class="badge badge-success">Active</span>
                                                @break
                                                @default
                                                <span class="badge badge-dark">Inactive</span>
                                            @endswitch
                                        </td>
                                        <td>{{$curr->created_at}}</td>
                                        <td>
                                            <a href="{{url('admin/currency/edit/'.$curr->id)}}" class="btn btn-outline-info">
                                                <i class="fa fa-edit"></i>
                                            </a>
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

<!-- Add Faq-->
<div class="modal" id="add_faq">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Add Currency</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('admin/currency/add')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Currency</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="currency">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Code</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="code" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Country</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="country" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">USD Rate</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="usd_rate">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">NGN Rate</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="ngn_rate">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Base Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="base_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="min_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="max_charge" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Internal Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="internal_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Send Money Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="min_send_money_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Send Money Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="max_send_money_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Non-Escrow Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonescrow_charge">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Non-Escrow Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonEscrowChargeMax">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Non-Escrow  Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonEscrowChargeMin">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Business Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedBusinessLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Business Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedBusinessLimit" >
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Individual Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedIndividualLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Individual Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedIndividualLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Business Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedBusinessTransactionLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Business Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedBusinessTransactionLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Individual Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedIndividualTransactionLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Individual Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedIndividualTransactionLimit">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Settlement Period</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="settlementPeriod" >
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Status <span class="text-red">*</span></label>
                                <select class="form-control form-control-lg" name="status">
                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="2">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary mt-4 mb-0">Submit</button>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
@include('dashboard.admin.templates.footer')
