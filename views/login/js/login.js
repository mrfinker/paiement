$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/"

        $(document).on("submit", "#loginFormUser", function(e) {
            e.preventDefault();
            let email = $("#email").val()
            let password = $("#password").val()
            $.ajax({
                url: `${baseUrl}login/handleLogin`,
                type: "POST",
                data: {
                    email,
                    password,
                    action: "jddiuanjkanciuSFDSFAEEEADS;sdiojd"
                },
                success: function(res) {
                    if (res === "success") {
                        window.location = `${baseUrl}dashboard`
                    } else {
                        alert(res)
                    }
                }
            })
        })
})