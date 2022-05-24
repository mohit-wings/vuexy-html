$(function () {
    "use strict";
    
    $('.general-validation').validate();
    $('.password-validation').validate();
    $('.company-info-validation').validate();
    $('.mail-validation').validate();
    var r = $(".flatpickr"),
        n = $("#account-upload-img"),
        a = $("#account-upload");

    a &&
        a.on("change", function (e) {
            var r = new FileReader();
                a = e.target.files;
            (r.onload = function () {
                n && n.attr("src", r.result);
            }),
                r.readAsDataURL(a[0]);

            $.ajax({
                type:'POST',
                url: $('.account-upload').data('url'),
                data: "$('.account-upload').val()",
                success: (response) => {
                    if (response) {
                        alert('Image has been uploaded successfully');
                    }
                },
             });
        }),

        r.length &&
            r.flatpickr({
                onReady: function (e, r, n) {
                    n.isMobile && $(n.mobileInput).attr("step", null);
                },
            })
});
