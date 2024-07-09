function showRegister() {
    axios("/register").then(response => { window.location.href = "/register" }).catch(error => { console.log(error) });
}

function showLogin() {
    axios("/").then(response => { window.location.href = "/" }).catch(error => { console.log(error) });
}

function login() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;

    axios.post("/login", {
            email: email,
            password: password,
        })
        .then((response) => {
            console.log(response)
            if (response.data.state === 422) {
                Swal.fire({
                    title: "Error!",
                    text: response.data.message,
                    icon: "error",
                });
            } else if (response.data.state === 200) {
                window.location.href = "/home";
            }
        })
        .catch((error) => {
            console.log(error);
            Swal.fire({
                title: "Error!",
                text: error.response.data.message,
                icon: "error",
            });
        });
}

function register() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let name = document.getElementById("name").value;
    let surname = document.getElementById("surname").value;
    if (!verifyTerms()) { return; }
    axios.post("/register", {
            email: email,
            password: password,
            name: name,
            surname: surname
        })
        .then(response => {
            console.log(response)
            axios.get("/").then(function(response) {
                Swal.fire({
                    title: "User created!",
                    text: response.data.message,
                    icon: "success",
                    timer: 1500,
                    timerProgressBar: true
                });
                setTimeout(function() {
                    window.location.href = "/";
                }, 1500);
            });
        })
        .catch(error => {
            console.log(error);
            Swal.fire({
                title: "Error!",
                text: error.response.data.message,
                icon: "error",
            });
        })
}

function verifyTerms() {
    let btn = document.getElementById("terms");

    if (!btn.checked) {
        Swal.fire({
            title: "Error!",
            text: "You need to accept the terms and conditions",
            icon: "error",
        });
        return false;
    }
    return true;
}

function politica() {
    alert("politica de parke")
}