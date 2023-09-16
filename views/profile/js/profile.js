$(document).ready(function () {
    const baseUrl = "http://paiement.mr:81/";

    $(document).on("submit", "#Updateinfo", function (e) {
        e.preventDefault();
        let userId = $("#userId").val();
        let name = $("#newName").val();
        let username = $("#newUsername").val();
        let phone = $("#newPhone").val();
        let birthday = $("#newBirthday").val();
        let parts = birthday.split('/');
        if (parts.length === 3) {
            birthday = parts[2] + '-' + parts[1] + '-' + parts[0];
        }
        let part = birthday.split('-');
        if (parts.length === 3) {
            let year = part[0];
            let day = part[1];
            let month = part[2];

            birthday = year + '-' + month + '-' + day;
        }
        $.ajax({
            url: `${baseUrl}profile/handleUpdateProfile`,
            method: "POST",
            dataType: "JSON",
            data: {
                userId,
                name,
                username,
                phone,
                birthday
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

    $(document).on("click", "#update_profile", function (e) {
        e.preventDefault();
        let id = parseInt($(this).data("id"));
        let name = $(this).data("nameprofile")
        let username = $(this).data("usernameprofile")
        let phone = $(this).data("phoneprofile")
        let birthday = $(this).data("birthdayprofile")
        $("#newName").val(name);
        $("#newUsername").val(username);
        $("#newPhone").val(phone);
        $("#newBirthday").val(birthday);
        $(".id").val(id);
        $("#profile_edit").modal("show")
    });
});