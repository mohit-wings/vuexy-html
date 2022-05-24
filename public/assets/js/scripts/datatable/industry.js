"use strict";
var DatatablesDataSourceHtml = function () {

    var initIndustryTable = function () {
        $('#industryTable').DataTable({
            "processing": true,
            "serverSide": true,
            "stateSave": true,
            "ajax": {
                "url": $('#industryTable').attr('data-url'),
                "dataType": "json",
                "type": "POST",
                "data": function(d){
                    return $.extend({}, d, {});
                }
            },  
            "order": [
                [0, "desc"]
            ],
            "columns": [
                { data: "id" }, 
                { data: "name" }, 
                { data: "is_active" },  
                { data: "action" }
            ],  

        })
    };

    return {
        init: function () {
            initIndustryTable();
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
