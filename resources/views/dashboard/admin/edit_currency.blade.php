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

@inject('option','App\Custom\CustomChecks')
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 mx-auto">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$pageName}}</h4>
            </div>
            <div class="card-body">
                <form method="POST" action="{{url('admin/currency/edit')}}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Currency</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="currency" value="{{$currency->currency}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Code</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="code" value="{{$currency->code}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Country</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="country" value="{{$currency->country}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">USD Rate</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="usd_rate" value="{{$currency->rateUsd}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">NGN Rate</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="ngn_rate" value="{{$currency->rateNGN}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="charge" value="{{$currency->charge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Base Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="base_charge" value="{{$currency->baseCharge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="min_charge" value="{{$currency->minCharge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="max_charge" value="{{$currency->maxCharge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Internal Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="internal_charge" value="{{$currency->internalCharge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Send Money Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="min_send_money_charge" value="{{$currency->sendMoneyChargeMin}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Send Money Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="max_send_money_charge" value="{{$currency->sendMoneyChargeMax}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Non-Escrow Charge(%)</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonescrow_charge" value="{{$currency->nonEscrowCharge}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Maximum Non-Escrow Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonEscrowChargeMax" value="{{$currency->nonEscrowChargeMax}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Minimum Non-Escrow  Charge</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="nonEscrowChargeMin" value="{{$currency->nonEscrowChargeMin}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Business Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedBusinessLimit" value="{{$currency->verifiedBusinessLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Business Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedBusinessLimit" value="{{$currency->unverifiedBusinessLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Individual Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedIndividualLimit" value="{{$currency->verifiedIndividualLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Individual Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedIndividualLimit" value="{{$currency->unverifiedIndividualLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Business Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedBusinessTransactionLimit" value="{{$currency->verifiedBusinessTransactionLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Business Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedBusinessTransactionLimit" value="{{$currency->unverifiedBusinessTransactionLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Verified Individual Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="verifiedIndividualTransactionLimit" value="{{$currency->verifiedIndividualTransactionLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Unverified Individual Transaction Limit</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="unverifiedIndividualTransactionLimit" value="{{$currency->unverifiedIndividualTransactionLimit}}">
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6 text-center">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Settlement Period</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                name="settlementPeriod" value="{{$currency->settlementPeriod}}">
                            </div>
                        </div>

                        <div class="form-group" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">id</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                            placeholder="Enter title"
                            name="id" value="{{$currency->id}}">
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
    </div>
</div>

</div>
</div><!-- end app-content-->
</div>


@include('dashboard.admin.templates.footer')
