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
                <form method="POST" id="complete_escrow" action="{{url('account/complete-escrow')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 text-center text-info">
                            <p>
                                Clicking the button below will mark this transaction as delivered by Merchant.<br>
                                <b>Note:</b> Once this is done, it cannot be undone - and funds will be delivered to the merchant.
                                Also note that once a transaction is marked as completed and funds disbursed, there can never be
                                refund of the same.
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

<!-- Report Escrow Transaction-->
<div class="modal" id="reportTransaction">
    <div class="modal-dialog modal-dialog-centered text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header">
                <h1 class="modal-title"></h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body text-left p-4" >
                <form method="POST" id="report_escrow" action="{{url('account/report-escrow')}}">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-12 text-center text-danger">
                            <p>
                                Clicking the button below will report this transaction. We advise you contact your seller first before
                                taking this action as this will escalate the issue to our complaint department.
                            </p>
                        </div>
                        <div class="form-group col-md-12" style="display: none;">
                            <label for="exampleInputEmail1" class="form-label">Escrow Ref</label>
                            <input type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="ref">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputEmail1" class="form-label">Reason</label>
                            <textarea type="text" class="form-control form-control-lg" id="exampleInputEmail1"
                                      name="ref" rows="5"></textarea>
                        </div>
                        <div class="form-group col-md-12" >
                            <label for="exampleInputEmail1" class="form-label">Account Pin</label>
                            <input type="password" class="form-control form-control-lg" id="exampleInputEmail1"
                                   name="pin" maxlength="6">
                        </div>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-outline-warning text-center mt-4 mb-0" id="report_escrows">
                            Report
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
