"use strict";
var DatatablesDataSourceHtml = function () {

    var totalEmployessValidation = function () {
        $('#totalEmployessForm').validate(
            {
            debug: false,
            ignore: '.select2-search__field,:hidden:not("textarea,.files,select")',
            rules: {
                name: {
                    required: true,
                    remote: {
                        url: $('#totalEmployessForm').attr('data-url'),
                        type: "post",
                        data: {
                            table: function () {
                                return "total_employees";
                            },
                            column: function () {
                                return "name";
                            },
                            value: function () {
                                return $("#name").val();
                            },
                            id: function () {
                                return $("#id").val();
                            },
                        }
                    }
                },

            },
            messages: {
                name: {
                    remote: "Please enter unique name",
                },
                parent_id: {
                    remote: "Parent Can not Be Add as Parent",
                }
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
            totalEmployessValidation();
        },

    };

}();

$(document).ready(function(){
    DatatablesDataSourceHtml.init();

});