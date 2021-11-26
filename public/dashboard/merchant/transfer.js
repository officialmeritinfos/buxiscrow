/**
 *
 * @type {{init: transferRequest.init}}
 */
var transferRequest = function () {
    var showOptions = function (){
        $('select[name="currency"]').on('change',function(e) {
            var currency = $(this).val();
            var account_credit = $('select[name="account_credit"]').val();
            if (currency === 'NGN'){
                $('#route_number').hide()
            }else{
                $('#route_number').show()
            }

        });
    }
    var showAccountToCredit = function (){
        $('select[name="account_credit"]').on('change',function(e) {
            var account_credits = $(this).val();

            if (account_credits === '2'){
                $('#bank_credit').hide();
                $('#acc_number').hide();
                $('#acc_name').hide();
                $('#bene').show();
            }else if (account_credits === '1'){
                $('#bank_credit').show();
                $('#acc_number').show();
                $('#acc_name').show();
                $('#banks').hide();
                $('#bene').hide();
                $('#route_number').hide();
            }
        });
    }
    var getBeneficiaryDetails = function (){
        $('select[name="beneficiaries"]').on('change',function(e) {
            var beneficiary = $(this).val();
            var baseUrl = '';
            $('#banks').show();
            $('#acc_number').show();
            $('#acc_name').show();
            //query for the deposit method
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/merchant/get_beneficiary/'+beneficiary,
                method: "GET",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $("#initiate-transfer :input").prop("readonly", true);
                    $("#acc_number").LoadingOverlay("show",{
                        text        : "Fetching account number",
                        size        : "20"
                    });
                    $("#acc_number").LoadingOverlay("show",{
                        text        : "loading account name",
                        size        : "20"
                    });
                    $("#banks").LoadingOverlay("show",{
                        text        : "getting bank",
                        size        : "20"
                    });
                },
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
                            $("#initiate-transfer :input").prop("readonly", false);
                            $("#acc_number").LoadingOverlay("hide");
                            $("#acc_number").LoadingOverlay("hide");
                            $("#banks").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        //auto fill the form
                        $('input[name="acc_number"]').val(data.data.account_number);
                        $('input[name="acc_name"]').val(data.data.account_name);
                        $('input[name="bank_code"]').val(data.data.bank_code);
                        $('input[name="ben_id"]').val(data.data.ben_id);
                        $('input[name="banks"]').val(data.data.bank);

                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);

                        $("#acc_number").LoadingOverlay("hide");
                        $("#acc_number").LoadingOverlay("hide");
                        $("#banks").LoadingOverlay("hide");

                        $("#initiate-transfer :input").prop("readonly", false);
                    }
                },
            });
        });
    }
    var newTransfer = function () {
        $('#initiate-transfer').submit(function(e) {
            e.preventDefault();
            var baseUrl = $('#initiate-transfer').attr('action');
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
                    $("#initiate-transfer :input").prop("readonly", true);
                    $("#initiate-transfer").LoadingOverlay("show",{
                        text        : "processing",
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
                            $("#initiate-transfer").LoadingOverlay("hide");
                            $("#initiate-transfer :input").prop("readonly", false);
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
                        $("#initiate-transfer").LoadingOverlay("hide");
                        $("#initiate-transfer :input").prop("readonly", false);
                        location.reload();
                    }, 3000);
                }
            });
        });
    }
    var addBeneficiary = function () {
        $('#new_beneficiary').submit(function(e) {
            e.preventDefault();
            var baseUrl=$('#new_beneficiary').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#add_beneficiary').attr('disabled', true);
                    $("#new_beneficiary :input").prop("readonly", true);
                    $("#add_beneficiary").LoadingOverlay("show",{
                        text        : "adding",
                        size        : "20"
                    });
                },
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
                            $('#add_beneficiary').attr('disabled', false);
                            $("#new_beneficiary :input").prop("readonly", false);
                            $("#add_beneficiary").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#add_beneficiary').attr('disabled', false);
                            $("#new_beneficiary :input").prop("readonly", false);
                            $("#add_beneficiary").LoadingOverlay("hide");
                            location.reload();
                        }, 3000);
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
                        $('#new_beneficiary :input').attr('disabled', false);
                        $("#add_beneficiary").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var removeBeneficiary = function () {
        $('#remove_Beneficiary').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var benId = button.data('id');
            var nameBen = button.data('name');
            var modal = $(this)
            modal.find('.modal-title').text('Remove '+nameBen+' from Beneficiary List');
            $('#remove_beneficiary').click(function (e) {
                var baseUrl = '';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: baseUrl+'/merchant/remove-beneficiary/'+benId,
                    method: "POST",
                    data: $(this).serialize(),
                    dataType: "json",
                    beforeSend: function () {
                        $('#remove_beneficiary').attr('disabled', true);
                        $("#remove_beneficiary").LoadingOverlay("show", {
                            text: "removing",
                            size: "20"
                        });
                    },
                    success: function (data) {
                        if (data.error) {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            }
                            toastr.error(data.data.error);
                            //return to natural stage
                            setTimeout(function () {
                                $('#remove_beneficiary').attr('disabled', false);
                                $("#remove_beneficiary").LoadingOverlay("hide");
                            }, 3000);
                        }
                        if (data.success) {
                            toastr.options = {
                                "closeButton": true,
                                "progressBar": true
                            }
                            toastr.success(data.message);
                            //return to natural stage
                            setTimeout(function () {
                                $('#remove_beneficiary').attr('disabled', false);
                                $("#remove_beneficiary").LoadingOverlay("hide");
                                location.reload();
                            }, 3000);
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
                            $('#remove_beneficiary').attr('disabled', false);
                            $("#remove_beneficiary").LoadingOverlay("hide");
                        }, 3000);
                    }

                });
            });
        });
    }

    return {
        init: function() {
            newTransfer();
            showOptions();
            showAccountToCredit();
            getBeneficiaryDetails();
            addBeneficiary();
            removeBeneficiary();
        }
    };
}();

jQuery(document).ready(function() {
    transferRequest.init();
});
