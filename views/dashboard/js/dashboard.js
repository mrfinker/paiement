$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    function logout(event) {
        event.preventDefault();
        $.ajax({
            url: `${baseUrl}session/destroy`,
            type: "POST",
            success: function () {
                window.location = baseUrl; // Redirigez l'utilisateur après la déconnexion
            },
            error: function (error) {
                console.error(error);
            }
        });
    }

    $("#logout_btn").on("click", logout);
});
