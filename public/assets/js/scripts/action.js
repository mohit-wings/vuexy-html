function stopLoader() {
    $.unblockUI();
}

function showLoader() {

    $.blockUI({
        message: lodingImage,
        baseZ: 2000,
        css: {
            border: '0',
            cursor: 'wait',
            backgroundColor: 'transparent'
        },
    });

}

$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();
    if (jQuery().dataTable) {
        $.extend(true, $.fn.dataTable.defaults, {
            oLanguage: {
                oPaginate: {
                    sNext: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-angle-double-right"></i></span>',
                    sPrevious: '<span class="pagination-default"></span><span class="pagination-fa"><i class="fa fa-angle-double-left"></i></i></span>'
                }
            }
        });
    };

    if (jQuery().validate) {

        jQuery.validator.setDefaults({
            errorPlacement: function(error, element) {
                $(error).addClass('text-danger');
                error.insertAfter(element);
            }
        });

        jQuery.validator.addMethod("unique", function(value, element, params) {
            var prefix = params;
            var selector = jQuery.validator.format("[name!='{0}']{1}", element.name, prefix);
            var matches = new Array();
            $(selector).each(function(index, item) {
                if (value == $(item).val()) {
                    matches.push(item);
                }
            });
            return matches.length == 0;
        }, "Value is not unique.");


        jQuery.validator.classRuleSettings.unique = {
            unique: true
        };

        jQuery.validator.addMethod("phonenumber", function (value, element) {
            var a = value;
            var filter =
                /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a)) {
                return true;
            } else {
                return false;
            }
        }, 'Please enter a valid phone number.');

        $.validator.addMethod('filesize', function (value, element, param) {
            if (element.files.length) {
                return this.optional(element) || (element.files[0].size <= param)
            }
            return true;
        }, 'File size must be less than 5mb.');

        $.validator.addMethod('ckdata', function (value, element, param) {
            var editor = CKEDITOR.instances[$(element).attr('id')];
            if (editor.getData().length <= 0) {
                return false;
            } else {
                return true;
            }
        }, 'This field is required.');

    }

    $(document).on('click', '.delete-confrim', function (e) {
        e.preventDefault();

        var el = $(this);
        var url = el.attr('href');
        var id = el.data('id');
        var refresh = el.closest('table');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: !0,
            confirmButtonText: "Yes, delete it!",
            customClass: { confirmButton: "btn btn-primary", cancelButton: "btn btn-outline-danger ml-1" },
            buttonsStyling: !1,
        }).then((result) => {
            if (result.value) {

                //showLoader();
                $.ajax({
                    type: "POST",
                    url: url,
                    cache: false,
                    data: {
                        id: id,
                        _method: 'DELETE'
                    }
                }).always(function (respons) {

                    //stopLoader();

                    $(refresh).DataTable().ajax.reload();

                }).done(function (respons) {
                    Swal.fire({ 
                        title: "Success", 
                        text: respons.message, 
                        icon: "success", 
                        customClass: { confirmButton: "btn btn-primary" },
                        buttonsStyling: !1,
                    });

                }).fail(function (respons) {
                    console.log(respons);
                    var data = respons.responseJSON;
                    if(respons.responseJSON.errormessage){
                        data.message = 'This data is use in other modules so you can’t delete';
                    }
                    if(respons.responseJSON.catgeorymessage){
                        data.message = 'This data is use in parent so you can’t delete';
                    }
                    Swal.fire({ 
                        title: "Error", 
                        text: data.message ? data.message : 'something went wrong please try again !', 
                        icon: "error", 
                        customClass: { confirmButton: "btn btn-primary" },
                        buttonsStyling: !1,
                    });

                });
            }
        });

    });

    $(document).on('click', '.change-status', function (e) {

        var el = $(this);
        var url = el.data('url');
        var table = el.data('table');
        // alert(table);
        var id = el.val();
        $.ajax({
            type: "POST",
            url: url,
            data: {
                id: id,
                status: el.prop("checked"),
                table: table,
            }
        }).always(function (respons) {}).done(function (respons) {
            Swal.fire({ 
                title: "Success", 
                text: respons.message, 
                icon: "success", 
                customClass: 
                { 
                    confirmButton: "btn btn-primary" 
                },
                buttonsStyling: !1,
            });


        }).fail(function (respons) {
            Swal.fire({ 
                title: "Error", 
                text: 'something went wrong please try again !', 
                icon: "error", 
                customClass: 
                { 
                    confirmButton: "btn btn-primary" 
                },
                buttonsStyling: !1,
            });
        });

    });

    $(document).on('click', '.call-model', function (e) {

        e.preventDefault();
        // return false;
        var el = $(this);
        var url = el.data('url');
        var target = el.data('target-modal');

        $.ajax({
            type: "GET",
            url: url
        }).always(function () {
            $('#load-modal').html(' ')
        }).done(function (res) {
            $('#load-modal').html(res.html);
            $(target).modal('toggle');
        });

    });

});
