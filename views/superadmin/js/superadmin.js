$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    // utilisateur | utilisateurs suppression utilisateurs
    $(document).on("click", ".delete-button-users", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        $.ajax({
            url: `${baseUrl}superadmin/handleDeleteUsers`,
            type: "POST",
            dataType: "JSON",
            data: {
                id
            },
            success: function (res) {
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    Swal.fire({icon: "success", title: "Suppression réussie", text: res.msg});
                } else if (res.status === 500) {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de la suppression", text: res.msg}
                    );
                } else {
                    Swal.fire({icon: "error", title: "Erreur", text: res.msg});
                }
            }
        });
    });


    // 
    $(document).on("click", ".active_desactive", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        let $this = $(this); // Ne pas oublier de définir $this
        
        $.ajax({
            url: `${baseUrl}superadmin/toggleUserActiveStatus`,
            type: "POST",
            dataType: "JSON",
            data: { id: id },
            success: function (res) {
                if (res.success) {
                    let newText = res.newIsActive ? 'Désactiver' : 'Activer';
                    $this.find('span').text(newText);
                    window.location.reload(); // recharger la page après la mise à jour du texte du bouton.
                } else {
                    alert(res.message); // afficher le message d'erreur
                }
            },
            error: function () {
                alert('Une erreur s’est produite lors de la requête.'); // afficher un message en cas d'échec de la requête
            }
        });
    });

    
    // Ajouter utilisateurs
    $(document).on("submit", "#registerFormUser", function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: `${baseUrl}superadmin/handleRegisterUsers`,
            type: "POST",
            dataType: "JSON",
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    Swal.fire({icon: "success", title: "Enregistrement réussi", text: res.msg});
                } else {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de l'enregistrement", text: res.msg}
                    );
                }
            },
            error: function () {
                Swal.fire(
                    {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
                );
            }
        });
    });

    
    // Mise a jour utilisateur(update)
    $(document).on("submit", "#updateFormUser", function (e) {
        e.preventDefault();
        let id = parseInt($(".id_users").val()); // Récupère l'ID de l'utilisateur
    if (isNaN(id)) {
        // Gérer l'erreur, par exemple afficher une alerte
        Swal.fire(
            {icon: "error", title: "Erreur", text: "ID utilisateur non valide"}
        );
        return;
    }

        let formData = new FormData(this);
formData.append('.id', id);

$.ajax({
    url: `${baseUrl}superadmin/updateUsers`,
    type: "POST",
    dataType: "JSON",
    processData: false,
    contentType: false,
    data: formData,
            success: function (res) {
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    Swal.fire({icon: "success", title: "Mise à jour réussie", text: res.msg});
                } else if (res.status === 409) {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de la mise à jour", text: res.msg}
                    );
                } else {
                    Swal.fire({icon: "error", title: "Erreur", text: res.msg});
                }
            },
            error: function () {
                Swal.fire(
                    {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
                );
            }
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
    let imageUrl = $(this).data("view-image");

    $("#viewimage").attr("src", imageUrl);
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

    // Company | Company suppression company
    $(document).on("click", ".delete-button-company", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        $.ajax({
            url: `${baseUrl}superadmin/handleDeleteCompany`,
            type: "POST",
            dataType: "JSON",
            data: {
                id
            },
            success: function (res) {
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    Swal.fire({icon: "success", title: "Suppression réussie", text: res.msg});
                } else if (res.status === 500) {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de la suppression", text: res.msg}
                    );
                } else {
                    Swal.fire({icon: "error", title: "Erreur", text: res.msg});
                }
            },
            error: function () {
                Swal.fire({
                    icon: "error",
                    title: "Erreur",
                    text: "Une erreur s'est produite lors de la suppression. Veuillez réessayer plus tard" +
                            "."
                });
            }
        });
    });

    // Mise a jour company(update)
    $(document).on("submit", "#updateFormCompany", function (e) {
        e.preventDefault();
        let id = parseInt($(".id_company").val());
    if (isNaN(id)) {
        // Gérer l'erreur, par exemple afficher une alerte
        Swal.fire(
            {icon: "error", title: "Erreur", text: "ID utilisateur non valide"}
        );
        return;
    }

        let formData = new FormData(this);
formData.append('.id', id);

        $.ajax({
            url: `${baseUrl}superadmin/updateCompany`,
            type: "POST",
            dataType: "JSON",
    processData: false,
    contentType: false,
    data: formData,
            success: function (res) {
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    Swal.fire({icon: "success", title: "Mise à jour réussie", text: res.msg});
                } else if (res.status === 409) {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de la mise à jour", text: res.msg}
                    );
                } else {
                    Swal.fire({icon: "error", title: "Erreur", text: res.msg});
                }
            },
            error: function () {
                Swal.fire(
                    {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
                );
            }
        });
    });

    // modalAddCompany
    $(document).on("click", "#addCompany", function (e){
        $("#addModalCompany").modal("show");
    });

    // update company(recuperation donnees)
    $(document).on("click", ".update_button_company", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        let name = $(this).data("company-name");
        let uniqueid = $(this).data("company-uniqueid");
        let email = $(this).data("company-email");
        let username = $(this).data("company-username");
        let phone = $(this).data("company-phone");
        let address = $(this).data("company-address");
        let city = $(this).data("company-city");
        $("#nameupdate").val(name);
        $("#uniqueidupdate").val(uniqueid);
        $("#emailupdate").val(email);
        $("#usernameupdate").val(username);
        $("#phoneupdate").val(phone);
        $("#addressupdate").val(address);
        $("#updatecity").val(city);
        $(".id_company").val(id);
        $("#UpdateModalCompany").modal("show");
    });

    // voir company(recuperation donnees)
    $(document).on("click", ".view_button_company", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        let name = $(this).data("view-name");
        let uniqueid = $(this).data("view-uniqueid");
        let email = $(this).data("view-email");
        let username = $(this).data("view-username");
        let phone = $(this).data("view-phone");
        let address = $(this).data("view-address");
        let companycharge = $(this).data("view-companycharge");
        $("#nameview").val(name);
        $("#uniqueidview").val(uniqueid);
        $("#emailview").val(email);
        $("#usernameview").val(username);
        $("#phoneview").val(phone);
        $("#addressview").val(address);
        $("#companycharge").val(companycharge);
        $(".id_company").val(id);
        $("#viewModalCompany").modal("show");
    });

    // Ajouter company
    $(document).on("submit", "#registerFormCompany", function (e) {
        e.preventDefault();

        let name = $("#name").val();
        let username = $("#username").val();
        let address = $("#address").val();
        let email = $("#email").val();
        let phone = $("#phone").val();
        let country_id = $("#country").val();
        let company_charge = $("#company").val();
        let category_id = $("#category").val();
        let city = $("#city").val();
        let province = $("#province").val();
        let code_postale = $("#code_postale").val();
        let tax_number = $("#tax_number").val();
        let rccm = $("#rccm").val();
        let bank_name = $("#bank_name").val();
        let bank_number = $("#bank_number").val();
        let password = $("#password").val();
        let confirm_password = $("#confirm_password").val();

        $.ajax({
            url: `${baseUrl}superadmin/handleInsertCompany`,
            type: "POST",
            dataType: "JSON",
            data: {
                name: name,
                username: username,
                address: address,
                email: email,
                phone: phone,
                country_id: country_id,
                city: city,
                province: province,
                code_postale: code_postale,
                tax_number: tax_number,
                rccm: rccm,
                bank_name: bank_name,
                bank_number: bank_number,
                company_charge: company_charge,
                category_id: category_id,
                password: password,
                confirm_password: confirm_password,
                action: "jddiuanjkanciuwenfas,mcn;sdiojd"
            },
            success: function (res) {
              if (!name || !username || !address || !email || !phone || !country_id || !city || !province || !code_postale || !tax_number || !rccm || !bank_name || !bank_number || !category_id || !password || !confirm_password) {
                Swal.fire({icon: "error", title: "Erreur", text: "Tous les champs sont obligatoires"});
                return;
            }
                if (res.status === 200) {
                    window
                        .location
                        .reload();
                    $("#registerFormCompany")[0].reset();
                    Swal.fire({icon: "success", title: "Enregistrement réussi", text: res.msg});
                } else {
                    Swal.fire(
                        {icon: "error", title: "Erreur lors de l'enregistrement", text: res.msg}
                    );
                }
            },
            error: function () {
                Swal.fire(
                    {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
                );
            }
        });
    });

    // Role
  // Role Ajout role
  $(document).on("click", "#btn_add_roles", function (e) {
    e.preventDefault();
    
    let name = $("#name").val();
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
        name: name,
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

  // update roles
  $(document).on("submit", "#UpdatePrivilegeForm", function (e) {
    e.preventDefault();
    let newName = $("#nameupdate").val();
    let id_role = parseInt($(".id_role").val());
    let permissions = [];
    $("input[type='checkbox']:checked").each(function () {
        permissions.push($(this).attr("id").replace("update_", ""));
    });

    $.ajax({
        url: `${baseUrl}superadmin/updateRole`,
        type: "POST",
        dataType: "JSON",
        data: {
            id_role,
            newName,
            admin: permissions.filter(permission => permission.startsWith("admin")),
            company: permissions.filter(permission => permission.startsWith("company")),
            privilege: permissions.filter(permission => permission.startsWith("privilege"))
        },
        success: function (res) {
            if (res.status === 200) {
                window
                    .location
                    .reload();
                Swal.fire({icon: "success", title: "Mise à jour réussie", text: res.msg});
            } else if (res.status === 409) {
                Swal.fire(
                    {icon: "error", title: "Erreur lors de la mise à jour", text: res.msg}
                );
            } else {
                Swal.fire({icon: "error", title: "Erreur", text: res.msg});
            }
        },
        error: function () {
            Swal.fire(
                {icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."}
            );
        }
    });
});

  // Update role(recuperation des donnees)
$(document).on("click", ".update_button_role", function (e) {
  e.preventDefault();
  let id_role = parseInt($(this).data("id"));
  let userrole_name = $(this).data("userrole-name");
  $("#nameupdate").val(userrole_name);
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

    $('#category').change(function() {
        var selectedValue = $(this).val(); // Obtenez la valeur sélectionnée
        
        if (selectedValue == '5') { // Si la valeur est 5, activez le menu déroulant des compagnies
            $('#company').prop('disabled', false); 
        } else { // Sinon, désactivez le menu déroulant des compagnies
            $('#company').prop('disabled', true);
        }
    });

    // Mise a jour is_active(update)
$(document).on("click", ".activate_button_usercomp, .deactivate_button_usercomp", function (e) {
    e.preventDefault();
    
    let id = $(this).data('id');
    let status = $(this).data('status');
    
    // Vérification de l'ID
    if (isNaN(id) || (status !== 0 && status !== 1)) {
        Swal.fire({icon: "error", title: "Erreur", text: "Données non valides"});
        return;
    }
    
    // Construction de formData
    let formData = new FormData();
    formData.append('id', id);
    formData.append('status', status);
    
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
                Swal.fire({icon: "success", title: "Mise à jour réussie", text: res.msg});
                location.reload(); // Rechargez la page ou modifiez la vue en conséquence.
            } else {
                Swal.fire({icon: "error", title: "Erreur", text: res.msg});
            }
        },
        error: function () {
            Swal.fire({icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."});
        }
    });
});

});
