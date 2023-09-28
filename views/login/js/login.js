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
                action: "jddiuanjkanciuSFDSFAEEEADS;sdiojd"
            },
            success: function (res) {
              if (res.status === 200) {
                  Swal.fire({
                      icon: "success",
                      title: "Connexion réussie",
                      text: "Vous êtes maintenant connecté.",
                      showConfirmButton: false,
                      timer: 1000,
                      timerProgressBar: true
                  }).then(() => {
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
                  });
              } else {
                  Swal.fire({ icon: "error", title: "Erreur de connexion", text: res.msg });
              }
          },
          
            error: function () {
                Swal.fire(
                    {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
                );
            }
        });
    });
});
