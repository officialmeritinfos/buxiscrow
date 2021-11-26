var MerchantDashboardRequest=function () {
    var setPin = function () {
        $('#set_trans_pin').submit(function(e) {
            e.preventDefault();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl+'/merchant/dashboard/set_pin/',
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
                url: baseUrl+'/merchant/dashboard/convert_referral/',
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
                url: baseUrl+'/merchant/dashboard/get_specific_currency/'+currency,
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
                url: baseUrl+'/merchant/dashboard/convert_specific_referral/',
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
                url: baseUrl+'/merchant/dashboard/convert_to_ngn/',
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
            setPin();
            convertReferral();
            getConversionToNGNDetails();
            getReferralConversionDetails();
            convertSpecificReferral();
            convertToNGN();
        }
    };
}();

jQuery(document).ready(function() {
    MerchantDashboardRequest.init();
});
