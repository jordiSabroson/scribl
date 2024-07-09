/*---------- UPDATE USER INFO ----------*/
function editProfile(id) {
    let email = document.getElementById("email").value;
    let name = document.getElementById("name").value;
    let surname = document.getElementById("surname").value;

    axios
        .put(`/editUser/${id}`, {
            name: name,
            surname: surname,
            email: email,
        })
        .then((response) => {
            console.log(response);
            if (response.status == 200) {
                Swal.fire({
                    title: "Usuario actualizado!",
                    text: response.data.message,
                    icon: "success",
                });
            } else {
                Swal.fire({
                    title: "Ha ocurrido un error :(",
                    text: response.data.message,
                    icon: "error",
                });
            }
        })
        .catch(function(error) {
            if (error.response.status === 422) {
                Swal.fire({
                    title: "Error!",
                    text: error.response.data.message,
                    icon: "error",
                });
                console.log("Error al editar el usuario: ", error);
            }
        });
}

/*---------- UPDATE USER PASSWORD ----------*/
function editPassword(id) {
    let old_password = document.getElementById("old_password").value;
    let new_password = document.getElementById("new_password").value;
    let new_password_confirmation = document.getElementById("new_password_confirmation").value;

    axios
        .put(`/editPassword/${id}`, {
            old_password: old_password,
            new_password: new_password,
            new_password_confirmation: new_password_confirmation,
        })
        .then((response) => {
            console.log(response);
            if (response.data.state == 422) {
                Swal.fire({
                    title: "Error!",
                    text: response.data.message,
                    icon: "error",
                });
            } else if (response.status == 200) {
                Swal.fire({
                    title: "Contraseña actualizada!",
                    text: response.data.message,
                    icon: "success",
                });
            }
        })
        .catch(function(error) {
            if (error.response.status === 422) {
                Swal.fire({
                    title: "Error!",
                    text: error.response.data.message,
                    icon: "error",
                });
            } else {
                console.log("Error cambiar la contraseña: ", error);
            }
        });
}

/*---------- CHANGE BETWEEN USER INFO AND PASSWORD PAGES ----------*/
function changePage(div) {
    let btnPassword = document.getElementById("btnPassword");
    let btnEditar = document.getElementById("btnEditar");

    document.getElementById("defaultDiv").innerHTML =
        document.getElementById(div).innerHTML;
    if (div == "userPassword") {
        btnPassword.classList.remove("btn-light");
        btnPassword.classList.add("btn-dark");

        btnEditar.classList.remove("btn-dark");
        btnEditar.classList.add("btn-light");
    } else {
        btnPassword.classList.add("btn-light");
        btnPassword.classList.remove("btn-dark");

        btnEditar.classList.add("btn-dark");
        btnEditar.classList.remove("btn-light");
    }
}

/*---------- SHOW HOMEPAGE ----------*/
function showHome() {
    axios.get("/home").then(function() { window.location = "/home"; }).catch(function(error) { console.log("Error al obtenir la vista: ", error); });
}