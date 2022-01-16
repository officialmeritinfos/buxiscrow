/**
 *
 * @type {{init: paymentRequests.init}}
 */
var paymentRequests = function (){
    var flutterwavePay = function (){
        /**
         *  Show_pay_form shows the payment form
         *  c represents isCard - Helping us detect
         *  if selected method is a card payment.
         */
        $('#show_pay_form').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var currency = button.data('currency');
            var c = button.data('c');
            var id = button.data('id');
            var baseUrl = '';
            var modal = $(this)

            //query for the deposit method
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/get_deposit_method_id/'+id,
                method: "GET",
                data:$(this).serialize(),
                dataType:"json",
                success:function(data)
                {
                    if(data.error)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            $("#show_pay_form").LoadingOverlay("hide");
                            $('#show_pay_form').modal('hide');
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.c == 1){
                            $('#add_money').modal('hide');
                            $('#deposit_method').modal('hide');
                            $('#show_card_form').modal('show');
                            $("#show_pay_form").LoadingOverlay("hide");

                        } else{
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: baseUrl + '/account/dashboard/get_banks_currency/' + currency,
                                method: "GET",
                                data: $(this).serialize(),
                                dataType: "json",
                                beforeSend:function(){
                                    $('#banks').attr('disabled', true);
                                    $("#deposit_method :input").prop("readonly", true);
                                    $("#banks").LoadingOverlay("show",{
                                        text        : "fetching banks",
                                        size        : "20"
                                    });
                                },
                                success: function (response) {
                                    $.each(response.data,function (index,val){
                                        $('select[name="bank"]').append('<option value="' + val.code + '">' + val.name + '</option>');
                                    });
                                    $('#banks').LoadingOverlay('hide');
                                }
                            });
                            $('#show_transfer_form').modal('show');
                            $('#add_money').modal('hide');
                            $('#deposit_method').modal('hide');
                            $("#show_pay_form").LoadingOverlay("hide");
                        }
                    }
                },
            });
        });

    }
    var closeModal = function (){
        $('#show_transfer_form').on('show.bs.modal', function (event) {
            $('#show_pay_form').modal('hide');
        });
        $('#show_transfer_form').on('hide.bs.modal', function (event) {
            $('#show_pay_form').modal('hide');
            $('#add_money').modal('show');
        });
        $('#show_card_form').on('hide.bs.modal', function (event) {
            $('#add_money').modal('show');
            $('#show_pay_form').modal('hide');
        });
        $('#show_card_form').on('show.bs.modal', function (event) {
            $('#show_pay_form').modal('show');
        });
    }
    var getBank = function (){
        $('select[name="bank"]').on('change', function (event) {
            var bankCode =$(this).val();
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/account/dashboard/get_bank/' + bankCode,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#charge").attr('disabled',true);
                },
                success: function (data) {
                    if (data.data.dob ===1 && data.data.hasDob !==1){
                        $("#dob").show();
                    }else{
                        $("#dob").hide();
                    }
                    if (data.data.bvn === 1 && data.data.hasBVN !== 1){
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error('Your BVN is needed before you can fund your account through this channel ');
                    }
                    $("#charge").attr('disabled',false);
                }
            });
        });
    }
    var chargeBank = function (){
        $('#transfer_form').submit(function(e) {
            e.preventDefault();
            var baseUrl = $('#transfer_form').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#transfer_form").LoadingOverlay("show",{
                        text        : "initiating charge",
                        size        : "20"
                    });
                },
                success: function (data) {
                    if(data.error)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            $("#transfer_form").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        if (data.data.auth_url !== 'NO-URL'){
                            var pageTo = data.data.auth_url;
                            $('#charge_otps').attr("href",$pagTo);
                            $('#show_transfer_form').modal('hide');
                            $('#otp_redirect_form').modal('show');
                            $("#transfer_form").LoadingOverlay("hide");
                        }else{
                            $('input[name="ref"]').val(data.data.ref);
                            $('input[name="charge_type"]').val(data.data.payment_type);
                            //timeout
                            setTimeout(function(){
                                $("#transfer_form").LoadingOverlay("hide");
                                $('#show_transfer_form').modal('hide');
                                $('#add_money').modal('hide');
                                $('#otp_form').modal('show');
                            }, 5000);
                        }
                    }
                }
            });
        });
    }
    var completeBankTransfer = function (){
        $('#charge-otp').submit(function(e) {
            e.preventDefault();
            var baseUrl = $('#charge-otp').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#charge-otp :input").prop("readonly", true);
                    $("#submit_otp").LoadingOverlay("show",{
                        text        : "completing transaction",
                        size        : "20"
                    });
                },
                success: function (data) {
                    if(data.error)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.error(data.data.error);
                        //return to natural stage
                        setTimeout(function(){
                            location.reload();
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        //timeout
                        setTimeout(function(){
                            location.reload();
                        }, 5000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    //return to natural stage
                    setTimeout(function(){
                        location.reload();
                    }, 3000);
                }
            });
        });
    }
    var chargeNgnCard = function (){
        $('#initiate-ngn-card').submit(function(e) {
            e.preventDefault();
            var baseUrl = '';
            var amount =  $('#card_amount').val();
            //query for the deposit method
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/account/get_pubkey',
                method: "GET",
                dataType: "json",
                success: function (data) {
                    var pubkey =data.data.publicKey;
                    var ref =data.data.ref;
                    var country =data.data.country;
                    var name =data.data.name;
                    var email =data.data.email;
                    var x = FlutterwaveCheckout({
                        public_key: pubkey,
                        tx_ref: ref,
                        amount: amount,
                        currency: "NGN",
                        country: country,
                        payment_options: "card",
                        customer: {
                            email: email,
                            name: name,
                        },
                        callback: function (data) {
                            var paymentId = data.transaction_id;
                            //send a call our endpoint
                            $.ajax({
                                url: baseUrl + '/account/verify_transaction/'+paymentId,
                                method: "GET",
                                data: data,
                                dataType: "json",
                                beforeSend:function(){
                                    document.getElementsByName('checkout')[0].setAttribute('style',
                                        'position:fixed;top:0;left:0;z-index:-1;border:none;opacity:0;pointer-events:none;width:100%;height:100%;');
                                    document.body.style.overflow = '';
                                    $("#initiate-ngn-card").LoadingOverlay("show",{
                                        text        : "please wait while we verify your payment",
                                        size        : "20"
                                    });
                                },
                                success(responses) {
                                    if (responses.error) {
                                        toastr.options = {
                                            "closeButton": true,
                                            "progressBar": true
                                        }
                                        toastr.error(responses.data.error);
                                        //return to natural stage
                                        setTimeout(function () {
                                            location.reload();
                                        }, 3000);
                                    }
                                    if (responses.success) {
                                        toastr.options = {
                                            "closeButton": true,
                                            "progressBar": true
                                        }
                                        toastr.success(responses.message);
                                        //timeout
                                        setTimeout(function () {
                                            location.reload();
                                        }, 5000);
                                    }
                                },
                                error: function(jqXHR, textStatus, errorThrown){
                                    toastr.options = {
                                        "closeButton" : true,
                                        "progressBar" : true
                                    }
                                    toastr.error(errorThrown);
                                    //return to natural stage
                                    setTimeout(function(){
                                        location.reload();
                                    }, 3000);
                                }

                            });
                        },
                        onclose: function() {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            }
                            toastr.error('Funding cancelled');
                            //timeout
                            setTimeout(function () {
                                location.reload();
                            }, 5000);
                        },
                        customizations: {
                            title: "Account Funding",
                            description: "Payment for item",
                        },
                    });
                }
            });
        });
    }
    return {
        init: function() {
            flutterwavePay();
            closeModal();
            getBank();
            chargeBank();
            completeBankTransfer();
            chargeNgnCard();
        }
    };
}();

jQuery(document).ready(function() {
    paymentRequests.init();
});
