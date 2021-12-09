var PaymentLinkRequests = function (){
    var createPaymentLink = function () {
        $('#new_payment_link').submit(function(e) {
            e.preventDefault();
            var baseUrl=$('#new_payment_link').attr('action');
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
                    $('#add_payment_link').attr('disabled', true);
                    $("#new_payment_link :input").prop("readonly", true);
                    $("#add_payment_link").LoadingOverlay("show",{
                        text        : "creating link",
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
                            $('#add_payment_link').attr('disabled', false);
                            $("#new_payment_link :input").prop("readonly", false);
                            $("#add_payment_link").LoadingOverlay("hide");
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
                            $('#add_payment_link').attr('disabled', false);
                            $("#new_payment_link :input").prop("readonly", false);
                            $("#add_payment_link").LoadingOverlay("hide");
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
                        $('#new_payment_link :input').attr('disabled', false);
                        $("#add_payment_link").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var deactivatePaymentLink = function () {
        $('#deactivate_link').on('click', function () {
            var reference = $('#deactivate_link').attr('data-ref');
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/payment-link/deactivate/' + reference,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#deactivate_link").attr('disabled',true);
                    $("#deactivate_link").LoadingOverlay("show", {
                        text: "deactivating",
                        size: "20"
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
                            $('#deactivate_link').attr('disabled', false);
                            $("#deactivate_link").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        setTimeout(function(){
                            $('#deactivate_link').attr('disabled', false);
                            $("#deactivate_link").LoadingOverlay("hide");
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
                        $('#deactivate_link').attr('disabled', false);
                        $("#deactivate_link").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var activatePaymentLink = function () {
        $('#activate_link').on('click', function () {
            var reference = $('#activate_link').attr('data-ref');
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/payment-link/activate/' + reference,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#activate_link").attr('disabled',true);
                    $("#activate_link").LoadingOverlay("show", {
                        text: "deactivating",
                        size: "20"
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
                            $('#activate_link').attr('disabled', false);
                            $("#activate_link").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        setTimeout(function(){
                            $('#activate_link').attr('disabled', false);
                            $("#activate_link").LoadingOverlay("hide");
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
                        $('#activate_link').attr('disabled', false);
                        $("#activate_link").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var deletePaymentLink = function () {
        $('#delete_link').on('click', function () {
            var reference = $('#delete_link').attr('data-ref');
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/payment-link/delete/' + reference,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#delete_link").attr('disabled',true);
                    $("#delete_link").LoadingOverlay("show", {
                        text: "deleting",
                        size: "20"
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
                            $('#delete_link').attr('disabled', false);
                            $("#delete_link").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        setTimeout(function(){
                            $('#delete_link').attr('disabled', false);
                            $("#delete_link").LoadingOverlay("hide");
                            window.location.href='/merchant/payment-link';
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
                        $('#delete_link').attr('disabled', false);
                        $("#delete_link").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    //init
    return {
        init:function (){
            createPaymentLink();
            deactivatePaymentLink();
            activatePaymentLink();
            deletePaymentLink();
        }
    };
}();

jQuery(document).ready(function() {
    PaymentLinkRequests.init();
});
