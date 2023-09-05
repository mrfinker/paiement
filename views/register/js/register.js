$(document).ready(function () {
  const baseUrl = "http://paiement.mr:81/";

  $(document).on("submit", "#registerFormUser", function (e) {
    e.preventDefault();
    let name = $("#name").val();
    let email = $("#email").val();
    let username = $("#username").val();
    let phone = $("#phone").val();
    let address = $("#address").val();
    let password = $("#password").val();
    let confirmPassword = $("#confirmPassword").val();
    $.ajax({
      url: `${baseUrl}register/handleRegister`,
      type: "POST",
      dataType: "JSON",
      data: {
        name,
        username,
        email,
        phone,
        address,
        password,
        confirmPassword,
        action: "jddiuanjkanciuwenfas,mcn;sdiojd",
      },
      success: function (res) {
        console.log(res);
        if (res === "success") {
          window.location = `${baseUrl}login`;
        } else {
          alert(res);
        }
      },
    });
  });
})