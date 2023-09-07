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
          Swal.fire({
            icon: "success",
            title: "Connexion réussie",
            text: "Vous êtes maintenant connecté.",
          }).then((result) => {
            if (result.isConfirmed) {
                switch (res.userRole) {
                    case 1:
                        window.location = `${baseUrl}superadmin/dashboard`;
                        break;
                    case 2:
                        window.location = `${baseUrl}admin/dashboard`;
                        break;
                    case 3:
                        window.location = `${baseUrl}company/dashboard`;
                        break;
                    case 4:
                        window.location = `${baseUrl}staff/dashboard`;
                        break;
                    default:
                        window.location = `${baseUrl}error/index`;
                        break;
                }
            }
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Erreur de connexion",
            text: res.msg,
          });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });
});
