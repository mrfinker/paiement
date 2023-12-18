$(document).ready(function () {
  const baseUrl = "http://paiement.mr:81/";

  // Role | Role Ajout role
  $(document).on("click", "#btn_add_roles", function (e) {
    e.preventDefault();
    let name = $("#name").val();
    let adminPermissions = [];
    // let companyPermissions = [];
    // let privilegePermissions = [];

    $("input[name='admin[]']").each(function () {
      if ($(this).is(":checked")) {
        adminPermissions.push($(this).val());
      }
    });

    // $("input[name='company[]']").each(function () {
    //     if ($(this).is(":checked")) {
    //         companyPermissions.push($(this).val());
    //     }
    // });

    // $("input[name='privilege[]']").each(function () {
    //     if ($(this).is(":checked")) {
    //         privilegePermissions.push($(this).val());
    //     }
    // });

    $.ajax({
      url: `${baseUrl}company/handleAddRole`,
      type: "POST",
      dataType: "JSON",
      data: {
        name: name,
        admin: adminPermissions,
        // company: companyPermissions,
        // privilege: privilegePermissions
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // update roles
  $(document).on("submit", "#UpdatePrivilegeForm", function (e) {
    e.preventDefault();
    let newName = $("#nomupdate").val();
    let id_role = parseInt($(".id_role").val());
    let permissions = [];
    $("input[type='checkbox']:checked").each(function () {
      permissions.push($(this).attr("id").replace("update_", ""));
    });

    $.ajax({
      url: `${baseUrl}company/updateRole`,
      type: "POST",
      dataType: "JSON",
      data: {
        id_role,
        newName,
        admin: permissions.filter((permission) =>
          permission.startsWith("admin")
        ),
        // company: permissions.filter(permission => permission.startsWith("company")),
        // privilege: permissions.filter(permission => permission.startsWith("privilege"))
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // Update role(recuperation des donnees)
  $(document).on("click", ".update_button_role", function (e) {
    e.preventDefault();
    let id_role = parseInt($(this).data("id"));
    let userrole_name = $(this).data("userrole-name");
    $("#nomupdate").val(userrole_name);
    $(".id_role").val(id_role);

    $("input[type='checkbox']").prop("checked", false);

    let checkedPrivilegesString = $(this).data("checked-role");

    let checkedPrivilegesArray = checkedPrivilegesString.split(", ");

    checkedPrivilegesArray.forEach(function (privilege) {
      let checkboxId = "update_" + privilege.toLowerCase().replace(/\s+/g, "_");

      $("#" + checkboxId).prop("checked", true);
    });

    $("#UpdateModalroles").modal("show");
  });

  // Suppression role
  $(document).on("click", ".delete-button-deleteRole", function (e) {
    e.preventDefault();
    let id_role = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteRole`,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
        }
      },
      error: function () {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text:
            "Une erreur s'est produite lors de la suppression. Veuillez réessayer plus tard" +
            ".",
        });
      },
    });
  });

  // delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete-button-role", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterRole").modal("show");
});

  // Ajouter departements
  $(document).on("submit", "#registerFormDepartements", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let formData = new FormData(this); // 'this' fait référence au formulaire soumis

    $.ajax({
      url: `${baseUrl}company/handleAddDepartment`, // Remplacez par l'URL appropriée de votre contrôleur
      type: "POST",
      dataType: "JSON",
      processData: false, // Important pour envoyer les données du formulaire avec FormData
      contentType: false, // Important pour envoyer les données du formulaire avec FormData
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // supprimer
  $(document).on("click", ".delete-button-deleterDepartment", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteDepartement`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete-button-departement", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterDepartment").modal("show");
});

  // Mise a jour departements(update)
  $(document).on("submit", "#updateFormDepartements", function (e) {
    e.preventDefault();
    let id = parseInt($(".id_departements").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
      // Gérer l'erreur, par exemple afficher une alerte
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID utilisateur non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append(".id_departements", id);

    $.ajax({
      url: `${baseUrl}company/updateDepartment`,
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // update departement(recuperation donnees)
  $(document).on("click", ".update_button_departement", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("departement-name");
    $("#departmentNameUpdate").val(name);
    $(".id_departements").val(id);
    $("#UpdateModalDepartements").modal("show");
  });

  // Designations ajouter
  $(document).on("submit", "#registerFormDesignation", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let formData = new FormData(this); // 'this' fait référence au formulaire soumis

    $.ajax({
      url: `${baseUrl}company/handleAddDesignation`, // Remplacez par l'URL appropriée de votre contrôleur
      type: "POST",
      dataType: "JSON",
      processData: false, // Important pour envoyer les données du formulaire avec FormData
      contentType: false, // Important pour envoyer les données du formulaire avec FormData
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // supprimer
  $(document).on("click", ".delete-button-deleterBranche", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteDesignation`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete-button-designation", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterBranche").modal("show");
});

  // Mise à jour désignations(update)
  $(document).on("submit", "#updateFormDesignation", function (e) {
    e.preventDefault();
    let id = parseInt($(".id_designation").val());
    if (isNaN(id)) {
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID de la désignation non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append("designation_id", id);

    $.ajax({
      url: `${baseUrl}company/updateDesignation`, // Correction du nom de la méthode
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          window.location.reload();
          Swal.fire({
            icon: "success",
            title: "Mise à jour réussie",
            text: res.msg,
          });
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // Update designation (récupération données)
  $(document).on("click", ".update_button_designation", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let designationName = $(this).data("designation-name");
    let departmentName = $(this).data("designation-depname");

    $("#designationNameUpdate").val(designationName);
    $("#departmentNameUpdate").val(departmentName); // Correction du nom de l'ID
    $(".id_designation").val(id);
    $("#UpdateModalDesignation").modal("show");
  });

  $(document).ready(function () {
    $('select[name="department_id"]').on("change", function () {
      // Ajusté ici
      var departmentId = $(this).val();
      $("#departmentNameUpdate").val(departmentId);

      if (departmentId) {
        $.ajax({
          url: `${baseUrl}company/handleAjaxRequest`,
          type: "POST",
          data: {
            departmentId: departmentId,
          },
          dataType: "json",
          success: function (data) {
            var designationSelect = $('select[name="designation_id"]');
            designationSelect.empty();
            designationSelect.append(
              '<option value="" disabled selected>Designations</option>'
            );

            $.each(data, function (key, value) {
              designationSelect.append(
                '<option value="' +
                  value.designation_id +
                  '">' +
                  value.designation_name +
                  "</o" +
                  "ption>"
              );
            });

            designationSelect.prop("disabled", false);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown); // Log pour débugger
          },
        });
      }
    });
  });

  // // Depenses et Depot_type Ajouter
  // $(document).on("submit", "#registerFormDepExp", function (e) {
  //   // ajusté pour cibler le formulaire, pas le bouton
  //   e.preventDefault();

  //   let formData = new FormData(this); // 'this' fait référence au formulaire soumis

  //   $.ajax({
  //     url: `${baseUrl}company/handleAddDepExp`, // Remplacez par l'URL appropriée de votre contrôleur
  //     type: "POST",
  //     dataType: "JSON",
  //     processData: false, // Important pour envoyer les données du formulaire avec FormData
  //     contentType: false, // Important pour envoyer les données du formulaire avec FormData
  //     data: formData,
  //     success: function (res) {
  //       if (res.status === 200) {
  //         let timerInterval;
  //         Swal.fire({
  //           icon: "success",
  //           title: "Enregistrement réussi",
  //           text: res.msg,
  //           timer: 100, // Par exemple, disparaît après 2 secondes
  //           timerProgressBar: true,
  //           willOpen: () => {
  //             Swal.showLoading();
  //             timerInterval = setInterval(() => {
  //               const content = Swal.getContent();
  //               if (content) {
  //                 const b = content.querySelector("b");
  //                 if (b) {
  //                   b.textContent = Swal.getTimerLeft();
  //                 }
  //               }
  //             }, 100);
  //           },
  //           willClose: () => {
  //             clearInterval(timerInterval);
  //           },
  //         }).then((result) => {
  //           if (result.dismiss === Swal.DismissReason.timer) {
  //             console.log("Fermé par le timer");
  //             window.location.href = window.location.href;
  //           }
  //         });
  //       } else {
  //         Swal.fire({
  //           icon: "error",
  //           title: "Erreur lors de l'enregistrement",
  //           text: res.msg,
  //         });
  //       }
  //     },

  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // // Depense et depot supprimer
  // $(document).on("click", ".delete-button-category-depexp", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(this).data("id"));
  //   $.ajax({
  //     url: `${baseUrl}company/handleDeleteCategoryDepExp`, // Notez le changement d'URL ici
  //     type: "POST",
  //     dataType: "JSON",
  //     data: {
  //       id,
  //     },
  //     success: function (res) {
  //       if (res.status === 200) {
  //         window.location.reload();
  //         Swal.fire({
  //           icon: "success",
  //           title: "Suppression réussie",
  //           text: res.msg,
  //         });
  //       } else {
  //         Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
  //       }
  //     },
  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // // Depense et depot Mise à jour(update)
  // $(document).on("submit", "#updateFormDepExp", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(".id_constants").val());
  //   if (isNaN(id)) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Erreur",
  //       text: "ID de la désignation non valide",
  //     });
  //     return;
  //   }

  //   let formData = new FormData(this);
  //   formData.append("constants_id", id);

  //   $.ajax({
  //     url: `${baseUrl}company/updateDepExp`, // Correction du nom de la méthode
  //     type: "POST",
  //     dataType: "JSON",
  //     processData: false,
  //     contentType: false,
  //     data: formData,
  //     success: function (res) {
  //       if (res.status === 200) {
  //         window.location.reload();
  //         Swal.fire({
  //           icon: "success",
  //           title: "Mise à jour réussie",
  //           text: res.msg,
  //         });
  //       } else {
  //         Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
  //       }
  //     },
  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // // Depense et Depot Update (récupération données)
  // $(document).on("click", ".update_button_category-depexp", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(this).data("id"));
  //   let depexpName = $(this).data("depexp-name");

  //   $("#depexpNameUpdate").val(depexpName);
  //   $(".id_constants").val(id);
  //   $("#UpdateModalDepExp").modal("show");
  // });

  // // Depense ajout
  // $(document).on("submit", "#registerFormDepenses", function (e) {
  //   // ajusté pour cibler le formulaire, pas le bouton
  //   e.preventDefault();

  //   let account_name = $("[name='account_name']").val();
  //   let amount = $("#amount").val();
  //   let transaction_date = $("#transaction_date").val();
  //   let parts = transaction_date.split("/");
  //   if (parts.length === 3) {
  //     transaction_date = parts[2] + "-" + parts[0] + "-" + parts[1];
  //   } else {
  //     parts = transaction_date.split("-");
  //     if (parts.length === 3) {
  //       let year = parts[0];
  //       let month = parts[1];
  //       let day = parts[2];
  //       transaction_date = year + "-" + month + "-" + day;
  //     }
  //   }
  //   let entity_category_id = $("#entity_category_id").val();
  //   let staff_id = $("#staff_id").val();
  //   let payement_method = $("#payement_method").val();
  //   let reference = $("#reference").val();
  //   let description = $("#description").val();

  //   $.ajax({
  //     url: `${baseUrl}company/handleAddDepenses`,
  //     method: "POST",
  //     dataType: "JSON",
  //     data: {
  //       account_name,
  //       amount,
  //       transaction_date,
  //       entity_category_id,
  //       staff_id,
  //       payement_method,
  //       reference,
  //       description,
  //     },
  //     success: function (res) {
  //       if (res.status === 200) {
  //         let timerInterval;
  //         Swal.fire({
  //           icon: "success",
  //           title: "Enregistrement réussi",
  //           text: res.msg,
  //           timer: 100, // Par exemple, disparaît après 2 secondes
  //           timerProgressBar: true,
  //           willOpen: () => {
  //             Swal.showLoading();
  //             timerInterval = setInterval(() => {
  //               const content = Swal.getContent();
  //               if (content) {
  //                 const b = content.querySelector("b");
  //                 if (b) {
  //                   b.textContent = Swal.getTimerLeft();
  //                 }
  //               }
  //             }, 100);
  //           },
  //           willClose: () => {
  //             clearInterval(timerInterval);
  //           },
  //         }).then((result) => {
  //           if (result.dismiss === Swal.DismissReason.timer) {
  //             console.log("Fermé par le timer");
  //             window.location.href = window.location.href;
  //           }
  //         });
  //       } else {
  //         Swal.fire({
  //           icon: "error",
  //           title: "Erreur lors de l'enregistrement",
  //           text: res.msg,
  //         });
  //       }
  //     },

  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // // Depots ajout
  // $(document).on("submit", "#registerFormDepots", function (e) {
  //   // ajusté pour cibler le formulaire, pas le bouton
  //   e.preventDefault();

  //   let account_name = $("[name='account_name']").val();
  //   let amount = $("#amount").val();
  //   let transaction_date = $("#transaction_date").val();
  //   let parts = transaction_date.split("/");
  //   if (parts.length === 3) {
  //     transaction_date = parts[2] + "-" + parts[0] + "-" + parts[1];
  //   } else {
  //     parts = transaction_date.split("-");
  //     if (parts.length === 3) {
  //       let year = parts[0];
  //       let month = parts[1];
  //       let day = parts[2];
  //       transaction_date = year + "-" + month + "-" + day;
  //     }
  //   }
  //   let entity_category_id = $("#entity_category_id").val();
  //   let staff_id = $("#staff_id").val();
  //   let payement_method = $("#payement_method").val();
  //   let reference = $("#reference").val();
  //   let description = $("#description").val();

  //   $.ajax({
  //     url: `${baseUrl}company/handleAddDepots`,
  //     method: "POST",
  //     dataType: "JSON",
  //     data: {
  //       account_name,
  //       amount,
  //       transaction_date,
  //       entity_category_id,
  //       staff_id,
  //       payement_method,
  //       reference,
  //       description,
  //     },
  //     success: function (res) {
  //       if (res.status === 200) {
  //         let timerInterval;
  //         Swal.fire({
  //           icon: "success",
  //           title: "Enregistrement réussi",
  //           text: res.msg,
  //           timer: 100, // Par exemple, disparaît après 2 secondes
  //           timerProgressBar: true,
  //           willOpen: () => {
  //             Swal.showLoading();
  //             timerInterval = setInterval(() => {
  //               const content = Swal.getContent();
  //               if (content) {
  //                 const b = content.querySelector("b");
  //                 if (b) {
  //                   b.textContent = Swal.getTimerLeft();
  //                 }
  //               }
  //             }, 100);
  //           },
  //           willClose: () => {
  //             clearInterval(timerInterval);
  //           },
  //         }).then((result) => {
  //           if (result.dismiss === Swal.DismissReason.timer) {
  //             console.log("Fermé par le timer");
  //             window.location.href = window.location.href;
  //           }
  //         });
  //       } else {
  //         Swal.fire({
  //           icon: "error",
  //           title: "Erreur lors de l'enregistrement",
  //           text: res.msg,
  //         });
  //       }
  //     },

  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // $(document).on("click", ".delete-button-transaction-depexp", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(this).data("id"));
  //   $.ajax({
  //     url: `${baseUrl}company/handleDeleteTransactionDepExp`, // Notez le changement d'URL ici
  //     type: "POST",
  //     dataType: "JSON",
  //     data: {
  //       id,
  //     },
  //     success: function (res) {
  //       if (res.status === 200) {
  //         window.location.reload();
  //         Swal.fire({
  //           icon: "success",
  //           title: "Suppression réussie",
  //           text: res.msg,
  //         });
  //       } else {
  //         Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
  //       }
  //     },
  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // // Transactions Mise à jour(update)
  // $(document).on("submit", "#updateFormTransactions", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(".transactions_id").val());
  //   if (isNaN(id)) {
  //     Swal.fire({
  //       icon: "error",
  //       title: "Erreur",
  //       text: "ID de la désignation non valide",
  //     });
  //     return;
  //   }

  //   let formData = new FormData(this);
  //   formData.append("transactions_id", id);

  //   $.ajax({
  //     url: `${baseUrl}company/updateTransactions`, // Correction du nom de la méthode
  //     type: "POST",
  //     dataType: "JSON",
  //     processData: false,
  //     contentType: false,
  //     data: formData,
  //     success: function (res) {
  //       if (res.status === 200) {
  //         window.location.reload();
  //         Swal.fire({
  //           icon: "success",
  //           title: "Mise à jour réussie",
  //           text: res.msg,
  //         });
  //       } else {
  //         Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
  //       }
  //     },
  //     error: function () {
  //       Swal.fire({
  //         icon: "error",
  //         title: "Erreur",
  //         text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
  //       });
  //     },
  //   });
  // });

  // $(document).on("click", ".update_button_transaction-depexp", function (e) {
  //   e.preventDefault();
  //   let id = parseInt($(this).data("id"));
  //   let amount = $(this).data("transactions-amount");
  //   let date = $(this).data("transactions-date");

  //   $("#TransactionAmount").val(amount);
  //   $("#transactionDate").val(date);
  //   $(".transactions_id").val(id);
  //   $("#UpdateModalTransactions").modal("show");
  // });

  // Horaire Ajouter
  $(document).on("submit", "#registerFormTime", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: `${baseUrl}company/handleAddHoraire`, // Assurez-vous que c'est la bonne URL pour votre méthode de contrôleur.
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 500, // Vous pouvez ajuster le temps comme vous le souhaitez.
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href; // Recharge la page, vous pouvez aussi rediriger vers une autre page si vous préférez.
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // supprimer
  $(document).on("click", ".delete-button-deleteOffice", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteHoraire`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete-button-horaire", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterOffice").modal("show");
});

  // calcul asynchrone des heures
  $(document).ready(function () {
    // La fonction de mise à jour pour total_hours
    function updateTotalHours() {
      let totalHours = 0;

      [
        "lundi",
        "mardi",
        "mercredi",
        "jeudi",
        "vendredi",
        "samedi",
        "dimanche",
      ].forEach((day) => {
        let inTime = $(`#${day}_in`).val(); // heure d'entrée
        let outTime = $(`#${day}_out`).val(); // heure de sortie

        if (inTime && outTime) {
          let inMoment = moment(inTime, "hh:mm A");
          let outMoment = moment(outTime, "hh:mm A");

          let hoursWorked = outMoment.diff(inMoment, "hours", true); // true pour obtenir un nombre décimal
          totalHours += hoursWorked;
        }
      });

      $("#total_hours").val(Math.round(totalHours));
    }

    // La fonction de mise à jour pour total_days
    function updateTotalDaysAndHours() {
      let totalHours = 0;

      [
        "lundi",
        "mardi",
        "mercredi",
        "jeudi",
        "vendredi",
        "samedi",
        "dimanche",
      ].forEach((day) => {
        let inTime = $(`#${day}_in`).val();
        let outTime = $(`#${day}_out`).val();

        if (inTime && outTime) {
          let inMoment = moment(inTime, "hh:mm A");
          let outMoment = moment(outTime, "hh:mm A");

          let hoursWorked = outMoment.diff(inMoment, "hours", true);
          totalHours += hoursWorked;
        }
      });

      let totalDays = Math.floor(totalHours / 8);
      let remainingHours = totalHours % 8;
      $("#total_days").val(
        `${totalDays} jours ${remainingHours.toFixed(2)} heures`
      );
    }

    // Attacher l'événement de mise à jour à chaque input
    $(".time-picker").on("change blur", function () {
      updateTotalHours();
      updateTotalDaysAndHours(); // Appeler les deux fonctions indépendamment à chaque modification ou perte de focus de l'input
    });
  });

  //   mise a jour complet
  $(document).ready(function () {
    function updateTotalHours() {
      let totalHours = 0;
      [
        "lundi",
        "mardi",
        "mercredi",
        "jeudi",
        "vendredi",
        "samedi",
        "dimanche",
      ].forEach((day) => {
        let inTime = $(`#update${day}_in`).val(); // heure d'entrée
        let outTime = $(`#update${day}_out`).val(); // heure de sortie

        if (inTime && outTime) {
          let inMoment = moment(inTime, "hh:mm A"); // Note: 'hh:mm A' est pour 12 heures, 'HH:mm' est pour 24 heures.
          let outMoment = moment(outTime, "hh:mm A");

          let hoursWorked = outMoment.diff(inMoment, "hours", true);
          totalHours += hoursWorked;
        }
      });

      $("#updatetotal_hours").val(Math.round(totalHours));
    }

    $(".time-picker").on("blur", function () {
      updateTotalHours();
    });

    $(document).on("submit", "#updateFormTime", function (e) {
      e.preventDefault();
      updateTotalHours(); // Mettre à jour les total_hours lors de la soumission

      let formData = new FormData(this);
      formData.append("id", $(".id_horaire").val());
      $.ajax({
        url: `${baseUrl}company/updateHoraire`,
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (data) {
          console.log("Success:", data);
          if (data.status === 200) {
            location.reload(); // Recharger la page si la mise à jour est réussie
          } else {
            alert(data.msg); // Vous pouvez aussi montrer un message d'erreur à l'utilisateur
          }
        },
        error: function (error) {
          console.error("Error:", error);
        },
      });
    });

    // Update horaire (récupération données)
    $(document).on("click", ".update_button_horaire", function (e) {
      e.preventDefault();
      let id = $(this).data("id");
      let horaireName = $(this).data("horaire-name");
      let horaireTime = $(this).data("horaire-time");
      let mondayIn = $(this).data("horaire-monday-in");
      let mondayOut = $(this).data("horaire-monday-out");
      let tuesdayIn = $(this).data("horaire-tuesday-in");
      let tuesdayOut = $(this).data("horaire-tuesday-out");
      let wednesdayIn = $(this).data("horaire-wednesday-in");
      let wednesdayOut = $(this).data("horaire-wednesday-out");
      let thursdayIn = $(this).data("horaire-thursday-in");
      let thursdayOut = $(this).data("horaire-thursday-out");
      let fridayIn = $(this).data("horaire-friday-in");
      let fridayOut = $(this).data("horaire-friday-out");
      let saturdayIn = $(this).data("horaire-saturday-in");
      let saturdayOut = $(this).data("horaire-saturday-out");
      let sundayIn = $(this).data("horaire-sunday-in");
      let sundayOut = $(this).data("horaire-sunday-out");

      $("#updateshift_name").val(horaireName);
      $("#updatetotal_hours").val(horaireTime);
      $("#updatelundi_in").val(mondayIn);
      $("#updatelundi_out").val(mondayOut);
      $("#updatemardi_in").val(tuesdayIn);
      $("#updatemardi_out").val(tuesdayOut);
      $("#updatemercredi_in").val(wednesdayIn);
      $("#updatemercredi_out").val(wednesdayOut);
      $("#updatejeudi_in").val(thursdayIn);
      $("#updatejeudi_out").val(thursdayOut);
      $("#updatevendredi_in").val(fridayIn);
      $("#updatevendredi_out").val(fridayOut);
      $("#updatesamedi_in").val(saturdayIn);
      $("#updatesamedi_out").val(saturdayOut);
      $("#updatedimanche_in").val(sundayIn);
      $("#updatedimanche_out").val(sundayOut);
      $(".id_horaire").val(id);
      $("#updateModalTime").modal("show");
    });
  });

  // Users utilisateur | utilisateurs suppression utilisateurs
  $(document).on("click", ".delete-button-usercompp", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteUserscomp`,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
        }
      },
    });
  });

  // Ajouter utilisateurs
  $(document).on("submit", "#registerFormUserCompany", function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
      url: `${baseUrl}company/handleRegisterUsers`,
      type: "POST",
      dataType: "JSON",
      data: formData,
      processData: false,
      contentType: false,
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // Mise a jour utilisateur(update)
  $(document).on("submit", "#updateFormUsercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(".id_users").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
      // Gérer l'erreur, par exemple afficher une alerte
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID utilisateur non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append("id_users", id);

    $.ajax({
      url: `${baseUrl}company/updateUsers`,
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
      success: function (res) {
        console.log(res);
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
        }
      },
      error: function (error) {
        console.log(error);
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // update utilisateur(recuperation donnees)
  $(document).on("click", ".update_button_usercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("userprofile-name");
    let username = $(this).data("userprofile-username");
    let email = $(this).data("userprofile-email");
    let phone = $(this).data("userprofile-phone");
    let address = $(this).data("userprofile-address");
    let birthday = $(this).data("userprofile-birthday");
    let marital_status = $(this).data("userprofile-marital_status");
    let poste_name = $(this).data("userprofile-poste_name");
    let employeeid = $(this).data("userprofile-employeeid");
    let gender = $(this).data("userprofile-gender");
    let role = $(this).data("userprofile-role");
    let departement = $(this).data("userprofile-departement");
    let designation = $(this).data("userprofile-designation");
    let working_time = $(this).data("userprofile-working_time");
    let salaire_base = $(this).data("userprofile-salaire_base");
    let salary_type = $(this).data("userprofile-salary_type");
    let contract_type = $(this).data("userprofile-contract_type");
    let updatecountry = $(this).data("userprofile-country");
    $("#updatename").val(name);
    $("#updateusername").val(username);
    $("#updateemail").val(email);
    $("#updatephone").val(phone);
    $("#updateaddress").val(address);
    $("#updatebirthday").val(birthday);
    $("#updatestatus_marital").val(marital_status);
    $("#updateposte").val(poste_name);
    $("#updateemployeid").val(employeeid);
    $("#updategender").val(gender);
    $("#updateuser_role").val(role);
    $("#updatedepartment_id").val(departement);
    $("#updatedesignation_id").val(designation);
    $("#updateworking_time").val(working_time);
    $("#updatesalaire_base").val(salaire_base);
    $("#updatepaiement_type").val(salary_type);
    $("#updatecontract_type").val(contract_type);
    $("#updatecountry").val(updatecountry);
    $(".id_users").val(id);
    // Sélectionner la bonne option dans le menu déroulant de la désignation
    $("select[name='updatedesignation_id']").val(designation);
    $("#UpdateModalUsercomp").modal("show");
  });

  // voir utilisateur(recuperation donnees)
  $(document).on("click", ".voir_button_usercomp", function (e) {
    e.preventDefault();
    let imageUrl = $(this).data("userview_image");

    $("#viewimage").attr("src", imageUrl);
    let id = parseInt($(this).data("id"));
    let name = $(this).data("userview_name");
    let username = $(this).data("userview_username");
    let email = $(this).data("userview_email");
    let phone = $(this).data("userview_phone");
    let address = $(this).data("userview_address");
    let birthday = $(this).data("userview_birthday");
    $("#viewname").val(name);
    $("#viewusername").val(username);
    $("#viewemail").val(email);
    $("#viewphone").val(phone);
    $("#viewaddress").val(address);
    $("#viewbirthday").val(birthday);
    $(".id_users").val(id);
    $("#viewModalProfile").modal("show");
  });

  // delete utilisateur(recuperation donnees)
  $(document).on("click", ".delete-button-usercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $(".id_users").val(id);
    $("#deleterUser").modal("show");
  });

  // Paye calcul et affichage
  $(document).on("click", ".paye_button_usercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let bs = parseFloat($(this).data("basic_salary"));
    let hours_time = Number($(this).data("total_time"));
    let children = Number($(this).data("children"));
    let spouse = Number($(this).data("spouse"));
    let timesheet_count = Number($(this).data("timesheet_count"));
    let advanced_salary = Number($(this).data("advanced_salary"));
    console.log(advanced_salary);
    let regularization = 0;
    // Number($(this).data("regularization"))
    let other = 0;
    // Number($(this).data("other"))
    let leave = 0;
    // Number($(this).data("leave"))
    let monthlastone = 0;
    // Number($(this).data("monthlastone"))
    let telephone = 0;
    // Number($(this).data("telephone"))
    let country = $(this).data("country");

    $("#basic_salary").val(bs);
    $("#hours_time").val(hours_time);
    $("#country").text(`${country}`);
    $("#timesheet_count").val(`${timesheet_count}`);
    $(".id_users").val(id);
    $("#payeModalUsercomp").modal("show");

    // Afficher la valeur dans le badge
    $("#hours_time_badge").text(`${hours_time} heures/semaine`);

    // Calculez le nombre de jours et le reste des heures
    let total_hours_month = parseInt(hours_time * 4);
    let jours = Number(Math.floor(total_hours_month / 8)); // 8 heures par jour
    let heures = parseInt(total_hours_month % 8); // Le reste des heures

    // Calcul du salaire de base new
    let absent_days = jours - timesheet_count;
    if (absent_days < 0) {
      absent_days = 0; // Si absent_days est négatif, définissez-le à 0
    }
    $("#absent_days").val(absent_days); // Mettez à jour la valeur du champ "Jours absent"

    if (absent_days >= jours) {
      $("#final_salary_display").text("0 $");
      $("#transport_display").text("0 $");
      console.log(absent_days);
    } else {
      let jours_travailles = jours - absent_days;

      let bsp = ((bs + bs * 0) / jours) * jours_travailles;
      let salary_imposable =
        bsp + regularization + other + leave + monthlastone;
      // Le reste de votre code ici, et utilisez salary_imposable comme vous le
      // souhaitez.
      $("#salary_imposable_display").text(salary_imposable.toFixed(2) + " $");
      $("#salary_imposable").val(salary_imposable.toFixed(2));

      let housing = ((bsp + regularization + leave) * 30) / 100;
      if (isNaN(housing)) {
        housing = 0;
      }

      // Afficher la valeur de net_before_taxes dans le DOM, si vous avez un élément
      // HTML approprié pour cela
      $("#housing_display").text(housing + " $");
      $("#housing").val(housing);

      let Transport = 0.545454545454545 * 4 * jours_travailles;
      $("#transport_display").text(Transport.toFixed(2) + " $");
      $("#transport").val(Transport.toFixed(2));

      if (isNaN(regularization)) regularization = 0;
      $("#regularization").text(`${regularization} / Regularization`);
      if (isNaN(other)) other = 0;
      $("#other").text(`${other} / Other`);
      if (isNaN(leave)) leave = 0;
      $("#leave").text(`${leave} / Leave`);
      if (isNaN(monthlastone)) monthlastone = 0;
      $("#monthlastone").text(`${monthlastone} / 13th Month`);
      $("#advanced_salary").text(`${advanced_salary} / Advanced Salary`);
      if (isNaN(children)) children = 0;
      $("#children").text(`${children} / Enfants`);
      if (isNaN(spouse)) spouse = 0;
      $("#spouse").text(`${spouse} / Epouse`);
      if (isNaN(telephone)) telephone = 0;
      $("#telephone").text(`${telephone} / Telephone`);

      $("#jours").text(jours + " jours" + " / mois");

      let cnss_company = (salary_imposable * 13) / 100;
      $("#cnss_company_display").text(cnss_company.toFixed(2) + " $");
      $("#cnss_company").val(cnss_company.toFixed(2));

      let iere;
      if (country.toLowerCase() === "republique democratique du congo") {
        iere = 0;
      } else {
        iere = (salary_imposable * 25) / 100;
      }
      $("#iere_display").text(iere + " $");
      $("#iere").val(iere);

      let inpp = (salary_imposable * 3) / 100;
      $("#inpp_display").text(inpp + " $");
      $("#inpp").val(inpp);

      let onem = (salary_imposable * 0.2) / 100;
      $("#onem_display").text(onem.toFixed(2) + " $");
      $("#onem").val(onem);

      let cnss = (salary_imposable * 5) / 100;
      if (isNaN(cnss)) cnss = 0;

      // Afficher la valeur de cnss dans le DOM, si vous avez un élément HTML
      // approprié pour cela
      $("#cnss_display").text(cnss.toFixed(2) + " $");
      $("#cnss").val(cnss);

      let net_before_taxes = salary_imposable - cnss;
      if (isNaN(net_before_taxes)) net_before_taxes = 0;

      // Afficher la valeur de net_before_taxes dans le DOM, si vous avez un élément
      // HTML approprié pour cela
      $("#net_before_taxes_display").text(net_before_taxes.toFixed(2) + " $");
      $("#net_before_taxes").val(net_before_taxes);

      // Calcul important en fond
      let usdFranc;
      let exchange_rate = 2300;
      let net_before_taxes_franc = net_before_taxes * 2300;

      if (net_before_taxes_franc > 0 && net_before_taxes_franc < 162001) {
        usdFranc = 4860;
      } else if (
        net_before_taxes_franc > 162000 &&
        net_before_taxes_franc < 1800001
      ) {
        let intermediate = 4860 + (net_before_taxes_franc - 162000) * 0.15;
        usdFranc =
          intermediate - intermediate * (((spouse + children) * 2) / 100);
      } else if (
        net_before_taxes_franc > 1800000 &&
        net_before_taxes_franc < 3600001
      ) {
        let intermediate = 250560 + (net_before_taxes_franc - 1800000) * 0.3;
        usdFranc =
          intermediate - intermediate * (((spouse + children) * 2) / 100);
      } else if (
        net_before_taxes_franc > 3600000 &&
        net_before_taxes_franc < 100000000000
      ) {
        let intermediate = 790560 + (net_before_taxes_franc - 3600000) * 0.4;
        usdFranc =
          intermediate - intermediate * (((spouse + children) * 2) / 100);
      } else {
        usdFranc = net_before_taxes_franc * 0.3;
      }

      let convertUsdFc = usdFranc / exchange_rate;
      $("#convertUsdFc").text(convertUsdFc.toFixed(2));

      // Fin du calcul important en fond

      let ipr_franc;

      if (usdFranc < 2000) {
        ipr_franc = 2000;
      } else if (usdFranc > net_before_taxes_franc * 0.3) {
        ipr_franc = net_before_taxes_franc * 0.3;
      } else {
        ipr_franc = usdFranc;
      }
      ipr = ipr_franc / exchange_rate;
      $("#ipr_display").text(ipr.toFixed(2) + " $");
      $("#ipr").val(ipr.toFixed(2));

      let net_after_taxes = net_before_taxes - ipr;
      $("#net_after_taxes_display").text(net_after_taxes.toFixed(2) + " $");
      $("#net_after_taxes").val(net_after_taxes.toFixed(2));

      let salaire_final = (bsp / jours) * jours_travailles;
      $("#final_salary_display").text(salaire_final.toFixed(2) + " $");
      $("#final_salary").val(salaire_final.toFixed(2));

      let salary_net =
        net_after_taxes + housing + Transport + telephone - advanced_salary;
      $("#salary_net_display").text(salary_net.toFixed(2) + " $");
      $("#salary_net").val(salary_net.toFixed(2));

      let salary_brut_company =
        salary_net + cnss + cnss_company + ipr + iere + inpp + onem;
      $("#salary_brut_company_display").text(
        salary_brut_company.toFixed(2) + " $"
      );
      $("#salary_brut_company").val(salary_brut_company.toFixed(2));
    }
  });

  // Ajouter payements
  $(document).on("submit", "#payeFormUsercomp", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let year = document.getElementById("year-select").value; // Récupère l'année
    let month = document.getElementById("month-select").value; // Récupère le mois

    // Ajoute l'année et le mois au formData
    let formData = new FormData(this);
    formData.append("year", year);
    formData.append("month", month);
    console.log("Données envoyées :", formData);

    $.ajax({
      url: `${baseUrl}company/handleAddPayments`, // Remplacez par l'URL appropriée de votre contrôleur
      type: "POST",
      dataType: "JSON",
      processData: false, // Important pour envoyer les données du formulaire avec FormData
      contentType: false, // Important pour envoyer les données du formulaire avec FormData
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // selection departement pour afficher sa branche
  $(document).ready(function () {
    $('select[name="department_id"]').on("change", function () {
      // Ajusté ici
      var departmentId = $(this).val();

      if (departmentId) {
        $.ajax({
          url: `${baseUrl}company/handleAjaxRequest`,
          type: "POST",
          data: {
            departmentId: departmentId,
          },
          dataType: "json",
          success: function (data) {
            var designationSelect = $('select[name="designation_id"]');
            designationSelect.empty();
            designationSelect.append(
              '<option value="" disabled selected>Choisissez la branche</option>'
            );

            $.each(data, function (key, value) {
              designationSelect.append(
                '<option value="' +
                  value.designation_id +
                  '">' +
                  value.designation_name +
                  "</o" +
                  "ption>"
              );
            });

            designationSelect.prop("disabled", false);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown); // Log pour débugger
          },
        });
      }
    });
  });

  // selection departement pour afficher sa branche
  $(document).ready(function () {
    $('select[name="updatedepartment_id"]').on("change", function () {
      // Ajusté ici
      var departmentId = $(this).val();

      if (departmentId) {
        $.ajax({
          url: `${baseUrl}company/handleAjaxRequest`,
          type: "POST",
          data: {
            departmentId: departmentId,
          },
          dataType: "json",
          success: function (data) {
            var designationSelect = $('select[name="updatedesignation_id"]');
            designationSelect.empty();
            designationSelect.append(
              '<option value="" disabled selected>Choisissez la branche</option>'
            );

            $.each(data, function (key, value) {
              designationSelect.append(
                '<option value="' +
                  value.designation_id +
                  '">' +
                  value.designation_name +
                  "</o" +
                  "ption>"
              );
            });

            designationSelect.prop("disabled", false);
          },
          error: function (jqXHR, textStatus, errorThrown) {
            console.error("AJAX Error:", textStatus, errorThrown); // Log pour débugger
          },
        });
      }
    });
  });

  // Voir facture paiement
  // $(document).on('click', '.facture_button_usercomp', function (e) {
  //     e.preventDefault();

  //     let id = $(this).data('id');
  //     let name = $(this).data('name');
  //     let address = $(this).data('address');
  //     let phone = $(this).data('phone');
  //     let basicSalary = $(this).data('basic_salary');
  //     let created_at = $(this).data('created_at');
  //     let totalTime = $(this).data('total_time');
  //     let country = $(this).data('country');
  //     let payslip_value = $(this).data('payslip_value');
  //     let payslip_code = $(this).data('payslip_code');
  //     let salary_month = $(this).data('salary_month');
  //     let year_to_date = $(this).data('year_to_date');
  //     let designation = $(this).data('designation');
  //     let department = $(this).data('department');
  //     let net_salary = $(this).data('net_salary');
  //     let housing = $(this).data('housing');
  //     let transport = $(this).data('transport');
  //     let advance_salary = $(this).data('advance_salary');
  //     let net_after_taxes = $(this).data('net_after_taxes');

  //     // Stocker les données dans le localStorage ou sessionStorage
  //     sessionStorage.setItem('id', id);
  //     sessionStorage.setItem('name', name);
  //     sessionStorage.setItem('address', address);
  //     sessionStorage.setItem('phone', phone);
  //     sessionStorage.setItem('created_at', created_at);
  //     sessionStorage.setItem('basicSalary', basicSalary);
  //     sessionStorage.setItem('totalTime', totalTime);
  //     sessionStorage.setItem('country', country);
  //     sessionStorage.setItem('payslip_value', payslip_value);
  //     sessionStorage.setItem('payslip_code', payslip_code);
  //     sessionStorage.setItem('salary_month', salary_month);
  //     sessionStorage.setItem('year_to_date', year_to_date);
  //     sessionStorage.setItem('designation', designation);
  //     sessionStorage.setItem('department', department);
  //     sessionStorage.setItem('net_salary', net_salary);
  //     sessionStorage.setItem('housing', housing);
  //     sessionStorage.setItem('transport', transport);
  //     sessionStorage.setItem('advance_salary', advance_salary);
  //     sessionStorage.setItem('net_after_taxes', net_after_taxes);

  //     let url = `${baseUrl}company/generate_paie_pdf?` +
  //       `id=${id}&name=${encodeURIComponent(name)}&address=${encodeURIComponent(address)}&` +
  //       `phone=${phone}&basicSalary=${basicSalary}&created_at=${created_at}&` +
  //       `totalTime=${totalTime}&country=${country}&payslip_value=${payslip_value}&` +
  //       `payslip_code=${payslip_code}&salary_month=${salary_month}&` +
  //       `year_to_date=${year_to_date}&designation=${designation}&department=${encodeURIComponent(department)}&` +
  //       `net_salary=${net_salary}&housing=${housing}&transport=${transport}&` +
  //       `advance_salary=${advance_salary}&net_after_taxes=${net_after_taxes}`;
  //         window.open(url, '_blank');

  // });

  $(document).on("click", ".facture_button_usercomp", function (e) {
    e.preventDefault();
    let data = {
      id: $(this).data("id"),
      name: $(this).data("name"),
      address: $(this).data("address"),
      phone: $(this).data("phone"),
      basicSalary: $(this).data("basic_salary"),
      created_at: $(this).data("created_at"),
      totalTime: $(this).data("total_time"),
      country: $(this).data("country"),
      payslip_value: $(this).data("payslip_value"),
      payslip_code: $(this).data("payslip_code"),
      salary_month: $(this).data("salary_month"),
      year_to_date: $(this).data("year_to_date"),
      designation: $(this).data("designation"),
      department: $(this).data("department"),
      net_salary: $(this).data("net_salary"),
      housing: $(this).data("housing"),
      transport: $(this).data("transport"),
      advance_salary: $(this).data("advance_salary"),
      net_after_taxes: $(this).data("net_after_taxes"),
    };

    // Stocker les données dans sessionStorage
    Object.keys(data).forEach((key) => sessionStorage.setItem(key, data[key]));

    $.ajax({
      url: `${baseUrl}company/generatePaiePdfAjax`,
      type: "POST",
      data: data,
      success: function (response) {
        alert("La facture a été générée avec succès !");

        // Ouvre l'URL dans un nouvel onglet
        if (response.redirectUrl) {
          window.open(response.redirectUrl, "_blank");
        } else {
          console.error("URL de redirection manquante dans la réponse");
        }

        console.log(response.data); // Assurez-vous que cela fait partie de la réponse si nécessaire
      },
      error: function (xhr, status, error) {
        alert("Une erreur est survenue : " + error);
      },
    });
  });

  $(document).ready(function () {
    let basicSalary = sessionStorage.getItem("basicSalary");
    let totalTime = sessionStorage.getItem("totalTime");
    let country = sessionStorage.getItem("country");
    let name = sessionStorage.getItem("name");
    let address = sessionStorage.getItem("address");
    let phone = sessionStorage.getItem("phone");
    let created_at = sessionStorage.getItem("created_at");
    let year_to_date = sessionStorage.getItem("year_to_date");
    let payslip_code = sessionStorage.getItem("payslip_code");
    let payslip_code_ = payslip_code;
    let salary_month = sessionStorage.getItem("salary_month");
    let designation = sessionStorage.getItem("designation");
    let department = sessionStorage.getItem("department");
    let net_salary = sessionStorage.getItem("net_salary");
    let housing = sessionStorage.getItem("housing");
    let transport = sessionStorage.getItem("transport");
    let advance_salary = sessionStorage.getItem("advance_salary");
    let net_after_taxes = sessionStorage.getItem("net_after_taxes");

    // Sélectionner l'élément par son ID et changer son contenu Utiliser les données
    // récupérées comme vous le souhaitez
    document.getElementById("name").textContent = name;
    document.getElementById("address").textContent = address;
    document.getElementById("created_at").textContent = created_at;
    document.getElementById("phone").textContent = phone;
    document.getElementById("invoice_date_value").textContent = year_to_date;
    document.getElementById("payslip_code").textContent = payslip_code;
    document.getElementById("payslip_code_").textContent = payslip_code_;
    document.getElementById("salary_month").textContent = salary_month;
    document.getElementById("designation").textContent = designation;
    document.getElementById("department").textContent = department;
    document.getElementById("net_salary").textContent = net_salary;
    document.getElementById("housing").textContent = housing + " $";
    document.getElementById("transport").textContent = transport + " $";
    document.getElementById("advance_salary").textContent =
      advance_salary + " $";
    document.getElementById("net_after_taxes").textContent =
      net_after_taxes + " $";
  });

  $(document).ready(function () {
    let basicSalary = sessionStorage.getItem("basicSalary");
    let totalTime = sessionStorage.getItem("totalTime");
    let country = sessionStorage.getItem("country");
    let name = sessionStorage.getItem("name");
    let address = sessionStorage.getItem("address");
    let phone = sessionStorage.getItem("phone");
    let created_at = sessionStorage.getItem("created_at");
    let year_to_date = sessionStorage.getItem("year_to_date");
    let payslip_code = sessionStorage.getItem("payslip_code");
    let payslip_code_ = payslip_code;
    let salary_month = sessionStorage.getItem("salary_month");
    let designation = sessionStorage.getItem("designation");
    let department = sessionStorage.getItem("department");
    let net_salary = sessionStorage.getItem("net_salary");
    let housing = sessionStorage.getItem("housing");
    let transport = sessionStorage.getItem("transport");
    let advance_salary = sessionStorage.getItem("advance_salary");
    let net_after_taxes = sessionStorage.getItem("net_after_taxes");

    // Sélectionner l'élément par son ID et changer son contenu Utiliser les données
    // récupérées comme vous le souhaitez
    document.getElementById("name").textContent = name;
    document.getElementById("address").textContent = address;
    document.getElementById("created_at").textContent = created_at;
    document.getElementById("phone").textContent = phone;
    document.getElementById("invoice_date_value").textContent = year_to_date;
    document.getElementById("payslip_code").textContent = payslip_code;
    document.getElementById("payslip_code_").textContent = payslip_code_;
    document.getElementById("salary_month").textContent = salary_month;
    document.getElementById("designation").textContent = designation;
    document.getElementById("department").textContent = department;
    document.getElementById("net_salary").textContent = net_salary;
    document.getElementById("housing").textContent = housing + " $";
    document.getElementById("transport").textContent = transport + " $";
    document.getElementById("advance_salary").textContent =
      advance_salary + " $";
    document.getElementById("net_after_taxes").textContent =
      net_after_taxes + " $";
  });

  // // voir facture du compte
  // $(document).on("click", ".view_button_comptes", function (e) {
  //   e.preventDefault();

  //   let id = $(this).data("id");
  //   let account_name = $(this).data("account_name");
  //   let creator_name = $(this).data("creator_name");
  //   let account_code = $(this).data("account_code");
  //   let account_value = $(this).data("account_value");
  //   let account_number = $(this).data("account_number");
  //   let bank_name = $(this).data("bank_name");
  //   let created_at = $(this).data("created_at");

  //   // Stocker les données dans le localStorage ou sessionStorage
  //   sessionStorage.setItem("id", id);
  //   sessionStorage.setItem("account_name", account_name);
  //   sessionStorage.setItem("creator_name", creator_name);
  //   sessionStorage.setItem("account_code", account_code);
  //   sessionStorage.setItem("account_value", account_value);
  //   sessionStorage.setItem("account_number", account_number);
  //   sessionStorage.setItem("bank_name", bank_name);
  //   sessionStorage.setItem("created_at", created_at);

  //   let url = `${baseUrl}company/invoice_account`;
  //   window.open(url, "_blank");
  // });

  // $(document).ready(function () {
  //   let account_id = sessionStorage.getItem("id");
  //   let account_name = sessionStorage.getItem("account_name");
  //   let account_name_2 = account_name;
  //   let creator_name = sessionStorage.getItem("creator_name");
  //   let account_number = sessionStorage.getItem("account_number");
  //   let bank_name = sessionStorage.getItem("bank_name");
  //   let created_at = sessionStorage.getItem("created_at");

  //   // Obtenez la date actuelle
  //   let today = new Date();
  //   // Obtenez la date au format "AAAA-MM-JJ" (par exemple, "2023-10-25")
  //   let todayDate = today.toISOString().split("T")[0];

  //   // Sélectionner l'élément par son ID et changer son contenu Utiliser les données
  //   // récupérées comme vous le souhaitez
  //   document.getElementById("account_name").textContent = account_name;
  //   document.getElementById("account_name_2").textContent = account_name_2;
  //   document.getElementById("creator_name").textContent = creator_name;
  //   document.getElementById("account_number").textContent = account_number;
  //   document.getElementById("bank_name").textContent = bank_name;
  //   document.getElementById("today_date").textContent = todayDate;
  //   document.getElementById("created_at").textContent = created_at;

  //   $.ajax({
  //     url: `${baseUrl}company/getAllAccountsByCreatorAndCompany_hack`,
  //     type: "POST",
  //     dataType: "JSON",
  //     data: {
  //       account_id,
  //     },
  //     success: function (res) {
  //       // Obtenez la table du corps du tableau
  //       var tableBody = $(".table tbody");

  //       // Réinitialisez les totaux
  //       var soldeInitial = 0;
  //       var depenses = 0;
  //       var depots = 0;

  //       // Parcourez les données renvoyées
  //       for (var i = 0; i < res.data.length; i++) {
  //         var transaction = res.data[i];

  //         // Créez une nouvelle ligne et ajoutez les données dans les cellules
  //         var row = $("<tr>");
  //         row.append($("<td>").text(transaction.reference));
  //         row.append($("<td>").text(transaction.transaction_date));
  //         row.append($("<td>").text(transaction.name));
  //         row.append($("<td>").text(transaction.transaction_type));
  //         row.append($("<td>").text(transaction.amount));

  //         // Ajoutez la ligne au corps du tableau
  //         tableBody.append(row);

  //         // Effectuez des calculs en fonction du type de transaction
  //         if (transaction.transaction_type === "depense") {
  //           depenses += parseFloat(transaction.amount);
  //         } else if (transaction.transaction_type === "depot") {
  //           depots += parseFloat(transaction.amount);
  //         }
  //       }

  //       // Récupérez le solde initial à partir de la première transaction
  //       if (res.data.length > 0) {
  //         soldeInitial = parseFloat(res.data[0].account_opening_balance);
  //       }

  //       var reste = soldeInitial - depenses + depots;

  //       $("#solde_initial").text(soldeInitial);
  //       $("#depenses").text(depenses);
  //       $("#depots").text(depots);
  //       $("#Reste").text(reste);
  //     },
  //   });
  // });

  // // voir facture depot et depense
  // $(document).on("click", ".voir_button_transaction-depexp", function (e) {
  //   e.preventDefault();

  //   let id = $(this).data("id");
  //   let transactions_amount = $(this).data("transactions_amount");
  //   let transactions_date = $(this).data("transactions_date");
  //   let transactions_method = $(this).data("transactions_method");
  //   let transactions_value = $(this).data("transactions_value");
  //   let transactions_code = $(this).data("transactions_code");
  //   let reference = $(this).data("reference");
  //   let staff_name = $(this).data("staff_name");
  //   let category_name = $(this).data("category_name");
  //   let account_name = $(this).data("account_name");
  //   let account_number = $(this).data("account_number");
  //   let created_at = $(this).data("created_at");

  //   // Stocker les données dans le localStorage ou sessionStorage
  //   sessionStorage.setItem("id", id);
  //   sessionStorage.setItem("transactions_amount", transactions_amount);
  //   sessionStorage.setItem("transactions_date", transactions_date);
  //   sessionStorage.setItem("transactions_method", transactions_method);
  //   sessionStorage.setItem("transactions_value", transactions_value);
  //   sessionStorage.setItem("transactions_code", transactions_code);
  //   sessionStorage.setItem("reference", reference);
  //   sessionStorage.setItem("account_name", account_name);
  //   sessionStorage.setItem("account_number", account_number);
  //   sessionStorage.setItem("staff_name", staff_name);
  //   sessionStorage.setItem("category_name", category_name);
  //   sessionStorage.setItem("created_at", created_at);

  //   let url = `${baseUrl}company/invoice_transaction?transaction=${transactions_value}?linked-solution?`;
  //   window.open(url, "_blank");
  // });

  // $(document).ready(function () {
  //   let transactions_amount = sessionStorage.getItem("transactions_amount");
  //   let transactions_amount_2 = transactions_amount;
  //   let transactions_date = sessionStorage.getItem("transactions_date");
  //   let transactions_method = sessionStorage.getItem("transactions_method");
  //   let reference = sessionStorage.getItem("reference");
  //   let account_name = sessionStorage.getItem("account_name");
  //   let account_name_2 = account_name;
  //   let account_number = sessionStorage.getItem("account_number");
  //   let staff_name = sessionStorage.getItem("staff_name");
  //   let category_name = sessionStorage.getItem("category_name");
  //   let created_at = sessionStorage.getItem("created_at");

  //   // Obtenez la date actuelle
  //   let today = new Date();
  //   // Obtenez la date au format "AAAA-MM-JJ" (par exemple, "2023-10-25")
  //   let todayDate = today.toISOString().split("T")[0];

  //   // Sélectionner l'élément par son ID et changer son contenu Utiliser les données
  //   // récupérées comme vous le souhaitez
  //   document.getElementById("transactions_date").textContent =
  //     transactions_date;
  //   document.getElementById("reference").textContent = reference;
  //   document.getElementById("account_name").textContent = account_name;
  //   document.getElementById("account_number").textContent = account_number;
  //   document.getElementById("account_name_2").textContent = account_name_2;
  //   document.getElementById("transactions_method").textContent =
  //     transactions_method;
  //   document.getElementById("category_name").textContent = category_name;
  //   document.getElementById("transactions_amount").textContent =
  //     transactions_amount + " $";
  //   document.getElementById("transactions_amount_2").textContent =
  //     transactions_amount_2 + " $";
  //   document.getElementById("staff_name").textContent = staff_name;
  //   document.getElementById("today_date").textContent = todayDate;
  //   document.getElementById("created_at").textContent = created_at;
  // });

  // voir facture avance sur salaire
  $(document).on("click", ".voir_button_advanced", function (e) {
    e.preventDefault();

    let id = $(this).data("id");
    let advance_amount = $(this).data("advance_amount");
    let month_year = $(this).data("month_year");
    let paiement_type = $(this).data("paiement_type");
    let description = $(this).data("description");
    let avance_reference = $(this).data("avance_reference");
    let avance_value = $(this).data("avance_value");
    let avance_code = $(this).data("avance_code");
    let salary_type = $(this).data("salary_type");
    let adresse_company = $(this).data("adresse_company");
    let company_name = $(this).data("company_name");
    let staff_name = $(this).data("staff_name");
    let created_at = $(this).data("created_at");

    // Stocker les données dans le localStorage ou sessionStorage
    sessionStorage.setItem("id", id);
    sessionStorage.setItem("advance_amount", advance_amount);
    sessionStorage.setItem("month_year", month_year);
    sessionStorage.setItem("paiement_type", paiement_type);
    sessionStorage.setItem("description", description);
    sessionStorage.setItem("avance_reference", avance_reference);
    sessionStorage.setItem("avance_value", avance_value);
    sessionStorage.setItem("avance_code", avance_code);
    sessionStorage.setItem("salary_type", salary_type);
    sessionStorage.setItem("adresse_company", adresse_company);
    sessionStorage.setItem("staff_name", staff_name);
    sessionStorage.setItem("company_name", company_name);
    sessionStorage.setItem("created_at", created_at);

    let url = `${baseUrl}company/invoice_avance?avance_value=${avance_value}?linked-solution?`;
    window.open(url, "_blank");
  });

  $(document).ready(function () {
    let advance_amount = sessionStorage.getItem("advance_amount");
    let month_year = sessionStorage.getItem("month_year");
    let paiement_type = sessionStorage.getItem("paiement_type");
    let description = sessionStorage.getItem("description");
    let avance_reference = sessionStorage.getItem("avance_reference");
    let avance_code = sessionStorage.getItem("avance_code");
    let salary_type = sessionStorage.getItem("salary_type");
    let staff_name = sessionStorage.getItem("staff_name");
    let adresse_company = sessionStorage.getItem("adresse_company");
    let company_name = sessionStorage.getItem("company_name");
    let created_at = sessionStorage.getItem("created_at");

    // Obtenez la date actuelle
    let today = new Date();
    // Obtenez la date au format "AAAA-MM-JJ" (par exemple, "2023-10-25")
    let todayDate = today.toISOString().split("T")[0];

    // Sélectionner l'élément par son ID et changer son contenu Utiliser les données
    // récupérées comme vous le souhaitez
    document.getElementById("advance_amount").textContent =
      advance_amount + " $";
    document.getElementById("month_year").textContent = month_year;
    document.getElementById("paiement_type").textContent = paiement_type;
    document.getElementById("avance_code").textContent = avance_code;
    document.getElementById("company_name").textContent = company_name;
    document.getElementById("staff_name").textContent = staff_name;
    document.getElementById("today_date").textContent = todayDate;
    document.getElementById("description").textContent = description;
    document.getElementById("avance_reference").textContent = avance_reference;
    document.getElementById("salary_type").textContent = salary_type;
    document.getElementById("adresse_company").textContent = adresse_company;
    document.getElementById("created_at").textContent = created_at;
  });

  // Mise a jour is_active(update)
  $(document).on(
    "click",
    ".activate_button_usercomp, .deactivate_button_usercomp",
    function (e) {
      e.preventDefault();

      let id = $(this).data("id");
      let status = $(this).data("status");

      // Vérification de l'ID
      if (isNaN(id) || (status !== 0 && status !== 1)) {
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Données non valides",
        });
        return;
      }

      // Construction de formData
      let formData = new FormData();
      formData.append("id", id);
      formData.append("status", status);

      // AJAX Request
      $.ajax({
        url: `${baseUrl}company/updateStatus`, // Assurez-vous que l'URL est correcte
        type: "POST",
        dataType: "JSON",
        processData: false,
        contentType: false,
        data: formData,
        success: function (res) {
          if (res.status === 200) {
            Swal.fire({
              icon: "success",
              title: "Mise à jour réussie",
              text: res.msg,
            });
            location.reload(); // Rechargez la page ou modifiez la vue en conséquence.
          } else {
            Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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
    }
  );

  // Finance Ajouter comptes
  $(document).on("submit", "#registerFormComptes", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let formData = new FormData(this); // 'this' fait référence au formulaire soumis

    $.ajax({
      url: `${baseUrl}company/handleAddComptes`, // Remplacez par l'URL appropriée de votre contrôleur
      type: "POST",
      dataType: "JSON",
      processData: false, // Important pour envoyer les données du formulaire avec FormData
      contentType: false, // Important pour envoyer les données du formulaire avec FormData
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // supprimer comptes
  $(document).on("click", ".delete-button-comptes", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $.ajax({
      url: `${baseUrl}company/handleDeleteComptes`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // Mise a jour comptes(update)
  $(document).on("submit", "#updateFormCompte", function (e) {
    e.preventDefault();
    let id = parseInt($(".account_id").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
      // Gérer l'erreur, par exemple afficher une alerte
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID utilisateur non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append(".account_id", id);

    $.ajax({
      url: `${baseUrl}company/updateComptes`,
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // update comptes(recuperation donnees)
  $(document).on("click", ".update_button_comptes", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("comptes-name");
    let number = $(this).data("comptes-number");
    let balance = $(this).data("comptes-balance");
    let bank_name = $(this).data("comptes-bank_name");
    $("#compteNameUpdate").val(name);
    $("#compteNumberUpdate").val(number);
    $("#compteBalanceUpdate").val(balance);
    $("#compteBankNameUpdate").val(bank_name);
    $(".account_id").val(id);
    $("#UpdateModalComptes").modal("show");
  });

  // timesheet Ajouter
  $(document).on("submit", "#registerFormTimesheet", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let formData = new FormData(this); // 'this' fait référence au formulaire soumis

    $.ajax({
      url: `${baseUrl}company/handleAddTimesheet`, // Remplacez par l'URL appropriée de votre contrôleur
      type: "POST",
      dataType: "JSON",
      processData: false, // Important pour envoyer les données du formulaire avec FormData
      contentType: false, // Important pour envoyer les données du formulaire avec FormData
      data: formData,
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // timesheet supprimer
  $(document).on("click", ".delete-button-deleterPresence", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteTimesheet`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete-button-timesheet", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterPresence").modal("show");
});

  // Mise a jour timesheet(update)
  $(document).on("submit", "#updateFormTimesheet", function (e) {
    e.preventDefault();
    let id = parseInt($(".timesheet_id").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
      // Gérer l'erreur, par exemple afficher une alerte
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID utilisateur non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append(".timesheet_id", id);

    $.ajax({
      url: `${baseUrl}company/updateTimesheet`,
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // update timesheet(recuperation donnees)
  $(document).on("click", ".update_button_timesheet", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let timesheet_date = $(this).data("timesheet_date");
    let timesheet_clockin = $(this).data("timesheet_clockin");
    let timesheet_clockout = $(this).data("timesheet_clockout");
    let timesheet_staffid = $(this).data("timesheet_staffid");
    $("#timesheet_date_update").val(timesheet_date);
    $("#clock_in_update").val(timesheet_clockin);
    $("#clock_out_update").val(timesheet_clockout);
    $("#staff_id_update").val(timesheet_staffid);
    $(".timesheet_id").val(id);
    $("#UpdateModalTimesheet").modal("show");
  });

  // Avance sur salaire ajout
  $(document).on("submit", "#registerFormAvanceSalaire", function (e) {
    // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();

    let advance_amount = $("#advance_amount").val();
    let month_year = $("#month_year").val();
    let parts = month_year.split("/");
    if (parts.length === 3) {
      month_year = parts[2] + "-" + parts[0] + "-" + parts[1];
    } else {
      parts = month_year.split("-");
      if (parts.length === 3) {
        let year = parts[0];
        let month = parts[1];
        let day = parts[2];
        month_year = year + "-" + month + "-" + day;
      }
    }
    let paiement_type = $("#paiement_methode").val();
    let staff_id = $("#staff_id").val();
    let avance_reference = $("#avance_reference").val();
    let description = $("#description").val();

    $.ajax({
      url: `${baseUrl}company/handleAddavanceSalaire`,
      method: "POST",
      dataType: "JSON",
      data: {
        advance_amount,
        month_year,
        paiement_type,
        staff_id,
        avance_reference,
        description,
      },
      success: function (res) {
        if (res.status === 200) {
          let timerInterval;
          Swal.fire({
            icon: "success",
            title: "Enregistrement réussi",
            text: res.msg,
            timer: 100, // Par exemple, disparaît après 2 secondes
            timerProgressBar: true,
            willOpen: () => {
              Swal.showLoading();
              timerInterval = setInterval(() => {
                const content = Swal.getContent();
                if (content) {
                  const b = content.querySelector("b");
                  if (b) {
                    b.textContent = Swal.getTimerLeft();
                  }
                }
              }, 100);
            },
            willClose: () => {
              clearInterval(timerInterval);
            },
          }).then((result) => {
            if (result.dismiss === Swal.DismissReason.timer) {
              console.log("Fermé par le timer");
              window.location.href = window.location.href;
            }
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
        Swal.fire({
          icon: "error",
          title: "Erreur",
          text: "Une erreur s'est produite. Veuillez réessayer plus tard.",
        });
      },
    });
  });

  // supprimer Avance sur salaire
  $(document).on("click", ".delete-button-avanceSalaire", function (e) {
    e.preventDefault();
    let id = parseInt($('.id_users').val());
    $.ajax({
      url: `${baseUrl}company/handleDeleteAvanceSalaire`, // Notez le changement d'URL ici
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
        } else {
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // Mise a jour Avance sur salaire(update)
  $(document).on("submit", "#updateFormAdvanceSalaire", function (e) {
    e.preventDefault();
    let id = parseInt($(".advanced_salary_id").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
      // Gérer l'erreur, par exemple afficher une alerte
      Swal.fire({
        icon: "error",
        title: "Erreur",
        text: "ID utilisateur non valide",
      });
      return;
    }

    let formData = new FormData(this);
    formData.append(".advanced_salary_id", id);

    $.ajax({
      url: `${baseUrl}company/updateAvanceSalaire`,
      type: "POST",
      dataType: "JSON",
      processData: false,
      contentType: false,
      data: formData,
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
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

  // update avance sur salaire (recuperation donnees)
  $(document).on("click", ".update_button_advanced", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let advance_amount = $(this).data("advance_amount");
    let month_year = $(this).data("month_year");
    let description = $(this).data("description");
    let avance_reference = $(this).data("avance_reference");
    console.log(avance_reference);
    let paiement_type = $(this).data("paiement_type");
    let staff_name = $(this).data("staff_name");
    $("#updatestaff_id").val(staff_name);
    $("#updateadvance_amount").val(advance_amount);
    $("#updatemonth_year").val(month_year);
    $("#updatepaiement_type").val(paiement_type);
    $("#updateavance_reference").val(avance_reference);
    $("#updatedescription").val(description);
    $(".advanced_salary_id").val(id);
    $("#UpdateModalAvanceSalaire").modal("show");
  });
});

// delete avance sur salaire(recuperation donnees)
$(document).on("click", ".delete_button_advanced", function (e) {
  e.preventDefault();
  let id = parseInt($(this).data("id"));
  $(".id_users").val(id);
  $("#deleterAvance").modal("show");
});