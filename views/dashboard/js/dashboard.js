$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $("#logout_btn").on("click", function () {
        $.ajax({
            url: `${baseUrl}dashboard`, 
            type: "POST",
            dataType: "JSON",
            success: function () {
                window.location = `${baseUrl}login`;
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
