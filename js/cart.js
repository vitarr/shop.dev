$(document).ready(function () {
    var now = $("#count").val();
    $("#sum").text($("#price").val() * parseInt(now) + " грн.");
    $("#count").on("keyup change", function () {
        var now = $("#count").val();
        if ($.isNumeric(now) && now > 0) {
            $("#sum").text($("#price").val() * parseInt(now) + " грн.");
        } else {
            now = 1;
            $("#sum").text($("#price").val() * parseInt(now) + " грн.");
        }
    })
}) 