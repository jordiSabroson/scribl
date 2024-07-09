/*---------- SHOW ADD NOTE PAGE ----------*/
function showAddNote() {
    axios("/add_note").then(function() { window.location = "/add_note"; }).catch(error => { console.log("Error al obtenir la vista: ", error); });
}

/* Función que se invoca pulsando el botón de editar de la card de la página principal y muestra la vista para editar la nota */
function showEditNote(unique_id) {
    axios(`/edit_note/${unique_id}`).then(function() { window.location = `/edit_note/${unique_id}`; })
        .catch(function(error) {
            console.log("Error al obtenir la vista: ", error);
        });
}

/* Función que se invoca al clicar el botón de eliminar nota y recibe el id de la nota. Mediante el sweet alert se confirma si se quiere
   la nota y se llama al endpoint /delete_note/{id} y luego se recarga el div */
function deleteNote(id) {

    // Libreria Sweet Alert que muestra un alerta para confirmar si se quiere eliminar la nota
    Swal.fire({
        title: "Estás a punto de eliminar la nota",
        text: "Esta acción no es reversible!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "A tomar por culo",
    }).then((result) => {

        // Si se presiona el botón de confirmar, se hace la petición delete con el id de la nota
        if (result.isConfirmed) {
            axios
                .delete(`/delete_note/${id}`)
                .then(function(response) {

                    // Una vez hecha la petición, se imprime por consola la respuesta
                    console.log(response);

                    // Se almacena el mensaje que devuelve el controlador en una variable para mostrarlo en un alert
                    let message = response.data.message;

                    // Si la petición ha sido exitosa, se llama al endpoint que carga el div con las notas para no tener que recargar la página
                    if (response.status === 200) {
                        axios.get("/get_notes").then(function(response) {

                            // Se sustituye el div por la respuesta del endpoint
                            document.getElementById("notes-list").innerHTML =
                                response.data;

                            // Alert para mostrar el mensaje de que se ha borrado la nota
                            Swal.fire({
                                title: "Nota eliminada!",
                                text: message,
                                icon: "success",
                            });
                        });
                    }
                })
                .catch(function(error) {
                    console.log(error);
                });
        }
    });
}

/*---------- PIN NOTE ON TOP OF THE HOMEPAGE ----------*/
function pinNote(pin) {
    axios.post('/pin_note/' + pin.id)
        .then(function(response) {
            if (pin.ariaValueNow === "0") {
                pin.classList.remove("text-reset");
                pin.classList.add("btn", "btn-dark", "rounded-3");
                pin.style.backgroundColor = "#1C1B1F";
                pin.style.color = "#ffff";
                pin.ariaValueNow = "1";
                localStorage.setItem('pinned_' + pin.id, '1');
            } else if (pin.ariaValueNow === "1") {
                pin.classList.remove("btn", "btn-dark", "rounded-3");
                pin.classList.add("text-reset");
                pin.style.backgroundColor = "#EEEAE5";
                pin.ariaValueNow = "0";
                localStorage.setItem('pinned_' + pin.id, '0');
            }
            updateNotesList();
            //console.log(response.data.message);
        })
        .catch(function(error) {
            console.log(error);
        });
}

/*---------- UPDATE THE NOTES DIV WHEN A NOTE IS PINNED ----------*/
function updateNotesList() {
    axios("/get_notes").then(function(response) {
        document.getElementById("notes-list").innerHTML = response.data;

        // Dispara un evento "notesUpdated" en el contenedor de las notas
        document.getElementById("notes-list").dispatchEvent(new Event('notesUpdated'));
    });
}

/*---------- UPDATE THE BUTTON STYLE WHEN RELOADING THE PAGE AND SAVING IT INTO LOCAL STORAGE----------*/
function updateButtonStyle(button) {
    let pinned = localStorage.getItem('pinned_' + button.id);
    if (pinned === '1') {
        // Si el botón está fijado, aplicar el estilo correspondiente
        button.classList.remove("text-reset");
        button.classList.add("btn", "btn-dark", "rounded-3");
        button.style.backgroundColor = "#1C1B1F";
        button.style.color = "#ffff";
        button.ariaValueNow = "1";
    }
}

/*---------- FUNCTION INVOKED BY EVENTS WHO CALLS updateButtonStyle WHEN RELOADING THE PAGE ----------*/
function updateButtons() {
    document.querySelectorAll('[aria-valuenow]').forEach(function(button) {
        updateButtonStyle(button);
    });
}

/*---------- EVENT THAT TRIGGERS WHEN RELOADING THE PAGE ----------*/
document.addEventListener("DOMContentLoaded", updateButtons);

/*---------- EVENT THAT TRIGGERS WHEN A NOTE IS PINNED ----------*/
document.getElementById("notes-list").addEventListener("notesUpdated", updateButtons);


document.getElementById("search").addEventListener('input', searchBar);

function searchBar() {
    let user_input = document.getElementById("search").value;
    axios.post(`/search_note`, {
            user_input: user_input
        })
        .then(response => {
            // console.log(response)
            if (response.status === 200) {
                if (response.data.query == null) {
                    axios("/get_notes").then(response => {
                        document.getElementById("notes-list").innerHTML = response.data;
                        updateButtons()
                    })
                } else {
                    axios(`/get_filtered_notes/${response.data.query}`).then(response => {
                        console.log(response)
                        document.getElementById("notes-list").innerHTML = response.data;
                        updateButtons()
                    });
                }
            }
        })

    .catch(error => {
        console.log(error)
    })
}