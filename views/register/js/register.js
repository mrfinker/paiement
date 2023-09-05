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
        if (res.status === "success") {
          // Enregistrement réussi, afficher un SweetAlert de succès avec le message personnalisé
          Swal.fire({
            icon: 'success',
            title: 'Enregistrement réussi',
            text: res.msg, // Utilisez le message personnalisé récupéré de la réponse
          });
        } else {
          // Enregistrement échoué, afficher un SweetAlert d'erreur avec le message personnalisé
          Swal.fire({
            icon: 'error',
            title: 'Erreur',
            text: res.msg, // Utilisez le message personnalisé récupéré de la réponse
          });
        }
      },
      error: function () {
        // En cas d'erreur lors de l'appel AJAX
        Swal.fire({
          icon: 'error',
          title: 'Erreur',
          text: 'Une erreur s\'est produite. Veuillez réessayer plus tard.',
        });
      },
    });
  });
});
