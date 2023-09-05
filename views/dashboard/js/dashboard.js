$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $("#logout_btn").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: `${baseUrl}login/logout`,
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
