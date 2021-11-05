var dashboardRequests = function (){
    var accountFunding = function (){
        $('#deposit_method').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var currency = button.data('value')
            var baseUrl = '';
            var modal = $(this)
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/get_deposit_method/'+currency,
                method: "GET",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#deposit_method :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "retrieving data",
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
                            $('#submit').attr('disabled', false);
                            $("#submit").LoadingOverlay("hide");
                            $("#deposit_method :input").prop("readonly", false);
                            $("#deposit_method")[0].reset();
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#card-holder').empty();
                        $.each(data.data,function (index,val){
                            $('#card-holder').append(
                                '<div class="col-lg-6" id="cards"><div class="card w-100 bg-primary text-white" data-backdrop="static" data-keyboard="false" ' +
                                'data-toggle="modal" ' +
                                'data-target="#show_pay_form" data-id="'+val.ids+'" data-currency="'+val.currency+'" data-c="'+val.c+'">' +
                                '<div class="card-body text-center">' +
                                '<span class="icon font-40"><i class="'+val.icon+' icon-dropshadow-danger text-success"></i>' +
                                '</span>' +
                                '<p>'+val.name+'</p></div></div></div>'
                            );
                        });
                    }
                },
            });
            $('#add_money').modal('hide');
        });
    }
    var setPin = function () {
        $('#pin').pincodeInput({
            inputs: 6,
            placeholders:"0 0 0 0 0 0"
        });
        $('#pin1').pincodeInput({
            inputs: 6,
            placeholders:"0 0 0 0 0 0"
        });
        $('#set_trans_pin').submit(function(e) {
            e.preventDefault();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/set_pin/',
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit_pin').attr('disabled', true);
                    $("#set_trans_pin :input").prop("readonly", true);
                    $("#submit_pin").LoadingOverlay("show",{
                        text        : "initiating",
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
                            $('#submit_pin').attr('disabled', false);
                            $("#set_trans_pin :input").prop("readonly", false);
                            $("#submit_pin").LoadingOverlay("hide");
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
                            $('#submit_pin').attr('disabled', false);
                            $("#set_trans_pin :input").prop("readonly", false);
                            $("#submit_pin").LoadingOverlay("hide");
                            location.reload();
                        }, 3000);
                    }
                },

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
                    url: baseUrl+'/account/remove-beneficiary/'+benId,
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

                });
            });
        });
    }
    var convertReferral = function (){
        $('#convert_ref').submit(function(e) {
            e.preventDefault();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/convert_referral/',
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#convert_referral').attr('disabled', true);
                    $("#convert_referral").LoadingOverlay("show",{
                        text        : "CONVERTING",
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
                            $('#convert_referral').attr('disabled', false);
                            $("#convert_referral").LoadingOverlay("hide");
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
                            $('#convert_referral').attr('disabled', false);
                            $("#convert_referral").LoadingOverlay("hide");
                            location.reload();
                        }, 3000);
                    }
                },

            });
        });
    }
    var getConversionToNGNDetails = function (){
        $('#convert_balance').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var currency = button.data('currency')
            var baseUrl = '';
            var modal = $(this);
            modal.find('.modal-title').text('Convert your '+currency+' balance to NGN');
            $('input[name="currency"]').val(currency);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/get_specific_currency/'+currency,
                method: "GET",
                dataType:"json",
                beforeSend:function(){
                    $('#convert_currency').attr('disabled', true);
                    $("#convert_currency").LoadingOverlay("show",{
                        text        : "please wait",
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
                            $('#convert_currency').attr('disabled', false);
                            $("#convert_currency").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#curr').html(data.data.currency);
                        $('#rate').html(data.data.rateNGN);
                        //return to natural stage
                        setTimeout(function(){
                            $('#convert_currency').attr('disabled', false);
                            $("#convert_currency").LoadingOverlay("hide");
                        }, 3000);
                    }
                },

            });
        });
    }
    var getReferralConversionDetails = function (){
        $('#convert_referral_spcific').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var currency = button.data('currency')
            var baseUrl = '';
            var modal = $(this);
            modal.find('.modal-title').text('Convert your '+currency+' Referral balance to Available Balance');
            $('input[name="currency"]').val(currency);
        });
    }
    var convertSpecificReferral = function (){
        $('#convert_referral_specific').submit(function(e) {
            e.preventDefault();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/convert_specific_referral/',
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#convert_referral_specific').attr('disabled', true);
                    $("#convert_referral_specific").LoadingOverlay("show",{
                        text        : "converting to available balance",
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
                            $('#convert_referral_specific').attr('disabled', false);
                            $("#convert_referral_specific").LoadingOverlay("hide");
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
                            $('#convert_referral_specific').attr('disabled', false);
                            $("#convert_referral_specific").LoadingOverlay("hide");
                            location.reload();
                        }, 3000);
                    }
                },

            });
        });
    }
    var convertToNGN = function (){
        $('#convert_to_ngn').submit(function(e) {
            e.preventDefault();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/account/dashboard/convert_to_ngn/',
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#convert_to_ngn').attr('disabled', true);
                    $("#convert_to_ngn").LoadingOverlay("show",{
                        text        : "CONVERTING",
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
                            $('#convert_to_ngn').attr('disabled', false);
                            $("#convert_to_ngn").LoadingOverlay("hide");
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
                            $('#convert_to_ngn').attr('disabled', false);
                            $("#convert_to_ngn").LoadingOverlay("hide");
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
                        $("#convert_to_ngn").LoadingOverlay("hide");
                        $("#convert_to_ngn :input").prop("readonly", false);
                    }, 3000);
                }

            });
        });
    }
    return {
        init: function() {
            accountFunding();
            convertReferral();
            setPin();
            addBeneficiary();
            removeBeneficiary();
            getConversionToNGNDetails();
            getReferralConversionDetails();
            convertSpecificReferral();
            convertToNGN();
        }
    };
}();

jQuery(document).ready(function() {
    dashboardRequests.init();
});
