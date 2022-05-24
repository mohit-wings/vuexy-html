"use strict";
var DatatablesDataSourceHtml = function () {

    var initUserTable = function () {
        $('#userTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": $('#userTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": {
                    // return $.extend({}, d, {});
                    category : $('#category').val(),
                    city : $('#city').val(),
                    qualification : $('#qualification').val()
                }
            },  
            "order": [
                [0, "desc"]
            ],
            "columns": [
                { data: "id" }, 
                { data: "first_name" }, 
                { data: "mobile" }, 
                { data: "gender" }, 
                { data: "user_type" }, 
                { data: "is_active" },  
                { data: "action" }
            ],  

        })
    };

    return {
        init: function () {
            initUserTable();
        },

    };

}();

jQuery(document).ready(function () {
    DatatablesDataSourceHtml.init();
    // $("#search").click(function(){
    //     $('#jobJobSeekerTable').DataTable().destroy();
    //     DatatablesDataSourceHtml.init();
    // });

    // $("#btn_clear").click(function(){
    //     $('.select2').val('').trigger('change');
    //     $('#jobJobSeekerTable').DataTable().destroy();
    //     DatatablesDataSourceHtml.init();
    // });
});
