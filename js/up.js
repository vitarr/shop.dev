$(document).ready(function () {
    $("#up").hide();
    $(document).scroll(function () {
        if ($(document).scrollTop() > 300) {
            $("#up").show();
        } else {
            $("#up").hide();
        }
        ;
    });
});