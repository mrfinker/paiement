$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    function logout() {
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
    }

    $("#logout_btn").on("click", function (e) {
        e.preventDefault();
        logout();
    });
});
