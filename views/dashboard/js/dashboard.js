$(document).ready(function logout() {
    const baseUrl = "http://paiement.mr:81/";

    $("#logout_btn").on("click", function () {
        $.ajax({
            url: `${baseUrl}dashboard`, 
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
