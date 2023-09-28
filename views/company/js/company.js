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
        url: `${baseUrl}company/handleDeleteDepartement`, // Notez le changement d'URL ici
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


// Designations
// ajouter
$(document).on("submit", "#registerFormDesignation", function (e) { // ajusté pour cibler le formulaire, pas le bouton
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
$(document).on("click", ".delete-button-designation", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $.ajax({
        url: `${baseUrl}company/handleDeleteDesignation`, // Notez le changement d'URL ici
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

// Mise à jour désignations(update)
$(document).on("submit", "#updateFormDesignation", function (e) {
    e.preventDefault();
    let id = parseInt($(".id_designation").val());
    if (isNaN(id)) {
        Swal.fire({icon: "error", title: "Erreur", text: "ID de la désignation non valide"});
        return;
    }
    
    let formData = new FormData(this);
    formData.append('designation_id', id);
    
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
                Swal.fire({icon: "success", title: "Mise à jour réussie", text: res.msg});
            } else {
                Swal.fire({icon: "error", title: "Erreur", text: res.msg});
            }
        },
        error: function () {
            Swal.fire({icon: "error", title: "Erreur", text: "Une erreur s'est produite. Veuillez réessayer plus tard."});
        }
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

$(document).ready(function() {
    $('select[name="department_id"]').on('change', function() { // Ajusté ici
        var departmentId = $(this).val();
        
        if (departmentId) {
            $.ajax({
                url: `${baseUrl}company/handleAjaxRequest`, 
                type: 'POST',
                data: {departmentId: departmentId},
                dataType: 'json',
                success: function(data) {
                    var designationSelect = $('select[name="designation_id"]');
                    designationSelect.empty();
                    designationSelect.append('<option value="" disabled selected>Designations</option>');
                    
                    $.each(data, function(key, value) {
                        designationSelect.append('<option value="' + value.designation_id + '">' + value.designation_name + '</option>');
                    });
                    
                    designationSelect.prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown); // Log pour débugger
                }
            });
        }
    });
});


// Horaire
// Ajouter
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
                        window.location.href = window.location.href; // Recharge la page, vous pouvez aussi rediriger vers une autre page si vous préférez.
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
$(document).on("click", ".delete-button-horaire", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $.ajax({
        url: `${baseUrl}company/handleDeleteHoraire`, // Notez le changement d'URL ici
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

// calcul asynchrone des heures
$(document).ready(function() {

    // La fonction de mise à jour pour total_hours
    function updateTotalHours() {
      let totalHours = 0;
  
      ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'].forEach(day => {
        let inTime = $(`#${day}_in`).val(); // heure d'entrée
        let outTime = $(`#${day}_out`).val(); // heure de sortie
  
        if (inTime && outTime) {
          let inMoment = moment(inTime, 'hh:mm A');
          let outMoment = moment(outTime, 'hh:mm A');
  
          let hoursWorked = outMoment.diff(inMoment, 'hours', true); // true pour obtenir un nombre décimal
          totalHours += hoursWorked;
        }
      });
  
      $('#total_hours').val(Math.round(totalHours));
    }
  
    // La fonction de mise à jour pour total_days
    function updateTotalDaysAndHours() {
      let totalHours = 0;
  
      ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'].forEach(day => {
        let inTime = $(`#${day}_in`).val();
        let outTime = $(`#${day}_out`).val();
  
        if (inTime && outTime) {
          let inMoment = moment(inTime, 'hh:mm A');
          let outMoment = moment(outTime, 'hh:mm A');
  
          let hoursWorked = outMoment.diff(inMoment, 'hours', true);
          totalHours += hoursWorked;
        }
      });
  
      let totalDays = Math.floor(totalHours / 8);
      let remainingHours = totalHours % 8;
      $('#total_days').val(`${totalDays} jours ${remainingHours.toFixed(2)} heures`);
    }
  
    // Attacher l'événement de mise à jour à chaque input
    $('.time-picker').on('change blur', function() {
      updateTotalHours();
      updateTotalDaysAndHours(); // Appeler les deux fonctions indépendamment à chaque modification ou perte de focus de l'input
    });
  
});

//   mise a jour complet
  $(document).ready(function() {

    function updateTotalHours() {
        let totalHours = 0;
        ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'].forEach(day => {
            let inTime = $(`#update${day}_in`).val(); // heure d'entrée
            let outTime = $(`#update${day}_out`).val(); // heure de sortie

            if (inTime && outTime) {
                let inMoment = moment(inTime, 'hh:mm A'); // Note: 'hh:mm A' est pour 12 heures, 'HH:mm' est pour 24 heures.
                let outMoment = moment(outTime, 'hh:mm A');

                let hoursWorked = outMoment.diff(inMoment, 'hours', true);
                totalHours += hoursWorked;
            }
        });

        $('#updatetotal_hours').val(Math.round(totalHours));
    }

    $('.time-picker').on('blur', function() {
        updateTotalHours();
    });

    $(document).on("submit", "#updateFormTime", function(e) {
        e.preventDefault();
        updateTotalHours(); // Mettre à jour les total_hours lors de la soumission
        
        let formData = new FormData(this);
        formData.append('id', $('.id_horaire').val()); 
        $.ajax({
            url: `${baseUrl}company/updateHoraire`,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(data) {
                console.log('Success:', data);
                if(data.status === 200) {
                    location.reload(); // Recharger la page si la mise à jour est réussie
                } else {
                    alert(data.msg); // Vous pouvez aussi montrer un message d'erreur à l'utilisateur
                }
            },
            error: function(error) {
                console.error('Error:', error);
            }
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

// Users
// utilisateur | utilisateurs suppression utilisateurs
$(document).on("click", ".delete-button-usercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    $.ajax({
        url: `${baseUrl}company/handleDeleteUserscomp`,
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
$(document).on("submit", "#updateFormUsercomp", function (e) {
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
url: `${baseUrl}company/updateUsers`,
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
    let image = $(this).data("image");
    $("#updatename").val(name);
    $("#updateusername").val(username);
    $("#updateemail").val(email);
    $("#updatephone").val(phone);
    $("#updateaddress").val(address);
    $("#updatebirthday").val(birthday);
    $("#updatestatus_marital").val(marital_status);
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
    $("#updateimage").val(image);
    $(".id_users").val(id);
    $("#UpdateModalUsercomp").modal("show");
});

// Paye
$(document).on("click", ".paye_button_usercomp", function (e) {
    e.preventDefault();
    let id = parseInt($(this).data("id"));
    let bs = parseFloat($(this).data("basic_salary"));
    let hours_time = Number($(this).data("total_time"));
    let regularization = Number($(this).data("regularization"))
    let other = Number($(this).data("other"))
    let leave = Number($(this).data("leave"))
    let monthlastone = Number($(this).data("monthlastone"))
    let advanced_salary = Number($(this).data("advanced_salary"))
    let children = Number($(this).data("children"))
    let spouse = Number($(this).data("spouse"))
    let telephone = Number($(this).data("telephone"))
    let country = $(this).data("country")
    
    $("#basic_salary").val(bs);
    $("#hours_time").val(hours_time);
    $("#country").val(country);
    console.log(country)
    $(".id_users").val(id);
    $("#payeModalUsercomp").modal("show");
    
    // Afficher la valeur dans le badge
    $("#hours_time_badge").text(`${hours_time} heures/semaine`);

    // Calculez le nombre de jours et le reste des heures
    let total_hours_month = parseInt(hours_time * 4);
    let jours = Number(Math.floor(total_hours_month / 8)); // 8 heures par jour
    let heures = parseInt(total_hours_month % 8); // Le reste des heures
    
    if(isNaN(regularization)) regularization = 0;
    $("#regularization").text(`${regularization} / Regularization`);
    if(isNaN(other)) other = 0;
    $("#other").text(`${other} / Other`);
    if(isNaN(leave)) leave = 0;
    $("#leave").text(`${leave} / Leave`);
    if(isNaN(monthlastone)) monthlastone = 0;
    $("#monthlastone").text(`${monthlastone} / 13th Month`);
    if(isNaN(advanced_salary)) advanced_salary = 0;
    $("#advanced_salary").text(`${advanced_salary} / Advanced Salary`);
    if(isNaN(children)) children = 0;
    $("#children").text(`${children} / Enfants`);
    if(isNaN(spouse)) spouse = 0;
    $("#spouse").text(`${spouse} / Epouse`);
    if(isNaN(telephone)) telephone = 0;
    $("#telephone").text(`${telephone} / Telephone`);
    
    $("#jours").text(jours + " jours " + heures + " heures" + "/ mois");
    let salary_imposable = bs + regularization + other + leave + monthlastone;
    // Le reste de votre code ici, et utilisez salary_imposable comme vous le souhaitez.
    $("#salary_imposable").text(salary_imposable + " $");
    
    let cnss_company = salary_imposable * 13 / 100;
    $("#cnss_company").text(cnss_company + " $");

    let iere;
    if (country.toLowerCase() === "republique democratique du congo") {
        iere = 0;
    } else {
        iere = salary_imposable * 25 / 100;
    }
    $("#iere").text(iere + " $");

    let inpp = salary_imposable * 3 / 100;
    $("#inpp").text(inpp + " $");
    
    let onem = salary_imposable * 0.2 / 100;
    $("#onem").text(onem + " $");

    let cnss = (salary_imposable * 5) / 100;
    if(isNaN(cnss)) cnss = 0;
    // Afficher la valeur de cnss dans le DOM, si vous avez un élément HTML approprié pour cela
    $("#cnss").text(cnss + " $");

    let net_before_taxes = salary_imposable - cnss;
    if(isNaN(net_before_taxes)) net_before_taxes = 0;
    // Afficher la valeur de net_before_taxes dans le DOM, si vous avez un élément HTML approprié pour cela
    $("#net_before_taxes").text(net_before_taxes + " $");

    // Calcul important en fond
    let usdFranc;
    let exchange_rate = 2300;
    let net_before_taxes_franc = net_before_taxes * 2300

if(net_before_taxes_franc > 0 && net_before_taxes_franc < 162001) {
    usdFranc = 4860;
} else if(net_before_taxes_franc > 162000 && net_before_taxes_franc < 1800001) {
    let intermediate = 4860 + ((net_before_taxes_franc - 162000) * 0.15);
    usdFranc = intermediate - intermediate * ((spouse + children) * 2 / 100);
} else if(net_before_taxes_franc > 1800000 && net_before_taxes_franc < 3600001) {
    let intermediate = 250560 + ((net_before_taxes_franc - 1800000) * 0.30);
    usdFranc = intermediate - intermediate * ((spouse + children) * 2 / 100);
} else if(net_before_taxes_franc > 3600000 && net_before_taxes_franc < 100000000000) {
    let intermediate = 790560 + ((net_before_taxes_franc - 3600000) * 0.40);
    usdFranc = intermediate - intermediate * ((spouse + children) * 2 / 100);
} else {
    usdFranc = net_before_taxes_franc * 0.30;
}

let convertUsdFc = usdFranc / exchange_rate;
$("#convertUsdFc").text(convertUsdFc.toFixed(2));

// Fin du calcul important en fond

let ipr_franc;

if (usdFranc < 2000) {
    ipr_franc = 2000;
} else if (usdFranc > (net_before_taxes_franc * 0.3)) {
    ipr_franc = net_before_taxes_franc * 0.3;
} else {
    ipr_franc = usdFranc;
}
    ipr = ipr_franc / exchange_rate
$("#ipr").text(ipr.toFixed(2) + " $");


let net_after_taxes = net_before_taxes - ipr; 
$("#net_after_taxes").text(net_after_taxes.toFixed(2) + " $");


    
    let housing = (bs + regularization + leave)*30/100;
    if(isNaN(housing)) housing = 0;
    // Afficher la valeur de net_before_taxes dans le DOM, si vous avez un élément HTML approprié pour cela
    $("#housing").text(housing + " $");

    // Calcul du salaire de base new
    $('#absent_days').on('input', function() {
        let absent_days = Number($(this).val()); // convertir la valeur en number, si la conversion échoue, ça devient NaN
        
        if(isNaN(absent_days) || absent_days < 0) absent_days = 0; // si la conversion échoue ou la valeur est négative, définir la valeur à 0
        
        if(absent_days >= jours) {
            $("#final_salary").text('0 $');
            $("#transport").text('0 $');
        } else {
            let jours_travailles = Number(jours - Number(absent_days));
            let Transport = 0.545454545454545 * 4 * jours_travailles;
            let salaire_final = (bs / jours) * jours_travailles;
            $("#final_salary").text(salaire_final.toFixed(2) + " $");
            $("#transport").text(Transport.toFixed(2) + " $");

            let salary_net = net_after_taxes + housing + Transport + telephone - advanced_salary
            $("#salary_net").text(salary_net.toFixed(2) + " $");

            let salary_brut_company = salary_net + cnss + cnss_company + ipr + iere + inpp + onem;
            $("#salary_brut_company").text(salary_brut_company.toFixed(2) + " $");
        }

        
    }); 
});


// Ajouter payements
$(document).on("submit", "#payeFormUsercomp", function (e) { // ajusté pour cibler le formulaire, pas le bouton
    e.preventDefault();
    
    let formData = new FormData(this); // 'this' fait référence au formulaire soumis
    
    $.ajax({
        url: `${baseUrl}company/handleAddPayements`, // Remplacez par l'URL appropriée de votre contrôleur
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


// selection departement pour afficher sa branche
$(document).ready(function() {
    $('select[name="updatedepartment_id"]').on('change', function() { // Ajusté ici
        var departmentId = $(this).val();
        
        if (departmentId) {
            $.ajax({
                url: `${baseUrl}company/handleAjaxRequest`, 
                type: 'POST',
                data: {departmentId: departmentId},
                dataType: 'json',
                success: function(data) {
                    var designationSelect = $('select[name="updatedesignation_id"]');
                    designationSelect.empty();
                    designationSelect.append('<option value="" disabled selected>Designations</option>');
                    
                    $.each(data, function(key, value) {
                        designationSelect.append('<option value="' + value.designation_id + '">' + value.designation_name + '</option>');
                    });
                    
                    designationSelect.prop('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('AJAX Error:', textStatus, errorThrown); // Log pour débugger
                }
            });
        }
    });
});
  
});