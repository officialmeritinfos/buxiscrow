<!-- Send Business Money  -->
<div class="modal" id="sendMoney">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Send Money To {{$business->name}}</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" action="{{url('account/merchant/send-money')}}" id="send_money">
                    <div class="row">
                        <div class="col-sm-12 col-md-12 text-justify ">
                            <div class="form-group">
                                <div class="alert alert-info" role="alert">
                                    <button type="button" class="close"
                                            data-dismiss="alert" aria-hidden="true">×</button>
                                        Money transferred from an account to business is not held
                                        in escrow. This means that the merchant will receive the money instantly.
                                        Only Use this option if you know the merchant or are recieving your goods
                                        at the spot.
                                </div>
                            </div>
                        </div>
                        @csrf
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Amount <span class="text-red">*</span></label>
                                <input type="text"  class="form-control form-control-lg"
                                       placeholder="Amount To Send" name="amount" autocomplete="false">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Account To Debit <span class="text-red">*</span></label>
                                <select  class="form-control form-control-lg "name="currency">
                                    <option value="">Select Account to Debit</option>
                                    @foreach($balances as $balance)
                                        <option value="{{$balance->currency}}">{{$balance->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="form-label">Transaction Pin <span class="text-red">*</span></label>
                                <input type="password" class="form-control form-control-lg "
                                       placeholder="Enter your Account Pin to Proceed"
                                       name="pin" maxlength="6">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12" style="display: none;">
                            <div class="form-group">
                                <label class="form-label">Business Reference <span class="text-red">*</span></label>
                                <input type="text" class="form-control form-control-lg " placeholder="Reference"
                                       name="ref" value="{{$business->businessRef}}" readonly>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-12 text-center">
                            <div class="form-group">
                                <button type="submit" class="btn btn-sm btn-outline-success"
                                        id="sendBusinessMoney">
                                    <i class="fa fa-send"></i></button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
