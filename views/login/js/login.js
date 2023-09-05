$(document).ready(function () {
    const baseUrl = "http://localhost/PaimentLinked/"
    
        $(document).on("submit", "#registerFormUser", function(e) {
            e.preventDefault();
            let name = $("#name").val()
            let email = $("#email").val()
            let username = $("#username").val()
            let phone = $("#phone").val()
            let address = $("#address").val()
            let password = $("#password").val()
            let confirmPassword = $("#confirmPassword").val()
            $.ajax({
                url: `${baseUrl}login/handleRegister`,
                type: "POST",
                data: {
                    name,
                    username,
                    email,
                    phone,
                    address,
                    password,
                    confirmPassword,
                    action: "jddiuanjkanciuwenfas,mcn;sdiojd"
                },
                success: function(res) {
                    if (res === "success") {
                        window.location = `${baseUrl}chat`
                    } else {
                        alert(res)
                    }
                }
            })
        })
    
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
                        window.location = `${baseUrl}chat`
                    } else {
                        alert(res)
                    }
                }
            })
        })
})