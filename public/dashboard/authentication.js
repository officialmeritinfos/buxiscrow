/**
 *  Class Definition for authentication into the app
 *  This class houses authentication requests for
 *  login, registration, two factor authentication
 *  password reset, email verification etc
 */
var authenticationRequests = function (){
    //registration request
    var newRegistration = function (){
        $('#create_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#create_account').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#create_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "creating account",
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
                            $("#create_account :input").prop("readonly", false);
                            $("#create_account")[0].reset();
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.needVerification == true){
                            var pageTo = '/email_verify';
                            localStorage.setItem('token',data.data.token);
                        }else{
                            var pageTo = '/login';
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#submit").LoadingOverlay("hide");
                            $("#create_account :input").prop("readonly", false);
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#create_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //resend verification mail
    var resendVerificationMail = function (){
        $('#resend_email_verification').click(function(e) {
            e.preventDefault();
            var baseURL='api/resend-email';
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#resend_email_verification").attr("disabled", true);
                    $("#resend_email_verification").LoadingOverlay("show",{
                        text        : "resending",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#resend_email_verification").attr("disabled", false);
                            $("#resend_email_verification").LoadingOverlay("hide");
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#resend_email_verification :input").prop("readonly", false);
                    $('#resend_email_verification').attr('disabled', false);
                    $("#resend_email_verification").LoadingOverlay("hide");
                },
            });
        });
    }
    //email verification request
    var emailVerification = function (){
        $('#verify_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#verify_account').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token'),
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#verify_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "verifying",
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
                            $("#verify_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.verified == true){
                            var pageTo = '/login';
                            localStorage.removeItem('token');
                        }else{
                            var pageTo = '/email_verify';
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#verify_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#verify_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //login request
    var login = function (){
        $('#login_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#login_account').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#login_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "logging in",
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
                            $("#login_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.needVerification == true){
                            var pageTo = '/email_verify';
                            localStorage.setItem('token',data.data.token);
                        }else if (data.data.needAuth == true){
                            var pageTo = '/twoway';
                            localStorage.setItem('token',data.data.token);
                        }else{
                            if (data.data.account_type == 1){
                                var pageTo = '/merchant/dashboard';
                            }else{
                                var pageTo = '/account/dashboard';
                            }
                            localStorage.setItem('token',data.data.token);
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#login_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#login_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#submit").LoadingOverlay("hide");
                },
            });
        });
    }
    //resend twoFactor mail
    var resendTwoFactorMail = function (){
        $('#resend_twoway_verification').click(function(e) {
            e.preventDefault();
            var baseURL='api/resend-twoway';
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#resend_twoway_verification").attr("disabled", true);
                    $("#resend_twoway_verification").LoadingOverlay("show",{
                        text        : "resending",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#resend_twoway_verification").attr("disabled", false);
                            $("#resend_twoway_verification").LoadingOverlay("hide");
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#resend_twoway_verification :input").prop("readonly", false);
                    $("#resend_twoway_verification").attr("disabled", false);
                    $('#submit').attr('disabled', false);
                    $("#resend_twoway_verification").LoadingOverlay("hide");
                },
            });
        });
    }
    //two factor request
    var twoFactor = function (){
        $('#verify_login').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#verify_login').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#verify_login :input").prop("readonly", true);
                    $("#verify_login").LoadingOverlay("show",{
                        text        : "authorizing",
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
                            $("#verify_login :input").prop("readonly", false);
                            $("#verify_login").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.loggedIn == true){

                            if (data.data.account_type == 1){
                                var pageTo = '/merchant/dashboard';
                            }else{
                                var pageTo = '/account/dashboard';
                            }
                            localStorage.removeItem('token');
                            localStorage.setItem('token',data.data.token);
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#verify_account :input").prop("readonly", false);
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#verify_login :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#verify_login").LoadingOverlay("hide");
                },
            });
        });
    }
    //recover account request
    var recoverPassword = function (){
        $('#recover_account').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#recover_account').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#recover_account :input").prop("readonly", true);
                    $("#submit").LoadingOverlay("show",{
                        text        : "verifying",
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
                            $("#recover_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.sent == true){
                            var pageTo = '/confirm_reset';
                            localStorage.removeItem('token');
                            localStorage.setItem('token',data.data.token);
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#recover_account :input").prop("readonly", false);
                            $("#submit").LoadingOverlay("hide");
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#recover_account :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#recover_account").LoadingOverlay("hide");
                },
            });
        });
    }
    //resend account Recovery mail
    var resendAccountRecoveryMail = function (){
        $('#resend_reset_verification').click(function(e) {
            e.preventDefault();
            var baseURL='api/resend-resetmail';
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#resend_reset_verification").attr("disabled", true);
                    $("#resend_reset_verification").LoadingOverlay("show",{
                        text        : "resending",
                        size        : "20"
                    });
                },
                success:function(data)
                {
                    if(data.success)
                    {
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#resend_reset_verification").attr("disabled", false);
                            $("#resend_reset_verification").LoadingOverlay("hide");
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#resend_reset_verification").attr("disabled", false);
                    $('#submit').attr('disabled', false);
                    $("#resend_reset_verification").LoadingOverlay("hide");
                },
            });
        });
    }
    //confirm reset request
    var confirmPasswordReset = function (){
        $('#confirm_reset').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#confirm_reset').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#confirm_reset :input").prop("readonly", true);
                    $("#confirm_reset").LoadingOverlay("show",{
                        text        : "verifying",
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
                            $("#confirm_reset :input").prop("readonly", false);
                            $("#confirm_reset").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.verified == true){

                            var pageTo = '/reset';
                            localStorage.removeItem('token');
                            localStorage.setItem('token',data.data.token);
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#confirm_reset :input").prop("readonly", false);
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#confirm_reset :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#confirm_reset").LoadingOverlay("hide");
                },
            });
        });
    }
    //change password request
    var changePassword = function (){
        $('#change_password').submit(function(e) {
            e.preventDefault();
            var baseURL=$('#change_password').attr('action');
            var baseURLs='';
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Authorization': 'Bearer '+localStorage.getItem('token')
                }
            });
            $.ajax({
                url: baseURL,
                method: "POST",
                data:$(this).serialize(),
                dataType:"json",
                beforeSend:function(){
                    $('#submit').attr('disabled', true);
                    $("#change_password :input").prop("readonly", true);
                    $("#change_password").LoadingOverlay("show",{
                        text        : "reseting",
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
                            $("#change_password :input").prop("readonly", false);
                            $("#change_password").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        if (data.data.reset == true){

                            var pageTo = '/login';
                            localStorage.removeItem('token');
                        }
                        toastr.options = {
                            "closeButton" : true,
                            "progressBar" : true
                        }
                        toastr.info(data.message);
                        //return to natural stage
                        setTimeout(function(){
                            $('#submit').attr('disabled', false);
                            $("#change_password :input").prop("readonly", false);
                            location.href=baseURLs+pageTo;
                        }, 5000);
                    }
                },
                error:function (jqXHR, textStatus, errorThrown){
                    toastr.options = {
                        "closeButton" : true,
                        "progressBar" : true
                    }
                    toastr.error(errorThrown);
                    $("#change_password :input").prop("readonly", false);
                    $('#submit').attr('disabled', false);
                    $("#change_password").LoadingOverlay("hide");
                },
            });
        });
    }
    return {
        init: function() {
            newRegistration();
            login();
            resendVerificationMail();
            emailVerification();
            resendTwoFactorMail();
            twoFactor();
            recoverPassword();
            resendAccountRecoveryMail();
            confirmPasswordReset();
            changePassword();
        }
    };
}();

jQuery(document).ready(function() {
    authenticationRequests.init();
});
