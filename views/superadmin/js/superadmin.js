$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";
  
    $(document).on("submit", "#PrivilegeForm", function (e) {
      e.preventDefault();
      let name = $("#full-name").val();
      $.ajax({
        url: `${baseUrl}register/handleRegister`,
        type: "POST",
        dataType: "JSON",
        data: {
          name,
          action: "jddiuanjkanciuwenfas,mcn;sdiojd",
        },
        success: function (res) {
          if (res.status === 200) {
            window.location.reload();
            Swal.fire({
              icon: "success",
              title: "Enregistrement réussi",
              text: res.msg,
            });
          } else if (res.status === 409) {
            Swal.fire({
              icon: "error",
              title: "Erreur lors de l'enregistrement",
              text: res.msg,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Erreur",
              text: res.msg,
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

  
$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";
    $(document).on("click", ".delete-button", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        $.ajax({
            url: `${baseUrl}superadmin/handleDeleteRole`,
            type: "POST",
            dataType: "JSON",
            data: {
                id,
            },
            success: function (res) {
                if (res.status === 200) {
                    window.location.reload();
                    Swal.fire({
                        icon: "success",
                        title: "Suppression réussie",
                        text: res.msg,
                    });
                } else if (res.status === 500) {
                    Swal.fire({
                        icon: "error",
                        title: "Erreur lors de la suppression",
                        text: res.msg,
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Erreur",
                        text: res.msg,
                    });
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "Une erreur s'est produite lors de la suppression. Veuillez réessayer plus tard.",
                });
            },
        });
    });
});

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
          if (res.status === 200) {
            window.location.reload();
            Swal.fire({
              icon: "success",
              title: "Enregistrement réussi",
              text: res.msg,
            });
          } else if (res.status === 409) {
            Swal.fire({
              icon: "error",
              title: "Erreur lors de l'enregistrement",
              text: res.msg,
            });
          } else {
            Swal.fire({
              icon: "error",
              title: "Erreur",
              text: res.msg,
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
  
