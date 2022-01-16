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
        @if($type =='subscription')
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="new_payment_link" action="{{url('merchant/payment-link/add-payment-link')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="title">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Currency </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="currency">
                                        <option value=""> Select Payment Currency</option>
                                        @foreach($currencies as $curr)
                                            <option value="{{$curr->code}}">{{$curr->currency}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Amount
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Leave empty to allow customers enter desired amount"></i>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="amount">
                                </div>
                                <div class="form-group col-md-6" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Type
                                    </label>
                                    <input type="text" class="form-control form-control-lg" value="2" id="exampleInputEmail1" name="link_type">
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Description
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Describe what this transaction is for"></i>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="description"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Store
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Note that if the business is marked as a cryptocurrency related business,
                                       this transaction will be assumed to be a cryptocurrency transaction. Leave it blank to make it generic"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="store">
                                        <option value=""> Select Store</option>
                                        @foreach($businesses as $business)
                                            <option value="{{$business->id}}">{{$business->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Interval
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Interval of charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="charge_interval">
                                        <option value="">Select Interval</option>
                                        @foreach($intervals as $interval)
                                            <option value="{{$interval->id}}">{{$interval->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Frequency <i class="fa fa-info-circle" data-toggle="tooltip"
                                                     title="Frequency of charge. Leave empty to charge users indefinitely"></i>
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="exampleInputEmail1" name="frequency">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Who Pays Charge <span class="text-danger">*</span>
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Who pays for the charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="who_pays_charge">
                                        <option value=""> Select Who Pays Charge</option>
                                        <option value="1">Merchant</option>
                                        <option value="2">Payer</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display:none;">
                                    <label for="exampleInputEmail1" class="form-label">Redirect Url</label>
                                    <input type="url" class="form-control form-control-lg" id="exampleInputEmail1" name="redirect_url">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning text-center mt-4 mb-0" id="add_payment_link">
                                    <i class="fa fa-plus-square"></i> Create Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @elseif($type == 'one_time')
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="new_payment_link" action="{{url('merchant/payment-link/add-payment-link')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="title">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Currency </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="currency">
                                        <option value=""> Select Payment Currency</option>
                                        @foreach($currencies as $curr)
                                            <option value="{{$curr->code}}">{{$curr->currency}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Amount
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Leave empty to allow customers enter desired amount"></i>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="amount">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Who Pays Charge <span class="text-danger">*</span>
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Who pays for the charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="who_pays_charge">
                                        <option value=""> Select Who Pays Charge</option>
                                        <option value="1">Merchant</option>
                                        <option value="2">Payer</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Interval
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Interval of charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="charge_interval">
                                        <option value="">Select Interval</option>
                                        @foreach($intervals as $interval)
                                            <option value="{{$interval->id}}">{{$interval->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Frequency <i class="fa fa-info-circle" data-toggle="tooltip"
                                                     title="Frequency of charge. Leave empty to charge users indefinitely"></i>
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="exampleInputEmail1" name="frequency">
                                </div>
                                <div class="form-group col-md-6" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Type
                                    </label>
                                    <input type="text" class="form-control form-control-lg" value="1" id="exampleInputEmail1" name="link_type">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Description
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Describe what this transaction is for"></i>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="description"></textarea>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Store
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Note that if the business is marked as a cryptocurrency related business,
                                       this transaction will be assumed to be a cryptocurrency transaction. Leave it blank to make it generic"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="store">
                                        <option value=""> Select Store</option>
                                        @foreach($businesses as $business)
                                            <option value="{{$business->id}}">{{$business->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display:none;">
                                    <label for="exampleInputEmail1" class="form-label">Redirect Url</label>
                                    <input type="url" class="form-control form-control-lg" id="exampleInputEmail1" name="redirect_url">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning text-center mt-4 mb-0" id="add_payment_link">
                                    <i class="fa fa-plus-square"></i> Create Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @elseif($type == 'donation')
            <div class="col-md-6 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" id="new_payment_link" action="{{url('merchant/payment-link/add-payment-link')}}">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Title <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="title">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Currency </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="currency">
                                        <option value=""> Select Payment Currency</option>
                                        @foreach($currencies as $curr)
                                            <option value="{{$curr->code}}">{{$curr->currency}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Amount
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Leave empty to allow customers enter desired amount"></i>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="amount">
                                </div>
                                <div class="form-group col-md-6" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Type
                                    </label>
                                    <input type="text" class="form-control form-control-lg" value="3" id="exampleInputEmail1" name="link_type">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Description
                                        <i class="fa fa-info-circle" data-toggle="tooltip" title="Describe what this transaction is for"></i>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <textarea class="form-control form-control-lg" id="exampleInputEmail1" name="description"></textarea>
                                </div>
                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Interval
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Interval of charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="charge_interval">
                                        <option value="">Select Interval</option>
                                        @foreach($intervals as $interval)
                                            <option value="{{$interval->id}}">{{$interval->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">Who Pays Charge <span class="text-danger">*</span>
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Who pays for the charge"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="who_pays_charge">
                                        <option value=""> Select Who Pays Charge</option>
                                        <option value="1" selected>Merchant</option>
                                        <option value="2">Payer</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-12" style="display: none;">
                                    <label for="exampleInputEmail1" class="form-label">
                                        Frequency <i class="fa fa-info-circle" data-toggle="tooltip"
                                                     title="Frequency of charge. Leave empty to charge users indefinitely"></i>
                                    </label>
                                    <input type="number" class="form-control form-control-lg" id="exampleInputEmail1" name="frequency">
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="exampleInputEmail1" class="form-label">Store
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Note that if the business is marked as a cryptocurrency related business,
                                       this transaction will be assumed to be a cryptocurrency transaction. Leave it blank to make it generic"></i>
                                    </label>
                                    <select type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="store">
                                        <option value=""> Select Store</option>
                                        @foreach($businesses as $business)
                                            <option value="{{$business->id}}">{{$business->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Donation Phone
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="Where Donors can call in"></i>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="phone">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Donation Email
                                        <i class="fa fa-info-circle" data-toggle="tooltip"
                                           title="If there is need to mail"></i>
                                    </label>
                                    <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="email">
                                </div>
                                <div class="form-group col-md-12" style="display:none;">
                                    <label for="exampleInputEmail1" class="form-label">Redirect Url</label>
                                    <input type="url" class="form-control form-control-lg" id="exampleInputEmail1" name="redirect_url">
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-warning text-center mt-4 mb-0" id="add_payment_link">
                                    <i class="fa fa-plus-square"></i> Create Link</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
<!-- /Row -->


<!-- Row -->
</div>
</div><!-- end app-content-->
</div>

@include('dashboard.merchant.templates.footer')
