$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $("#logout_btn").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: `${baseUrl}session/destroy`,
            method: "POST",
            success: function () {
                
                window.location.href = `${baseUrl}`;
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
