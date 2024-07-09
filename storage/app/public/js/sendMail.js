function sendRecover() {
    let email = document.getElementById("email").value;
    axios.post("/recover", {
            email: email
        })
        .then(response => {
            console.log(response);
            if (response.data.state == 200) {
                Swal.fire({
                    title: "Mail sent!",
                    text: response.data.message,
                    icon: "success",
                    timer: 2000,
                    timerProgressBar: true,
                });
                // setTimeout(function() {
                //     window.location = "/";
                // }, 2000);
            }

        })
        .catch(function(error) {
            console.log(error);
        });
}