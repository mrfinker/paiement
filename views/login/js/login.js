$(document).ready(function () {
  const baseUrl = "http://paiement.mr:81/";

  $(document).on("submit", "#loginFormUser", function (e) {
    e.preventDefault();

    let email = $("#email").val();
    let password = $("#password").val();
    let button = $("#moginBtn");
    let buttonText = $("#buttonText");
    let spinner = $("#spinner");

    // Désactiver le bouton et afficher le spinner
    button.prop('disabled', true);
    buttonText.hide();
    spinner.show();

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
        if (res.status === 200) {
          alertify.success("Connexion réussie.");
          setTimeout(() => {
            switch (res.userRole) {
              case 1:
                window.location = `${baseUrl}dashboard/superadmin`;
                break;
              case 2:
                window.location = `${baseUrl}dashboard/admin`;
                break;
              case 3:
                window.location = `${baseUrl}dashboard/company`;
                break;
              case 4:
                window.location = `${baseUrl}dashboard/staff`;
                break;
              default:
                window.location = `${baseUrl}error/index`;
                break;
            }
          }, 2000); // Delay redirection to allow the message to show
        } else {
          alertify.error("Erreur de connexion: " + res.msg);
        }
      },
      error: function () {
        alertify.error(
          "Une erreur s'est produite. Veuillez réessayer plus tard."
        );
      },
      complete: function() {
        // Réactiver le bouton et cacher le spinner
        button.prop('disabled', false);
        buttonText.show();
        spinner.hide();
    }
    });
  });
});