var MerchantBusinessRequests = function () {
    var getBusinessCategories = function () {
        $('select[name="category"]').on('change', function () {
            var category = $(this).val();
            var baseUrl = '';

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: baseUrl + '/merchant/business/get_category_subcategory/' + category,
                method: "GET",
                data: $(this).serialize(),
                dataType: "json",
                beforeSend:function(){
                    $("select[name=\"subcategory\"]").attr('disabled',true);
                    $("select[name=\"subcategory\"]").LoadingOverlay("show", {
                        text: "retrieving subcategory",
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
                            $('select[name="subcategory"]').attr('disabled', false);
                            $("select[name=\"subcategory\"]").LoadingOverlay("hide");
                        }, 3000);
                    }
                    if(data.success)
                    {
                        $('select[name="subcategory"]').empty();
                        $('select[name="subcategory"]').prepend('<option value="">Select Subcategory</option>');
                        $.each(data.data,function (index,val){
                            $('select[name="subcategory"]').append('<option value="'+val.id+'">'+val.name+'</option>');
                        });
                        $('select[name="subcategory"]').attr('disabled', false);
                        $("select[name=\"subcategory\"]").LoadingOverlay("hide");
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
                        $('select[name="subcategory"]').attr('disabled', false);
                        $("select[name=\"subcategory\"]").LoadingOverlay("hide");
                    }, 3000);
                }
            });
        });
    }
    var createBusiness = function () {
        $('#new_business').submit(function(e) {
            e.preventDefault();
            var baseUrl=$('#new_business').attr('action');
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
                    $('#add_store').attr('disabled', true);
                    $("#new_business :input").prop("readonly", true);
                    $("#add_store").LoadingOverlay("show",{
                        text        : "creating store",
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
                            $('#add_store').attr('disabled', false);
                            $("#new_business :input").prop("readonly", false);
                            $("#add_store").LoadingOverlay("hide");
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
                            $('#add_store').attr('disabled', false);
                            $("#new_business :input").prop("readonly", false);
                            $("#add_store").LoadingOverlay("hide");
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
                        $('#new_business :input').attr('disabled', false);
                        $("#add_store").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var getBizData = function () {
        $('#delete_business').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var bizid = button.data('ref');
            var bizName = button.data('value');
            var modal = $(this)
            modal.find('.modal-title').text('Remove ' + bizName + ' from Store List');
            $('input[name="store_ref"]').val(bizid);
        });
    }
    var removeBiz = function () {
        $('#remove_business').submit(function(e) {
            e.preventDefault();
            var baseUrl=$('#remove_business').attr('action');
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
                    $('#remove_store').attr('disabled', true);
                    $("#remove_business :input").prop("readonly", true);
                    $("#remove_store").LoadingOverlay("show",{
                        text        : "erasing data",
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
                            $('#remove_store').attr('disabled', false);
                            $("#remove_business :input").prop("readonly", false);
                            $("#remove_store").LoadingOverlay("hide");
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
                            $('#remove_store').attr('disabled', false);
                            $("#remove_business :input").prop("readonly", false);
                            $("#remove_store").LoadingOverlay("hide");
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
                        $('#remove_business :input').attr('disabled', false);
                        $("#remove_store").LoadingOverlay("hide");
                    }, 3000);
                }

            });
        });
    }
    var updateBizLogo = function (){
        $('#update_logo').on('submit',(function(e) {
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
                    $('#update_logo').attr('disabled', true);
                    $("#update_logo :input").prop("readonly", true);
                    $("#update_logo").LoadingOverlay("show",{
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
                            $('#update_logo').attr('disabled', false);
                            $("#update_logo").LoadingOverlay("hide");
                            $("#update_logo :input").prop("readonly", false);
                            $("#update_logo")[0].reset();
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
                            $('#update_logo').attr('disabled', false);
                            $("#update_logo").LoadingOverlay("hide");
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
                        $('#update_logo').attr('disabled', false);
                        $("#update_logo").LoadingOverlay("hide");
                        $("#update_logo :input").prop("readonly", false);
                        $("#update_logo")[0].reset();
                    }, 3000);
                }
            });
        }));
        $("#update_logo").on("change", function() {
            $("#update_logo").submit();
        });
    }
    //init
    return {
        init:function (){
            createBusiness();
            getBusinessCategories();
            getBizData();
            removeBiz();
            updateBizLogo();
        }
    };
}();

jQuery(document).ready(function() {
    MerchantBusinessRequests.init();
});
