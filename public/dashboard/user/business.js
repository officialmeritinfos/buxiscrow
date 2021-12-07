var merchantBusinessRequests = function (){
    var paymerchant = function (){
        //check if there is a submission
        $('#send_money').submit(function(e) {
            e.preventDefault();
            var baseUrls=$('#send_money').attr('action');
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
                    $('#sendBusinessMoney').attr('disabled', true);
                    $("#send_money :input").prop("readonly", true);
                    $("#sendBusinessMoney").LoadingOverlay("show",{
                        text        : "transferring",
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
                            $('#sendBusinessMoney').attr('disabled', false);
                            $("#send_money :input").prop("readonly", false);
                            $("#sendBusinessMoney").LoadingOverlay("hide");
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
                            $('#sendBusinessMoney').attr('disabled', false);
                            $("#send_money :input").prop("readonly", false);
                            $("#sendBusinessMoney").LoadingOverlay("hide");
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
                        $('#send_money :input').attr('disabled', false);
                        $("#sendBusinessMoney").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    return {
        init: function() {
            paymerchant();
        }
    };
}();

jQuery(document).ready(function() {
    merchantBusinessRequests.init();
});
