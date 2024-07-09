/*---------- ADD NOTE TO DATABASE ----------*/
function addNote() {
    let title = document.getElementById("title").value;
    let note = document.getElementById("note").value;
    axios
        .post("/add_note", {
            title: title,
            note: note,
        })
        .then((response) => {
            console.log(response);
            Swal.fire({
                title: "Note saved!",
                text: response.data.message,
                icon: "success",
                timer: 1500,
                timerProgressBar: true,
            });
            setTimeout(function() {
                window.location = "/edit_note/" + response.data.unique_id;
            }, 1500);
        }).then()
        .catch(function(error) {
            console.log("Error al guardar la nota: ", error);
            Swal.fire({
                title: "Error!",
                text: error.response.data.message,
                icon: "error",
            });
        });
}

/* Función que se invoca desde la vista 'edit-note' al pulsar el botón de guardar. La función recibe el id de la nota y la actualiza */
function editNote(unique_id) {
    let title = document.getElementById("title").value;
    let note = document.getElementById("note").value;
    axios
        .put(`/edit_note/${unique_id}`, {
            title: title,
            note: note,
        })
        .then((response) => {
            console.log(response);
            if (response.status == 200) {
                Swal.fire({
                    title: "Nota actualizada!",
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
            console.log("Error al guardar la nota: ", error);
            Swal.fire({
                title: "Error!",
                text: error.response.data.message,
                icon: "error",
            });
        });
}

/*---------- DELETE IMAGE FROM DATABASE ----------*/
function deleteImage(id, note_id) {
    Swal.fire({
        title: "Estás a punto de eliminar la imagen",
        text: "Esta acción no es reversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Borrar",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(`/delete_image/${id}`)
                .then(function(response) {
                    console.log(response);
                    if (response.status === 200) {
                        axios.get(`/get_images/${note_id}`).then(function(response) {
                            Swal.fire({
                                title: "Image deleted!",
                                text: response.data.message,
                                icon: "success",
                                timer: 1000,
                                timerProgressBar: true
                            });
                            setTimeout(function() {
                                document.getElementById("div-imatges").innerHTML = '';
                                document.getElementById("div-imatges").innerHTML = response.data;
                            }, 1000);
                        });
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    });
}

/*---------- FUNCIÓN PARA HACER QUE SE PUEDAN SUBIR ARCHIVOS A TRAVÉS DE UN BOTÓN QUE LLAMA A UN INPUT="FILE" ----------*/
function inputImage() {
    document.getElementById("uploadFile").click();
}

/*---------- FUNCIÓN QUE NO PERMITE SUBIR IMÁGENES SI LA NOTA NO ESTA GUARDADA ----------*/
function noUploadImage() {
    Swal.fire({
        title: "Error!",
        text: "You need to save your note to upload a image",
        icon: "error",
    });
}

/*---------- FUNCIÓN PARA SUBIR IMÁGENES A BASE DE DATOS ----------*/
function uploadImage(id) {
    let inputFile = document.getElementById("uploadFile");
    let file = inputFile.files[0];
    let data = new FormData();
    data.append('document', file);

    axios.post(`/upload_image/${id}`, data, {
        headers: {
            'accept': 'application/json',
            'Accept-Language': 'en-US,en;q=0.8',
            'Content-Type': `multipart/form-data; boundary=${data._boundary}`,
        }
    }).then((response) => {
        console.log(response)
        if (response.data.state == 400) {
            Swal.fire({
                title: "Error!",
                text: response.data.message,
                icon: "error",
            });
        } else if (response.status === 200) {
            axios.get(`/get_images/${id}`).then(function(response) {
                Swal.fire({
                    title: "Image added!",
                    text: response.data.message,
                    icon: "success",
                    timer: 1000,
                    timerProgressBar: true
                });
                setTimeout(function() {
                    document.getElementById("div-imatges").innerHTML = '';
                    document.getElementById("div-imatges").innerHTML = response.data;
                }, 1000);
            });
        }
    }).catch((error => {
        console.log(error)
        Swal.fire({
            title: "Error!",
            text: error.response.data.message,
            icon: "error",
        });
    }));
}

/*---------- FUNCIÓN QUE NO PERMITE CREAR UN RECORDATORIO SI LA NOTA NO ESTÁ GUARDADA ----------*/
function noReminder() {
    Swal.fire({
        title: "Error!",
        text: "You need to save your note to set a reminder",
        icon: "error",
    });
}

/*---------- ? ----------*/
async function reminder(id) {
    const { value: date } = await Swal.fire({
        title: "¿Quieres añadir un recordatorio?",
        text: "Añade el dia que desees y te enviaremos un recordatorio por mail.",
        input: "date",
        customClass: "reminder",
        didOpen: () => {
            const today = (new Date()).toISOString();
            Swal.getInput().min = today.split("T")[0];
        }
    });
    if (date) {
        axios.post(`/reminder/${id}`, {
                date: date,
            })
            .then(response => {
                if (response.data.state == 400) {
                    Swal.fire({
                        title: "Error!",
                        text: response.data.message,
                        icon: "error",
                    });
                } else if (response.status === 200) {
                    Swal.fire({
                        title: "Your reminder is set",
                        text: response.data.message,
                        icon: "success",
                    });
                }
            })
            .catch(error => {
                console.log(error)
                Swal.fire({
                    title: "Error!",
                    text: error.response.data.message,
                    icon: "error",
                });
            });
    }
}

// Función para que al presionar el tabulador al escribir una nota se tabule correctamente y no se cambie el foco de atención
document.getElementById("note").onkeydown = function(e) {
    if (e.key === "Tab") {
        e.preventDefault();

        // selectionStart y selectionEnd son propiedades de los forms HTML e indican la posición del cursor dentro del elemento
        let start = this.selectionStart;
        let end = this.selectionEnd;

        this.value =
            this.value.substring(0, start) + "\t" + this.value.substring(end);

        this.selectionStart = this.selectionEnd = start + 1;
        return false;
    }
};

/*---------- SHOW HOMEPAGE ----------*/
function showHome() {
    axios.get("/home").then(function() { window.location = "/home"; }).catch(function(error) { console.log("Error al obtenir la vista: ", error); });
}