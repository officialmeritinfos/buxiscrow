var settingsRequests = function (){
    var updateProfilePhoto = function (){
        $('#update_profile_pic').on('submit',(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:formData,
                cache:false,
                contentType: false,
                processData: false,
                dataType:"json",
                beforeSend:function(){
                    $('#update_profile_pic').attr('disabled', true);
                    $("#update_profile_pic :input").prop("readonly", true);
                    $("#update_profile_pic").LoadingOverlay("show",{
                        text        : "uploading",
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
                            $('#update_profile_pic').attr('disabled', false);
                            $("#update_profile_pic").LoadingOverlay("hide");
                            $("#update_profile_pic :input").prop("readonly", false);
                            $("#update_profile_pic")[0].reset();
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
                            $('#update_profile_pic').attr('disabled', false);
                            $("#update_profile_pic").LoadingOverlay("hide");
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
                        $('#update_profile_pic').attr('disabled', false);
                        $("#update_profile_pic").LoadingOverlay("hide");
                        $("#update_profile_pic :input").prop("readonly", false);
                        $("#update_profile_pic")[0].reset();
                    }, 3000);
                }
            });
        }));
        $("#update_profile_pic").on("change", function() {
            $("#update_profile_pic").submit();
        });
    }
    var updatePassword = function (){
        $('#change_password').on('submit',(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#update_password').attr('disabled', true);
                    $("#change_password :input").prop("readonly", true);
                    $("#update_password").LoadingOverlay("show",{
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
                            $('#update_password').attr('disabled', false);
                            $("#update_password").LoadingOverlay("hide");
                            $("#change_password :input").prop("readonly", false);
                            $("#change_password")[0].reset();
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
                            $('#update_password').attr('disabled', false);
                            $("#update_password").LoadingOverlay("hide");
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
                        $('#update_password').attr('disabled', false);
                        $("#update_password").LoadingOverlay("hide");
                        $("#change_password :input").prop("readonly", false);
                        $("#change_password")[0].reset();
                    }, 3000);
                }
            });
        }));
    }
    var updateProfile = function (){
        $('#updateProfile').on('submit',(function(e) {
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:'POST',
                url: $(this).attr('action'),
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#update_profile').attr('disabled', true);
                    $("#updateProfile :input").prop("readonly", true);
                    $("#update_profile").LoadingOverlay("show",{
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
                            $('#update_profile').attr('disabled', false);
                            $("#update_profile").LoadingOverlay("hide");
                            $("#updateProfile :input").prop("readonly", false);
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
                            $('#update_profile').attr('disabled', false);
                            $("#update_profile").LoadingOverlay("hide");
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
                        $('#update_profile').attr('disabled', false);
                        $("#update_profile").LoadingOverlay("hide");
                        $("#updateProfile :input").prop("readonly", false);
                    }, 3000);
                }
            });
        }));
    }
    var getStates = function (){
        $('select[name="country"]').on('change',function(e) {
            const country = $(this).val();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-country-state/' + country,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $('select[name="state"]').attr('disabled', true);
                    $("select[name=\"state\"]").LoadingOverlay("show", {
                        text: "retrieving state",
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
                        $('select[name="state"]').prepend('<option value="">Select State</option>');
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
    var getCities = function (){
        $('select[name="state"]').on('change',function(e) {
            const country = $(this).val();
            var baseUrl='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/get-state-city/' + country,
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend: function () {
                    $('select[name="city"]').attr('disabled', true);
                    $("select[name=\"city\"]").LoadingOverlay("show", {
                        text: "retrieving cities",
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
    var updateTheme = function (){
        $('input[name="dark"]').change(function() {
            var theme = Cookies.get('theme');
            if(this.checked) {
                if (theme ==='dark-mode'){
                    $('body').removeClass('dark-mode');
                    $('body').addClass('light-mode');
                    Cookies.set('theme','light-mode');
                }else{
                    $('body').addClass('dark-mode');
                    $('body').removeClass('light-mode');
                    Cookies.set('theme','dark-mode');
                }
            }else{
                if (theme ==='dark-mode'){
                    $('body').removeClass('dark-mode');
                    $('body').addClass('light-mode');
                    Cookies.set('theme','light-mode');
                }else{
                    $('body').addClass('dark-mode');
                    $('body').removeClass('light-mode');
                    Cookies.set('theme','dark-mode');
                }
            }
        });
    }
    var webTheme = function (){
        $(document).ready(function () {
            var theme = Cookies.get('theme');
            if (theme === 'dark-mode'){
                $('body').removeClass('light-mode');
                $('body').addClass('dark-mode');
            }else{
                $('body').removeClass('dark-mode');
                $('body').addClass('light-mode');
            }
        });
    }
    var switchAccount = function (){
        $('input[name="merchant"]').change(function(e) {
            if(this.checked) {
                e.preventDefault();
                var baseUrl='';
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type:'POST',
                    url: baseUrl+'/account/settings/change_account',
                    data:$(this).serialize(),
                    dataType:"json",
                    beforeSend:function(){
                        $('.accountSwitch').attr('disabled', true);
                        $(".accountSwitch :input").prop("readonly", true);
                        $(".accountSwitch").LoadingOverlay("show",{
                            text        : "switching ",
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
                                $('.accountSwitch').attr('disabled', false);
                                $(".accountSwitch").LoadingOverlay("hide");
                                $(".accountSwitch :input").prop("readonly", false);
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
                                $('.accountSwitch').attr('disabled', false);
                                $(".accountSwitch").LoadingOverlay("hide");
                                location.href=baseUrl+'/merchant/settings';
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
                            $('.accountSwitch').attr('disabled', false);
                            $(".accountSwitch").LoadingOverlay("hide");
                            $(".accountSwitch :input").prop("readonly", false);
                        }, 3000);
                    }
                });
            }
        });
    }
    return {
        init: function() {
            updateProfilePhoto();
            updatePassword();
            updateProfile();
            getStates();
            getCities();
            updateTheme();
            webTheme();
            switchAccount();
        }
    };
}();
jQuery(document).ready(function() {
    settingsRequests.init();
});
