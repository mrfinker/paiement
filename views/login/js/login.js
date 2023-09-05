$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/"

        $(document).on("submit", "#loginFormUser", function(e) {
            e.preventDefault();
            let email = $("#email").val()
            let password = $("#password").val()
            $.ajax({
                url: `${baseUrl}login/handleLogin`,
                type: "POST",
                dataType: "JSON",
                data: {
                    email,
                    password,
                    action: "jddiuanjkanciuSFDSFAEEEADS;sdiojd"
                },
                success: function(res) {
                  console.log(res);
                    if (res.status === 200) {
                        window.location = `${baseUrl}dashboard`
                    } else {
                        alert(res.msg)
                    }
                }
            })
        })
})