$(document).ready(function () {
  const baseUrl = "http://paiement.mr:81/";

  // Role
  // Role Ajout role
  $(document).on("click", "#btn_add_roles", function (e) {
    e.preventDefault();
    let name = $("#nom").val();
    let adminPermissions = [];
    let companyPermissions = [];
    let privilegePermissions = [];

    // Parcourez toutes les cases à cocher avec le nom 'admin[]'
    $("input[name='admin[]']").each(function () {
      // Vérifiez si la case à cocher est cochée
      if ($(this).is(":checked")) {
        adminPermissions.push($(this).val()); // Ajoutez la valeur au tableau des permissions d'admin
      }
    });

    // Parcourez toutes les cases à cocher avec le nom 'company[]'
    $("input[name='company[]']").each(function () {
      // Vérifiez si la case à cocher est cochée
      if ($(this).is(":checked")) {
        companyPermissions.push($(this).val()); // Ajoutez la valeur au tableau des permissions de la compagnie
      }
    });

    $("input[name='privilege[]']").each(function () {
      // Vérifiez si la case à cocher est cochée
      if ($(this).is(":checked")) {
        privilegePermissions.push($(this).val()); // Ajoutez la valeur au tableau des permissions de la compagnie
      }
    });

    $.ajax({
      url: `${baseUrl}superadmin/handleAddRole`,
      type: "POST",
      dataType: "JSON",
      data: {
        nom: name,
        admin: adminPermissions, // Ajoutez le tableau des permissions d'admin
        company: companyPermissions,
        privilege: privilegePermissions,
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



  // voir role (recuperation des donnees)
  $(document).on("click", ".view_button_role", function (e) {
    e.preventDefault();
    let id_role = parseInt($(this).data("id"));
    let name = $(this).data("view-name");
    $("#viewnom").val(name);
    $(".id_role").val(id_role);
    $("#viewModalroles").modal("show");
  });

  // Suppression role
  $(document).on("click", ".delete-button-role", function (e) {
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

  // utilisateurs suppression utilisateurs
  $(document).on("click", ".delete-button-users", function (e) {
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
          Swal.fire({ icon: "error", title: "Erreur", text: res.msg });
        }
      },
    });
  });

  // Ajouter utilisateurs
  $(document).on("submit", "#registerFormUser", function (e) {
    e.preventDefault();
    let name = $("#name").val();
    let username = $("#username").val();
    let email = $("#email").val();
    let phone = $("#phone").val();
    let address = $("#address").val();
    let password = $("#password").val();
    let confirm_password = $("#confirm_password").val();
    let image = $("#imageFile").val();

    $.ajax({
      url: `${baseUrl}superadmin/handleRegisterUsers`,
      type: "POST",
      dataType: "JSON",
      data: {
        name,
        username,
        email,
        phone,
        address,
        password,
        confirm_password,
        image,
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
          text: "Une erreur s'est produite. Veuillez réessayer plus tardd.",
        });
      },
    });
  });

  // Mise a jour utilisateur(update)
  $(document).on("submit", "#updateFormUser", function (e) {
    e.preventDefault();
    let nameupdate = $("#nameupdate").val();
    let usernameupdate = $("#usernameupdate").val();
    let emailupdate = $("#emailupdate").val();
    let phoneupdate = $("#phoneupdate").val();
    let addressupdate = $("#addressupdate").val();
    let birthdayupdate = $("#birthdayupdate").val();
    let parts = birthdayupdate.split("/");
    if (parts.length === 3) {
      birthdayupdate = parts[2] + "-" + parts[1] + "-" + parts[0];
    }
    let part = birthdayupdate.split("-");
    if (parts.length === 3) {
      let year = part[0];
      let day = part[1];
      let month = part[2];

      birthdayupdate = year + "-" + month + "-" + day;
    }
    let id = parseInt($(".id_users").val());

    $.ajax({
      url: `${baseUrl}superadmin/updateUsers`,
      type: "POST",
      dataType: "JSON",
      data: {
        id,
        nameupdate,
        usernameupdate,
        emailupdate,
        phoneupdate,
        addressupdate,
        birthdayupdate,
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

  // update utilisateur(recuperation donnees)
  $(document).on("click", ".update_button_profile", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("userprofile-name");
    let username = $(this).data("userprofile-username");
    let email = $(this).data("userprofile-email");
    let phone = $(this).data("userprofile-phone");
    let address = $(this).data("userprofile-address");
    let birthday = $(this).data("userprofile-birthday");
    $("#nameupdate").val(name);
    $("#usernameupdate").val(username);
    $("#emailupdate").val(email);
    $("#phoneupdate").val(phone);
    $("#addressupdate").val(address);
    $("#birthdayupdate").val(birthday);
    $(".id_users").val(id);
    $("#UpdateModalProfile").modal("show");
  });

  // voir utilisateur(recuperation donnees)
  $(document).on("click", ".voir_button_profile", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("view-name");
    let username = $(this).data("view-username");
    let email = $(this).data("view-email");
    let phone = $(this).data("view-phone");
    let address = $(this).data("view-address");
    let birthday = $(this).data("view-birthday");
    $("#viewname").val(name);
    $("#viewusername").val(username);
    $("#viewemail").val(email);
    $("#viewphone").val(phone);
    $("#viewaddress").val(address);
    $("#viewbirthday").val(birthday);
    $(".id_users").val(id);
    $("#viewModalProfile").modal("show");
  });

  // Company Company suppression company
  $(document).on("click", ".delete-button-company", function (e) {
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

  // Mise a jour company(update)
  $(document).on("submit", "#updateFormCompany", function (e) {
    e.preventDefault();
    let nameupdate = $("#nameupdate").val();
    let emailupdate = $("#emailupdate").val();
    let phoneupdate = $("#phoneupdate").val();
    let addressupdate = $("#addressupdate").val();
    let id = parseInt($(".id_company").val());

    $.ajax({
      url: `${baseUrl}superadmin/updateCompany`,
      type: "POST",
      dataType: "JSON",
      data: {
        id,
        nameupdate,
        emailupdate,
        phoneupdate,
        addressupdate,
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

  // update company(recuperation donnees)
  $(document).on("click", ".update_button_company", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("companyname");
    let email = $(this).data("companyemail");
    let phone = $(this).data("companyphone");
    let address = $(this).data("companyaddress");
    $("#nameupdate").val(name);
    $("#emailupdate").val(email);
    $("#phoneupdate").val(phone);
    $("#addressupdate").val(address);
    $(".id_company").val(id);
    $("#updateModalCompany").modal("show");
  });

  // Ajouter company
  $(document).on("submit", "#registerFormCompany", function (e) {
    e.preventDefault();

    let name = $("#name").val();
    let address = $("#address").val();
    let email = $("#email").val();
    let phone = $("#phone").val();
    let country_id = $("#country").val();
    let category_id = $("#category").val();

    $.ajax({
      url: `${baseUrl}superadmin/handleInsertCompany`,
      type: "POST",
      dataType: "JSON",
      data: {
        name: name,
        address: address,
        email: email,
        phone: phone,
        country_id: country_id,
        category_id: category_id,
        action: "jddiuanjkanciuwenfas,mcn;sdiojd",
      },
      success: function (res) {
        if (res.status === 200) {
          window.location.reload();
          $("#registerFormCompany")[0].reset();
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
});
