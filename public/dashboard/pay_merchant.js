var payMerchantRequests = function (){
    var checkPaymentStatus = function (){
        $(document).ready(function () {
            var ref = $('#trans_ref').html();
            var payRef = $('#pay_ref').html();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'GET',
                url: baseUrl+'/pay/check_status/'+ref+'/'+payRef,
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $("#icons").addClass("fa fa-spinner fa-spin fa-4x");
                    $("#checking").text("Please hang on while we check the status of your payment.");

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
                        $("#icons").removeClass("fa fa-spinner fa-spin fa-4x");
                        $("#icons").addClass("fa fa-times fa-4x");
                        $("#checking").removeClass('text-primary');
                        $("#checking").addClass('text-danger');
                        $("#checkings").removeClass('text-primary');
                        $("#checkings").addClass('text-danger');
                        $("#checking").text(data.data.error);
                    }
                    if(data.success)
                    {
                        if (data.data.paid == 2){

                            setTimeout(function(){
                                checkPaymentStatus();
                            }, 3000);
                        }else {
                            toastr.options = {
                                "closeButton" : true,
                                "progressBar" : true
                            }
                            toastr.success(data.message);

                            $("#icons").removeClass("fa fa-spinner fa-spin fa-4x");
                            $("#icons").addClass("fa fa-check-circle fa-4x");
                            $("#checking").removeClass('text-primary');
                            $("#checking").addClass('text-success');
                            $("#checkings").removeClass('text-primary');
                            $("#checkings").addClass('text-success');
                            $("#checking").text(data.message);
                        }

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
                        checkPaymentStatus();
                    }, 3000);
                }
            });
        });
    }
    return {
        init: function() {
            checkPaymentStatus()
        }
    };
}();
jQuery(document).ready(function() {
    payMerchantRequests.init();
});
