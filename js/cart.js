
$(document).ready(function () {
    var sum = 0;
    $(".item").each(function () {
        sum = sum + ($(".count", this).val() * $(".price", this).val());
    });
    $("#sum").text(sum + " грн.");

    $(".count").on("keyup change", function () {
        var sum = 0;
        $(".item").each(function () {
            sum = sum + ($(".count", this).val() * $(".price", this).val());
        });
        $("#sum").text(sum + " грн.");
    });
});