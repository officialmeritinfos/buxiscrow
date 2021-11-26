<!-- Show card form-->
<div class="modal" id="new_transfer">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Send Money</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class=" ">
                    <form method="POST" id="initiate-transfer" action="{{url('merchant/new_transfer')}}">
                        @csrf
                        <div class="">
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="card_amount" name="amount">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Account To Debit</label>
                                <select class="form-control" name="currency">
                                    <option value="">Select</option>
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->code}}">{{$currency->currency}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Account To Credit</label>
                                <select class="form-control" name="account_credit">
                                    <option value="">Select</option>
                                    <!--<option value="1">New Account</option>-->
                                    <option value="2">Beneficiary</option>
                                </select>
                            </div>
                            <div class="form-group" id="bene" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Beneficiaries</label>
                                <select class="form-control" name="beneficiaries">
                                    <option value="">Select</option>
                                    @foreach($beneficiaries as $bene)
                                        <option value="{{$bene->id}}">
                                            {{$bene->accountName}} - ({{$bene->bank}})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="bank_credit" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Bank</label>
                                <select class="form-control" name="bank">
                                    <option value="">Select</option>
                                    @foreach($banks as $bank)
                                        <option value="{{$bank->bankCode}}">{{$bank->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group" id="banks" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Bank</label>
                                <input type="text" class="form-control"  name="banks">
                            </div>
                            <div class="form-group" id="acc_number" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Account Number</label>
                                <input type="text" class="form-control" name="acc_number">
                            </div>
                            <div class="form-group" id="acc_name" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Account Name</label>
                                <input type="text" class="form-control"  name="acc_name">
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Bank Code</label>
                                <input type="text" class="form-control"  name="bank_code">
                            </div>
                            <div class="form-group" style="display: none;">
                                <label for="exampleInputEmail1" class="form-label">Beneficiary Number</label>
                                <input type="text" class="form-control"  name="ben_id">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Narration</label>
                                <textarea type="text" class="form-control" name="narration"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="form-label">Account/Transaction Pin</label>
                                <input type="password" class="form-control" name="pin" maxlength="6">
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-outline-success" id="submit_transfer"><i class="fa fa-check-circle"></i> Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
