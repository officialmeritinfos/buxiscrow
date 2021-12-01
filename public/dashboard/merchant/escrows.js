var EscrowRequests = function (){
    var getPercentCharge = function () {
        $('select[name="currency"]').on('change', function () {
            var currency = $(this).val();
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/escrows/get_currency_charge/' + currency,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"currency\"]").attr('disabled',true);
                    $("input[name=\"amount\"]").LoadingOverlay("show", {
                        text: "retrieving charge",
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
                            $('select[name="currency"]').attr('disabled', false);
                            $("input[name=\"amount\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('#esc_charge').html(data.data.charge);
                        $('#perc').html('%');
                        $('#curr').html(currency);
                        $('#currs').html(currency);
                        $('#curre').html(currency);
                        $('#min_charge').html(data.data.min_charge);
                        if (data.data.max_charge ===''){
                            $('#max_charge').html('No maximum');
                        } else{
                            $('#max_charge').html(data.data.max_charge);
                        }
                        $('#tot_esc_charge').empty();
                        $('select[name="currency"]').attr('disabled', false);
                        $("input[name=\"amount\"]").LoadingOverlay("hide");

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
                        $('select[name="currency"]').attr('disabled', false);
                        $("input[name=\"amount\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var getCharge = function () {
        $('input[name="amount"]').on('keyup', function () {
            var amount = $(this).val();
            var charge = $('#esc_charge').html();
            var minCharge = $('#min_charge').html();
            var maxCharge = $('#max_charge').html();

            //do calculation for the charge
            var charges = Number(amount)* Number(charge)/100;
            if (charges<minCharge){
                $('#tot_esc_charge').html(minCharge);
            } else if(charges>maxCharge){
                $('#tot_esc_charge').html(maxCharge);
            } else{
                $('#tot_esc_charge').html(charges);
            }
        });
    }
    var checkChargePaidRange = function () {
        $('select[name="who_pays_charge"]').on('change', function () {
            var whoPays = $(this).val();

            if (Number(whoPays) ===3){
                $('#charge_paid_by_merchant').show();
                $('#charge_paid_by_buyer').show();

            }else{
                $('#charge_paid_by_merchant').hide();
                $('#charge_paid_by_buyer').hide();
                $('#percentWarning').hide();
            }
        });
        $('input[name="charge_paid_by_merchant"]').on('keyup', function () {
            var percent = $(this).val();
            var amountToBePaidByBuyer = $('input[name="charge_paid_by_buyer"]').val();
            if ((Number(percent)+Number(amountToBePaidByBuyer)) > 100){
                $('#percentWarning').show();
            }else if ((Number(percent)+Number(amountToBePaidByBuyer)) < 100){
                $('#percentWarning').show();
            }else{
                $('#percentWarning').hide();
            }
        });
        $('input[name="charge_paid_by_buyer"]').on('keyup', function () {
            var percent = $(this).val();
            var amountToBePaidBySeller = $('input[name="charge_paid_by_merchant"]').val();
            if ((Number(percent)+Number(amountToBePaidBySeller)) > 100){
                $('#percentWarning').show();
            }else if ((Number(percent)+Number(amountToBePaidBySeller)) < 100){
                $('#percentWarning').show();
            }else {
                $('#percentWarning').hide();
            }
        });
    }
    var createEscrow = function () {
        $('#new_escrow').submit(function(e) {
            e.preventDefault();
            var baseUrl=$('#new_escrow').attr('action');
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
                    $('#add_escrow').attr('disabled', true);
                    $("#new_escrow :input").prop("readonly", true);
                    $("#add_escrow").LoadingOverlay("show",{
                        text        : "creating transaction",
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
                            $('#add_escrow').attr('disabled', false);
                            $("#new_escrow :input").prop("readonly", false);
                            $("#add_escrow").LoadingOverlay("hide");
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
                            $('#add_escrow').attr('disabled', false);
                            $("#new_escrow :input").prop("readonly", false);
                            $("#add_escrow").LoadingOverlay("hide");
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
                        $('#new_escrow :input').attr('disabled', false);
                        $("#add_escrow").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var remindEscrowPayerAboutPendingPayment = function () {
        $('#notify_escrow_payer_pending_payment').on('click', function () {
            var reference = $('#notify_escrow_payer_pending_payment').attr('data-value');
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/escrows/notify_payer_pending_escrow_payment/' + reference,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#notify_escrow_payer_pending_payment").attr('disabled',true);
                    $("#notify_escrow_payer_pending_payment").LoadingOverlay("show", {
                        text: "notifying",
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
                            $('#notify_escrow_payer_pending_payment').attr('disabled', false);
                            $("#notify_escrow_payer_pending_payment").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.success(data.message);
                        $('#notify_escrow_payer_pending_payment').attr('disabled', false);
                        $("#notify_escrow_payer_pending_payment").LoadingOverlay("hide");

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
                        $('#notify_escrow_payer_pending_payment').attr('disabled', false);
                        $("#notify_escrow_payer_pending_payment").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var addDeliveryService = function () {
        $('#add-delivery-service').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ref = button.data('value');
            var modal = $(this)
            modal.find('.modal-title').text('Add Delivery');
            $('input[name="ref"]').val(ref);

            var baseUrl = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-country/',
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"country\"]").attr('disabled',true);
                    $("select[name=\"country\"]").LoadingOverlay("show", {
                        text: "retrieving country list",
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
                            $('select[name="country"]').attr('disabled', false);
                            $("select[name=\"country\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('select[name="country"]').empty();
                        $('select[name="country"]').prepend('<option value="">Select Country</option>');
                        $.each(data.data,function (index,val){
                            $('select[name="country"]').append('<option value="'+val.code+'">'+val.name+'</option>');
                        });
                        $('select[name="country"]').attr('disabled', false);
                        $("select[name=\"country\"]").LoadingOverlay("hide");
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
                        $('select[name="country"]').attr('disabled', false);
                        $("select[name=\"country\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
        //check if there is a submission
        $('#add_delivery_service').submit(function(e) {
            e.preventDefault();
            var baseUrls=$('#add_delivery_service').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrls,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#add_logistics').attr('disabled', true);
                    $("#add_delivery_service :input").prop("readonly", true);
                    $("#add_logistics").LoadingOverlay("show",{
                        text        : "adding logistics",
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
                            $('#add_logistics').attr('disabled', false);
                            $("#add_delivery_service :input").prop("readonly", false);
                            $("#add_logistics").LoadingOverlay("hide");
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
                            $('#add_logistics').attr('disabled', false);
                            $("#add_delivery_service :input").prop("readonly", false);
                            $("#add_logistics").LoadingOverlay("hide");
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
                        $('#add_delivery_service :input').attr('disabled', false);
                        $("#add_logistics").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var fetchStates = function (){
        $('select[name="country"]').on('change', function () {
            var country = $(this).val();
            var baseUrl = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-country-state/'+country,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"state\"]").attr('disabled',true);
                    $("select[name=\"state\"]").LoadingOverlay("show", {
                        text: "retrieving states list",
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
                            $('select[name="state"]').attr('disabled', false);
                            $("select[name=\"state\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('select[name="state"]').empty();
                        $('select[name="state"]').prepend('<option value="">Select State/Region</option>');
                        $.each(data.data,function (index,val){
                            $('select[name="state"]').append('<option value="'+val.code+'">'+val.name+'</option>');
                        });
                        $('select[name="state"]').attr('disabled', false);
                        $("select[name=\"state\"]").LoadingOverlay("hide");
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
                        $('select[name="state"]').attr('disabled', false);
                        $("select[name=\"state\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var fetchCity = function (){
        $('select[name="state"]').on('change', function () {
            var state = $(this).val();
            var baseUrl = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-state-city/'+state,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"city\"]").attr('disabled',true);
                    $("select[name=\"city\"]").LoadingOverlay("show", {
                        text: "retrieving city list",
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
                            $('select[name="city"]').attr('disabled', false);
                            $("select[name=\"city\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('select[name="city"]').empty();
                        $('select[name="city"]').prepend('<option value="">Select City</option>');
                        $.each(data.data,function (index,val){
                            $('select[name="city"]').append('<option value="'+val.name+'">'+val.name+'</option>');
                        });
                        $('select[name="city"]').attr('disabled', false);
                        $("select[name=\"city\"]").LoadingOverlay("hide");
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
                        $('select[name="city"]').attr('disabled', false);
                        $("select[name=\"city\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var fetchLogistcis = function (){
        $('select[name="city"]').on('change', function () {
            var city = $(this).val();
            var country = $('select[name="country"]').val();
            var state = $('select[name="state"]').val();
            var baseUrl = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-logistics/'+country+'/'+state+'/'+city,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"service\"]").attr('disabled',true);
                    $("select[name=\"service\"]").LoadingOverlay("show", {
                        text: "retrieving delivery services",
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
                            $('select[name="service"]').attr('disabled', false);
                            $("select[name=\"service\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('select[name="service"]').empty();
                        $('select[name="service"]').prepend('<option value="">Select Logistics Company</option>');
                        $.each(data.data,function (index,val){
                            $('select[name="service"]').append('<option value="'+val.code+'">'
                                +val.name+ '( City: '+val.city+' - '+val.currency+' '+val.rate+' )'+
                                '</option>');
                        });
                        $('select[name="service"]').attr('disabled', false);
                        $("select[name=\"service\"]").LoadingOverlay("hide");
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
                        $('select[name="service"]').attr('disabled', false);
                        $("select[name=\"service\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var cancelEscrow = function (){
        $('#cancel_transaction').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ref = button.data('value');
            var modal = $(this)
            modal.find('.modal-title').text('Cancel Transaction');
            $('input[name="ref"]').val(ref);

            var baseUrl = '';
        });
        //check if there is a submission
        $('#cancel_escrow').submit(function(e) {
            e.preventDefault();
            var baseUrls=$('#cancel_escrow').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrls,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#cancel_escrows').attr('disabled', true);
                    $("#cancel_escrow :input").prop("readonly", true);
                    $("#cancel_escrows").LoadingOverlay("show",{
                        text        : "cancelling",
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
                            $('#cancel_escrows').attr('disabled', false);
                            $("#cancel_escrow :input").prop("readonly", false);
                            $("#cancel_escrows").LoadingOverlay("hide");
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
                            $('#cancel_escrows').attr('disabled', false);
                            $("#cancel_escrow :input").prop("readonly", false);
                            $("#cancel_escrows").LoadingOverlay("hide");
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
                        $('#cancel_escrow :input').attr('disabled', false);
                        $("#cancel_escrows").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var completeEscrow = function (){
        $('#markDelivered').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ref = button.data('value');
            var modal = $(this)
            modal.find('.modal-title').text('Mark Transaction as Completed');
            $('input[name="ref"]').val(ref);

            var baseUrl = '';
        });
        //check if there is a submission
        $('#complete_escrow').submit(function(e) {
            e.preventDefault();
            var baseUrls=$('#complete_escrow').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrls,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#complete_escrows').attr('disabled', true);
                    $("#complete_escrow :input").prop("readonly", true);
                    $("#complete_escrows").LoadingOverlay("show",{
                        text        : "updating",
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
                            $('#complete_escrows').attr('disabled', false);
                            $("#complete_escrow :input").prop("readonly", false);
                            $("#complete_escrows").LoadingOverlay("hide");
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
                            $('#complete_escrows').attr('disabled', false);
                            $("#complete_escrow :input").prop("readonly", false);
                            $("#complete_escrows").LoadingOverlay("hide");
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
                        $('#complete_escrow :input').attr('disabled', false);
                        $("#complete_escrows").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var refundEscrow = function (){
        $('#refundPayment').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var ref = button.data('value');
            var modal = $(this)
            modal.find('.modal-title').text('Refund Transaction');
            $('input[name="ref"]').val(ref);

            var baseUrl = '';
        });
        //check if there is a submission
        $('#refund_escrow').submit(function(e) {
            e.preventDefault();
            var baseUrls=$('#refund_escrow').attr('action');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrls,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#refund_escrows').attr('disabled', true);
                    $("#refund_escrow :input").prop("readonly", true);
                    $("#refund_escrows").LoadingOverlay("show",{
                        text        : "updating",
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
                            $('#refund_escrows').attr('disabled', false);
                            $("#refund_escrow :input").prop("readonly", false);
                            $("#refund_escrows").LoadingOverlay("hide");
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
                            $('#refund_escrows').attr('disabled', false);
                            $("#refund_escrow :input").prop("readonly", false);
                            $("#refund_escrows").LoadingOverlay("hide");
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
                        $('#refund_escrow :input').attr('disabled', false);
                        $("#refund_escrows").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    //init
    return {
        init:function (){
            getPercentCharge();
            getCharge();
            checkChargePaidRange();
            createEscrow();
            remindEscrowPayerAboutPendingPayment();
            addDeliveryService();
            fetchStates();
            fetchCity();
            fetchLogistcis();
            cancelEscrow();
            completeEscrow();
            refundEscrow();
        }
    };
}();

jQuery(document).ready(function() {
    EscrowRequests.init();
});
