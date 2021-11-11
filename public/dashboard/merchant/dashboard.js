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
    return {
        init: function() {
            setPin();
        }
    };
}();

jQuery(document).ready(function() {
    MerchantDashboardRequest.init();
});
