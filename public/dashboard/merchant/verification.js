var verificationRequests = function (){
    var getVerificationDetails = function (){
        $('select[name="document_type"]').on('change',function(e) {
            const docu_type = $(this).val();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/documents/get-document-type-id/' + docu_type,
                method: "GET",
                dataType: "json",
                beforeSend: function () {
                    $('#submit_verify').attr('disabled', true);
                    $("#submit_verify").LoadingOverlay("show", {
                        text: "retrieving details",
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
                            $('#submit_verify').attr('disabled', false);
                            $("#submit_verify").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.back === 1){
                            $('#back_image').show();
                        } else{
                            $('#back_image').hide();
                        }
                        if (data.data.r ===1){
                            $('#date_issued').show();
                        } else{
                            $('#date_issued').hide();
                        }
                        if (data.data.expires ===1){
                            $('#date_expire').show();
                        } else{
                            $('#date_expire').hide();
                        }
                        $('#submit_verify').attr('disabled', false);
                        $("#submit_verify").LoadingOverlay("hide");
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
                        $('#submit_verify').attr('disabled', false);
                        $("#submit_verify").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var submitVerification = function (){
        $('#verificationForm').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('#submit_verify').attr('disabled', true);
                    $("#verificationForm :input").prop("readonly", true);
                    $("#submit_verify").LoadingOverlay("show",{
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
                            $('#submit_verify').attr('disabled', false);
                            $("#submit_verify").LoadingOverlay("hide");
                            $("#verificationForm :input").prop("readonly", false);
                            $("#submit_verify")[0].reset();
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
                            $('#submit_verify').attr('disabled', false);
                            $("#submit_verify").LoadingOverlay("hide");
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
                        $('#submit_verify').attr('disabled', false);
                        $("#submit_verify").LoadingOverlay("hide");
                        $("#verificationForm :input").prop("readonly", false);
                        $("#submit_verify")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    return {
        init: function() {
            getVerificationDetails();
            submitVerification();
        }
    };
}();
jQuery(document).ready(function() {
    verificationRequests.init();
});
