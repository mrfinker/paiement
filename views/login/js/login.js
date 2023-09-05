$(document).ready(function () {
  const baseUrl = "http://paiement.mr:81/";

  $(document).on("submit", "#loginFormUser", function (e) {
    e.preventDefault();
    let email = $("#email").val();
    let password = $("#password").val();
    $.ajax({
      url: `${baseUrl}login/handleLogin`,
      type: "POST",
      dataType: "JSON",
      data: {
        email,
        password,
        action: "jddiuanjkanciuSFDSFAEEEADS;sdiojd",
      },
      success: function (res) {
        console.log(res);
        if (res.status === 200) {
          // Connexion réussie, afficher une alerte SweetAlert de succès
          Swal.fire({
            icon: "success",
            title: "Connexion réussie",
            text: "Vous êtes maintenant connecté.",
          }).then((result) => {
            if (result.isConfirmed) {
              setTimeout(function () {
                window.location = `${baseUrl}dashboard`;
              }, 5000);
            }
          });
        } else {
          // Connexion échouée, afficher une alerte SweetAlert d'erreur
          Swal.fire({
            icon: "error",
            title: "Erreur de connexion",
            text: res.msg, // Utilisez le message personnalisé récupéré de la réponse
          });
        }
      },
      error: function () {
        // En cas d'erreur lors de l'appel AJAX
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });
});
