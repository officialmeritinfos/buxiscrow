var EscrowRequests = function (){
    var makePaymentForEscrow = function () {
        $('#pay_for_escrow').on('click', function () {
            var reference = $('#pay_for_escrow').attr('data-value');
            var baseUrl = '';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/account/escrows/pay_for_escrow/' + reference,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("#pay_for_escrow").attr('disabled',true);
                    $("#pay_for_escrow").LoadingOverlay("show", {
                        text: "making payment",
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
                            $('#pay_for_escrow').attr('disabled', false);
                            $("#pay_for_escrow").LoadingOverlay("hide");
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
                            $('#pay_for_escrow').attr('disabled', false);
                            $("#pay_for_escrow").LoadingOverlay("hide");
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
                        $('#pay_for_escrow').attr('disabled', false);
                        $("#pay_for_escrow").LoadingOverlay("hide");
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
    //init
    return {
        init:function (){
            makePaymentForEscrow();
            completeEscrow();
        }
    };
}();

jQuery(document).ready(function() {
    EscrowRequests.init();
});
