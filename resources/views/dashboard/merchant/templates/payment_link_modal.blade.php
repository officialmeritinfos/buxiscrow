<!-- Payment Link QR -->
<div class="modal" id="download_qr">
    <div class="modal-dialog modal-dialog text-center " role="document">
        <div class="modal-content tx-size-sm">
            <div class="modal-header bg-primary">
                <h4 class="modal-title  text-white tx-semibold" >Download QR Code</h4>
                <button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body text-center p-4" >
                <h4 class="text-info">You can download this QR Code to display to your customers for payment.</h4><br>
                <p class="mg-b-20 mg-x-20">
                    <a href="https://api.qrserver.com/v1/create-qr-code/?data={{url('pay/'.$link->reference)}}"
                       download="barcode" target="_blank">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?data={{url('pay/'.$link->reference)}}">
                    </a>
                </p>
                <p>
                    <a href="https://api.qrserver.com/v1/create-qr-code/?data={{url('pay/'.$link->reference)}}"
                       download="barcode" target="_blank">
                        Download
                    </a>
                </p>
            </div>
        </div>
        <div></div>
    </div>
</div>
