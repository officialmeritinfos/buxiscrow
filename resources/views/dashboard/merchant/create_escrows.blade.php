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
        <div class="col-md-10 mx-auto">
            <div class="card">
                <div class="card-body">
                    <form method="POST" id="new_escrow" action="{{url('merchant/add-escrow')}}">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Transaction Title</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="title">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Currency</label>
                                <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="currency">
                                    <option value=""> Select Payment Currency</option>
                                    @foreach($currencies as $curr)
                                        <option value="{{$curr->code}}">{{$curr->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="amount">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Who Pays Charge
                                    <i class="fa fa-info-circle" data-toggle="tooltip"
                                       title="Who pays for the charge"></i>
                                </label>
                                <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="who_pays_charge">
                                    <option value=""> Select Who Pays Charge</option>
                                    <option value="1">Merchant</option>
                                    <option value="2">Buyer</option>
                                    <option value="3">Both</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6" style="display: none;" id="charge_paid_by_merchant">
                                <label for="exampleInputEmail1" class="form-label">Percent Charge Paid by Merchant</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="charge_paid_by_merchant">
                            </div>
                            <div class="form-group col-md-6" style="display: none;" id="charge_paid_by_buyer">
                                <label for="exampleInputEmail1" class="form-label">Percent Charge Paid by Buyer</label>
                                <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="charge_paid_by_buyer">
                            </div>
                            <div class="form-group col-md-12 text-center text-danger">
                                <label for="exampleInputEmail1" class="form-label" id="percentWarning" style="display: none;">The percentage must equal 100%</label>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1" class="form-label">Description
                                    <i class="fa fa-info-circle" data-toggle="tooltip" title="Describe what this transaction is for"></i>
                                </label>
                                <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="description"></textarea>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Store
                                    <i class="fa fa-info-circle" data-toggle="tooltip"
                                       title="Note that if the business is marked as a cryptocurrency related business,
                                       this transaction will be assumed to be a cryptocurrency transaction."></i>
                                </label>
                                <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="store">
                                    <option value=""> Select Store</option>
                                    @foreach($businesses as $business)
                                        <option value="{{$business->id}}">{{$business->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Payer Email
                                    <i class="fa fa-info-circle" data-toggle="tooltip"
                                       title="Payer must be a registered user on {{$web->siteName}}. If the user is not registered,
                                       please use the create invoice feature."></i>
                                </label>
                                <input type="email" class="form-control form-control-lg" id="exampleInputEmail1" name="email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Deadline
                                    <i class="fa fa-info-circle" data-toggle="tooltip"
                                       title="This is the time you are expected to deliver the goods/services.
                                       If you miss to update this delivery on this day, all payment will be refunded to the buyer."></i>
                                </label>
                                <input type="date" class="form-control form-control-lg" id="exampleInputEmail1" name="deadline">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="exampleInputEmail1" class="form-label">Inspection Period
                                    <i class="fa fa-info-circle" data-toggle="tooltip"
                                       title="The date after which the transaction is marked as completed and funds released to you.
                                       Must be up to 24 Hours from deadline above"></i>
                                </label>
                                <input type="date" class="form-control form-control-lg" id="exampleInputEmail1" name="inspection">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="exampleInputEmail1" class="form-label">Escrow Charge:
                                    <span id="esc_charge" class="font-weight-bolder"></span><span id="perc" class="font-weight-bolder"></span>
                                </label>
                                <label for="exampleInputEmail1" class="form-label">Min Charge:
                                    <span id="curr" class="font-weight-bolder"></span> <span id="min_charge" class="font-weight-bolder"></span>
                                </label>
                                <label for="exampleInputEmail1" class="form-label">Max Charge:
                                    <span id="currs" class="font-weight-bolder"></span> <span id="max_charge" class="font-weight-bolder"></span>
                                </label>
                                <label for="exampleInputEmail1" class="form-label">Total Charge:
                                    <span id="curre" class="font-weight-bolder"></span> <span id="tot_esc_charge" class="font-weight-bolder"></span>
                                </label>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="add_escrow">
                                <i class="fa fa-plus-square"></i> Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Row -->



</div>
</div><!-- end app-content-->
</div>
@include('dashboard.merchant.templates.business_modal')
@include('dashboard.merchant.templates.footer')
