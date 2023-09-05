$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    function logout(res) {
        res.preventDefault();
        $.ajax({
            url: `${baseUrl}session/destroy`,
            type: "POST",
            success: function () {
                window.location = baseUrl;
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    $("#logout_btn").on("click", logout);
});
