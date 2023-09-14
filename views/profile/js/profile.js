$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";
  
    $(document).on("submit", "#Updateinfo", function (e) {
      e.preventDefault();
            let name = $("#full-name").val();
            let username = $("#display-name").val();
            let phone = $("#phone-no").val();
            let birthday = $("#birthday").val();
      $.ajax({
        url: `${baseUrl}profile/handleUpdateProfile`,
        method: "POST",
        dataType: "JSON",
        data: {
            name,
            username,
            phone,
            birthday,
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
          Swal.fire({
            icon: "error",
            title: "Erreur",
            text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
          });
        },
      });
    });
  });