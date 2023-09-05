$(document).ready(function () {
    function logout() {
        const baseUrl = "http://paiement.mr:81/";
        $.ajax({
            url: `${baseUrl}logout`,
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
});
