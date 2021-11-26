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

