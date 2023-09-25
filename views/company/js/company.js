$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    // Role | Role Ajout role
    $(document).on("click", "#btn_add_roles", function (e) {
        e.preventDefault();
        let name = $("#name").val();
        let userPermissions = [];
        let adminPermissions = [];
        let companyPermissions = [];
        let privilegePermissions = [];

        $("input[name='user[]']").each(function () {
            if ($(this).is(":checked")) {
                userPermissions.push($(this).val());
            }
        });

        $("input[name='admin[]']").each(function () {
            if ($(this).is(":checked")) {
                adminPermissions.push($(this).val());
            }
        });

        $("input[name='company[]']").each(function () {
            if ($(this).is(":checked")) {
                companyPermissions.push($(this).val());
            }
        });

        $("input[name='privilege[]']").each(function () {
            if ($(this).is(":checked")) {
                privilegePermissions.push($(this).val());
            }
        });

        $.ajax({
            url: `${baseUrl}company/handleAddRole`,
            type: "POST",
            dataType: "JSON",
            data: {
                name: name,
                user: userPermissions,
                admin: adminPermissions,
                company: companyPermissions,
                privilege: privilegePermissions
            },
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
                user: permissions.filter(permission => permission.startsWith("user")),
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
        $("#nomupdate").val(userrole_name);
        $(".id_role").val(id_role);

        $("input[type='checkbox']").prop("checked", false);

        let checkedPrivilegesString = $(this).data("checked-role");

        let checkedPrivilegesArray = checkedPrivilegesString.split(", ");

        checkedPrivilegesArray.forEach(function (privilege) {
            let checkboxId = "update_" + privilege
                .toLowerCase()
                .replace(/\s+/g, "_");

            $("#" + checkboxId).prop("checked", true);
        });

        $("#UpdateModalroles").modal("show");
    });

    // Suppression role
    $(document).on("click", ".delete-button-role", function (e) {
        e.preventDefault();
        let id_role = parseInt($(this).data("id"));
        $.ajax({
            url: `${baseUrl}company/handleDeleteRole`,
            type: "POST",
            dataType: "JSON",
            data: {
                id_role
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

    // Ajouter departements
$(document).on("submit", "#registerFormDepartements", function (e) { // ajusté pour cibler le formulaire, pas le bouton
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
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            const content = Swal.getContent();
                            if (content) {
                                const b = content.querySelector('b');
                                if (b) {
                                    b.textContent = Swal.getTimerLeft()
                                }
                            }
                        }, 100)
                    },
                    willClose: () => {
                        clearInterval(timerInterval)
                    }
                }).then((result) => {
                    if (result.dismiss === Swal.DismissReason.timer) {
                        console.log('Fermé par le timer')
                        window.location.href = window.location.href;
                    }
                })
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
$(document).on("click", ".delete-button-departement", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $.ajax({
        url: `${baseUrl}company/handleDeleteCompany`, // Notez le changement d'URL ici
        type: "POST",
        dataType: "JSON",
        data: {
            id
        },
        success: function (res) {
            if (res.status === 200) {
                window.location.reload();
                Swal.fire({icon: "success", title: "Suppression réussie", text: res.msg});
            } else {
                Swal.fire({icon: "error", title: "Erreur", text: res.msg});
            }
        },
        error: function () {
            Swal.fire({icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."});
        }
    });
});

// Mise a jour departements(update)
$(document).on("submit", "#updateFormDepartements", function (e) {
    e.preventDefault();
    let id = parseInt($(".id_departements").val()); // Récupère l'ID de l'utilisateur
if (isNaN(id)) {
    // Gérer l'erreur, par exemple afficher une alerte
    Swal.fire(
        {icon: "error", title: "Erreur", text: "ID utilisateur non valide"}
    );
    return;
}

    let formData = new FormData(this);
formData.append('.id_departements', id);

$.ajax({
url: `${baseUrl}company/updateDepartment`,
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

// update departement(recuperation donnees)
$(document).on("click", ".update_button_departement", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let name = $(this).data("departement-name");
    $("#departmentNameUpdate").val(name);
    $(".id_departements").val(id);
    $("#UpdateModalDepartements").modal("show");
});


    

});