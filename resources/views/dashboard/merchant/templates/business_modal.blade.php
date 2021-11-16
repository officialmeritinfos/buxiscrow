
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
