$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $.ajax({
        url: `${baseUrl}dashboard/data`, 
        type: "GET",
        success: function (data) {
            console.log(data);
        },
        error: function (error) {
            console.error(error);
        }
    });
    
    $("#logout_btn").on("click", function () {
        $.ajax({
            url: `${baseUrl}logout`, 
            type: "POST",
            success: function () {
                window.location = `${baseUrl}login`;
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
