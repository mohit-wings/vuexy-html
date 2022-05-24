"use strict";
var DatatablesDataSourceHtml = function () {

    var userValidation = function () {
        $('#userForm').validate(
            {
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                email: {
                    required: true,
                    remote: {
                        url: $('#userForm').attr('data-url'),
                        type: "post",
                        data: {
                            table: function () {
                                return "users";
                            },
                            column: function () {
                                return "email";
                            },
                            value: function () {
                                return $("#email").val();
                            },
                            id: function () {
                                return $("#id").val();
                            },
                        }
                    }
                },

            },
            messages: {
                email: {
                    remote: "Please enter unique email",
                },
            },
            errorPlacement: function (error, element) {
                error.appendTo(element.parent()).addClass('text-danger');
            },
            submitHandler: function (e) {
                return true;

            }
        }
        );

    };

    return {
        init: function () {
            userValidation();
        },

    };

}();

$(document).ready(function(){
    DatatablesDataSourceHtml.init();

    $('#select').select2({
        allowClear: true,
        ajax: {
            url: function () {
                return $(this).data('url');
            },
            data: function (params) {
                return {
                    search: params.term,
                };
            },
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.name,
                            otherfield: item,
                        };
                    }),
                }
            },
            //cache: true,
            delay: 250
        }
    });
});