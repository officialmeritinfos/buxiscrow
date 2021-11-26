<!-- Show add new beneficiary form-->
<div class="modal" id="add_new_beneficiary">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Add New Beneficiary</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="new_beneficiary" action="{{url('merchant/add-beneficiary')}}">
                    @csrf
                    <div class="">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Bank</label>
                            <select class="form-control form-control-lg " id="exampleInputEmail1" name="banks">
                                @foreach($banks as $bank)
                                    <option value="{{$bank->bankCode}}">{{$bank->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Currency</label>
                            <select class="form-control form-control-lg " id="exampleInputEmail1" name="currency">
                                @foreach($currencies as $currency)
                                    <option value="{{$currency->code}}">{{$currency->currency}}</option>
                                @endforeach
                            </select>
                            <small class="text-info">All transfer in this currency will be credited to this account.
                                Ensure to set this right</small>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Account Name</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="account_name">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="form-label">Account Number</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="account_number">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="add_beneficiary">
                            <i class="fa fa-plus-square"></i> Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show remove beneficiary form-->
<div class="modal" id="remove_Beneficiary">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="text-center">
                    <p class="text-center text-warning font-weight-bolder" style="font-size: 18px;">
                        You are about removing this Beneficiary from your list. Do you wish to continue?
                    </p>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-danger text-center mt-4 mb-0" id="remove_beneficiary">
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
