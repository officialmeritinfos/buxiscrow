
<!-- Show remove business form-->
<div class="modal" id="delete_business">
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
                        You are about removing this Business/Store from your list. Do you wish to continue?
                    </p>
                </div>
                <form method="POST" id="remove_business" action="{{url('merchant/remove-business')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-lg"
                                   id="exampleInputEmail1" name="pin" maxlength="6">
                        </div>
                        <div class="form-group col-md-12"  style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Store Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="store_ref">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-danger text-center mt-4 mb-0" id="remove_store">
                            Remove
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Show generate Api key form-->
<div class="modal" id="generate_api_key">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Generate API Key</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="text-center">
                    <p class="text-center text-info font-weight-bolder" style="font-size: 18px;">
                        Fill the form below before proceeding to generate your API KEY
                    </p>
                </div>
                <form method="POST" id="generate_business_key" action="{{url('merchant/business/generate-key')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Secret Key</label>
                            <input type="text" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="secret_key">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Webhook/IPN Url</label>
                            <input type="url" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="ipn_url">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Allow Withdrawal through Api</label>
                            <select class="form-control form-control-md"
                                   id="exampleInputEmail1" name="allow_withdrawal">
                                   <option value="">Select Option</option>
                                   <option value="1" selected>Allow</option>
                                   <option value="2">Disable</option>
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="pin" maxlength="6">
                        </div>
                        <div class="form-group col-md-12"  style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Store Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="store_ref" value="{{$business->businessRef}}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="generate_api">
                            Generate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@if (!empty($apiKeys))
<!-- Show regenerate Api key form-->
<div class="modal" id="regenerate_api_key">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title">Regenerate API Key</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <div class="text-center">
                    <p class="text-center text-info font-weight-bolder" style="font-size: 18px;">
                        Fill the form below before proceeding to regenerate your API KEY
                    </p>
                </div>
                <form method="POST" id="generate_business_key" action="{{url('merchant/business/regenerate-key')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Secret Key</label>
                            <input type="text" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="secret_key"
                                   value="{{$option->decryptKey($apiKeys->hashKey)}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Webhook/IPN Url</label>
                            <input type="url" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="ipn_url" value="{{$apiKeys->ipn_url}}">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Allow Withdrawal through Api</label>
                            <select class="form-control form-control-md"
                                   id="exampleInputEmail1" name="allow_withdrawal">
                                   @if ($apiKeys->allowWithdrawal ==1)
                                        <option value="1" selected>Allow</option>
                                        <option value="2">Disable</option>
                                    @else
                                        <option value="1">Allow</option>
                                        <option value="2" selected>Disable</option>
                                    @endif
                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-md"
                                   id="exampleInputEmail1" name="pin" maxlength="6">
                        </div>
                        <div class="form-group col-md-12"  style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Store Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="store_ref" value="{{$business->businessRef}}">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-success text-center mt-4 mb-0" id="generate_api">
                            ReGenerate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
