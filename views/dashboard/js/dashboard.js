$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $("#logout_btn").on("click", function (e) {
        e.preventDefault();
        $.ajax({
            url: `${baseUrl}session/destroy`,
            type: "POST",
            dataType:'JSON',
            success: function () {
                
                window.location = `${baseUrl}`;
            },
            error: function (error) {
                console.error(error);
            }
        });
    });
});
