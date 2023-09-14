$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";
  
    // Ajout role
    $(document).on("click", "#btn_add_roles", function (e) {
        e.preventDefault();
        let name = $("#nom").val();
        // let permissions = {};
    
        // $("input[type='checkbox']").each(function () {
        //   permissions[$(this).attr("id")] = $(this).prop("checked") ? 1 : 0;
        // });
    
        $.ajax({
          url: `${baseUrl}superadmin/handleAddRole`, // Assurez-vous que l'URL est correcte
          type: "POST",
          dataType: "JSON",
          data: {
            nom: name,
            // permissions: JSON.stringify(permissions),  // Convertissez l'objet en chaîne JSON
          },
          success: function (res) {
            if (res.status === 200) {
              window.location.reload();
              Swal.fire({
                icon: "success",
                title: "Enregistrement réussi",
                text: res.msg,
              });
            } else {
              Swal.fire({
                icon: "error",
                title: "Erreur lors de l'enregistrement",
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
    
    // Mise a jour role(update)
    $(document).on("submit", "#UpdatePrivilegeForm", function (e) {
      e.preventDefault();
      let newName = $("#nomupdate").val();
      let id_role = parseInt($(".id_role").val());
      
      $.ajax({
          url: `${baseUrl}superadmin/updateRole`,
          type: "POST",
          dataType: "JSON",
          data: {
            id_role,
            newName,
          },
          success: function (res) {
              if (res.status === 200) {
                  window.location.reload();
                  Swal.fire({
                      icon: "success",
                      title: "Mise à jour réussie",
                      text: res.msg,
                  });
              } else if (res.status === 409) {
                  Swal.fire({
                      icon: "error",
                      title: "Erreur lors de la mise à jour",
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

    $(document).on("click", ".update_button", function (e) {
      e.preventDefault();
      let id_role = parseInt($(this).data("id"));
      let userrole_name = $(this).data("userrole-name")
      $("#nomupdate").val(userrole_name);
      $(".id_role").val(id_role);
      $("#UpdateModal").modal("show")
    });
   
    // Suppression role
    $(document).on("click", ".delete-button", function (e) {
      e.preventDefault();
      let id_role = parseInt($(this).data("id"));
      $.ajax({
          url: `${baseUrl}superadmin/handleDeleteRole`,
          type: "POST",
          dataType: "JSON",
          data: {
              id_role,
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
        url: `${baseUrl}superadmin/handleRegister`,
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

    // suppression utilisateur
    $(document).on("click", ".delete-button", function (e) {
      e.preventDefault();
      let id = parseInt($(this).data("id"));
      $.ajax({
          url: `${baseUrl}superadmin/handleDeleteUsers`,
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

    // suppression company
    $(document).on("click", ".delete-button", function (e) {
      e.preventDefault();
      let id = parseInt($(this).data("id"));
      $.ajax({
          url: `${baseUrl}superadmin/handleDeleteCompany`,
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