<!-- Add Escrow Delivery Service Providers-->
<div class="modal" id="add-delivery-service">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="add_delivery_service" action="{{url('merchant/add-escrow-delivery-service')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Country</label>
                            <select class="form-control form-control-lg"
                                   id="exampleInputEmail1" name="country" >

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">State</label>
                            <select class="form-control form-control-lg"
                                    id="exampleInputEmail1" name="state" >

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">City</label>
                            <select class="form-control form-control-lg"
                                    id="exampleInputEmail1" name="city" >

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Delivery Service</label>
                            <select class="form-control form-control-lg"
                                    id="exampleInputEmail1" name="service" >

                            </select>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Delivery Point</label>
                            <textarea class="form-control form-control-lg"
                                    id="exampleInputEmail1" name="address" ></textarea>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Ecrow Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="ref">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-success text-center mt-4 mb-0" id="add_logistics">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Cancel Escrow Transaction-->
<div class="modal" id="cancel_transaction">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="cancel_escrow" action="{{url('merchant/cancel-escrow')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 text-center text-info">
                            <p>
                                Do you really want to cancel this transaction? Every payment made will be refunded to your customer.<br>
                                This cannot be undone!
                            </p>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Escrow Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="ref">
                        </div>
                        <div class="form-group col-md-12" >
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="pin" maxlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-danger text-center mt-4 mb-0" id="cancel_escrows">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Complete Escrow Transaction-->
<div class="modal" id="markDelivered">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="complete_escrow" action="{{url('merchant/complete-escrow')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 text-center text-info">
                            <p>
                                Clicking the button below will mark this transaction as delivered by Merchant.<br>
                                <b>Note:</b> Once this is done, it cannot be undone - If you are using one of our delivery
                                partners,the delivery status will be automatically updated to delivered.
                            </p>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Escrow Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="ref">
                        </div>
                        <div class="form-group col-md-12" >
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="pin" maxlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-success text-center mt-4 mb-0" id="complete_escrows">
                            Complete
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Refund Escrow Transaction-->
<div class="modal" id="refundPayment">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="refund_escrow" action="{{url('merchant/refund-escrow')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 text-center text-info">
                            <p>
                                Clicking the button below will refund this transaction and cancel the transaction. Do you really want to proceed?
                            </p>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Escrow Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="ref">
                        </div>
                        <div class="form-group col-md-12" >
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="pin" maxlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-warning text-center mt-4 mb-0" id="refund_escrows">
                            Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
