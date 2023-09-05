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
    
    // Vérifiez si les mots de passe correspondent côté client
    if (password !== confirmPassword) {
      alert("Les mots de passe ne correspondent pas.");
      return;
    }

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
      },
      success: function (res) {
        console.log(res);
        if (res.status === 200) { // Vérifiez la propriété 'status' dans la réponse JSON
          window.location = `${baseUrl}login`;
        } else {
          alert(res.msg);
        }
      },
      error: function (xhr, status, error) {
        console.error(xhr.responseText);
        alert("Une erreur s'est produite lors de l'envoi de la requête.");
      },
    });
  });
});
