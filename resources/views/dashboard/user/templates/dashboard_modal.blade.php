<!-- Payment Link -->
<div class="modal" id="modaldemo4">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-body text-center p-4" >
                <h4 class="text-primary tx-semibold">Receive Payments!</h4>
                    <p class="mg-b-20 mg-x-20">
                        <div class="input-group text-center">
                            <input type="text" class="form-control"readonly id="link" value="{{url('send-money/'.strtolower($user->userRef))}}">
                        </div><br>
                        <div class="clipboard-icon" data-clipboard-target="#link">
                            <svg class="svg-icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
                                <path d="M0 0h24v24H0V0z" fill="none"/><path d="M14 7H8v14h11v-9h-5z" opacity=".3"/>
                                <path d="M16 1H4c-1.1 0-2 .9-2 2v14h2V3h12V1zm-1 4H8c-1.1 0-1.99.9-1.99 2L6 21c0 1.1.89 2 1.99 2H19c1.1 0 2-.9 2-2V11l-6-6zm4 16H8V7h6v5h5v9z"/>
                            </svg>
                        </div>
                    </p>
            </div>
        </div>
        <div></div>
    </div>
</div>

<!-- Top Up Balance -->
<div class="modal" id="add_money">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Which Account Would you Like to Fund?</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="row">
                    @foreach($balances as $balance)
                        <div class="col-lg-6">
                            <div class="card bg-primary text-white" data-backdrop="static"
                                 data-keyboard="false"  data-toggle="modal"
                                 data-target="#deposit_method" data-value="{{$balance->code}}">
                                <div class="card-body text-center">
                                    <span class="icon font-40"><i class="flag flag-{{$balance->country}}
                                            icon-dropshadow-danger text-success"></i></span>
                                    <p class=" mb-1 ">{{$balance->currency}} </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div></div>
    </div>
</div>

<!-- Deposit Methods for each currency -->
<div class="modal" id="deposit_method">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">How Would you Like to Fund?</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="row card-holder" id="card-holder">

                </div>
            </div>
        </div>
        <div></div>
    </div>
</div>

<!-- Withdraw Referral -->
<div class="modal" id="withdraw_ref">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Withdraw Your Referral Balance</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="" id="convert_ref">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-orange" id="convert_referral">
                                    <i class="fa fa-recycle"></i> Convert</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>

<!-- Show Form for Payment depending on the selected payment method -->
<div class="modal" id="show_pay_form">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Payment Form</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="row card-holder" id="form-holder">

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Show bank transfer form-->
<div class="modal" id="show_transfer_form">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Fund Account By Bank Transfer</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="transfer_form" action="{{url('account/dashboard/bank-transfer')}}">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="phone" value="{{$user->phone}}">
                            <small class="text-danger">Mobile number tied to account</small>
                        </div>
                        <div class="form-group" id="banks">
                            <label for="exampleInputEmail1" class="form-label">Bank</label>
                            <select class="form-control form-control-lg " id="exampleInputEmail1" name="bank">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="account_number">
                        </div>
                        <div class="form-group" style="display:none;" id="dob">
                            <label for="exampleInputEmail1" class="form-label">Date of Birth</label>
                            <input type="date" class="form-control" id="exampleInputEmail1" name="dob">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Amount</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="amount">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="charge">
                            <i class="fa fa-bank"></i> Charge</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show otp form-->
<div class="modal" id="otp_form">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Fund Account By Bank Transfer</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="charge-otp" action="{{url('account/dashboard/charge-otp')}}">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">OTP</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="otp">
                            <small class="text-danger">OTP sent to mobile phone</small>
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="exampleInputEmail1" class="form-label">ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1" name="ref">
                        </div>
                        <div class="form-group" style="display:none;">
                            <label for="exampleInputEmail1" class="form-label">type</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="charge_type">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="submit_otp">
                            <i class="fa fa-check-circle"></i> Complete</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Show otp redirect form-->
<div class="modal" id="otp_redirect_form">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Fund Account By Bank Transfer</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-center p-4" >
                <p>You will be redirected to your bank page to complete this transaction </p><br>
                <a href="" class="btn btn-orange text-center mt-4 mb-0" id="charge_otps">
                    <i class="fa fa-check-circle"></i> Complete Transaction</a>
            </div>
        </div>
    </div>
</div>

<!-- Show card form-->
<div class="modal" id="show_card_form">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Pay Card</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class=" ">
                    <form method="POST" id="initiate-ngn-card" action="{{url('account/dashboard/charge_ngn_card')}}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="card_amount" name="amount">
                                <small class="text-danger">Amount to Fund account</small>
                            </div>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="initiate_ngn_card">
                                <i class="fa fa-check-circle"></i> Initiate</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Convert To NGn -->
<div class="modal" id="convert_balance">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Convert Your Referral Balance</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="" id="convert_to_ngn">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                                <span class="text-orange">1 <span id="curr"></span> = <span id="rate"></span> NGN</span>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Currency <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Currency"
                                       name="currency">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-orange" id="convert_currency">
                                    <i class="fa fa-recycle"></i> Convert</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>

<!-- Convert Referral Balance with specific currency -->
<div class="modal" id="convert_referral_spcific">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content">
            <div class="modal-header text-center">
                <h1 class="modal-title">Convert Your Referral Balance</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="" id="convert_referral_specific">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Amount"
                                       name="amount">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Currency <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Currency"
                                       name="currency">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn  btn-md btn-orange" id="convert_ref_specific">
                                    <i class="fa fa-recycle"></i> Convert</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div></div>
    </div>
</div>
