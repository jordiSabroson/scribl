var ShowPasswordToggle = document.querySelector("[type='password']");
ShowPasswordToggle.onclick = function () {
    document.querySelector("[type='password']").classList.add("input-password");
    document.getElementById("toggle-password").classList.remove("d-none");

    const passwordInput = document.querySelector("[type='password']");
    const togglePasswordButton = document.getElementById("toggle-password");

    togglePasswordButton.addEventListener("click", togglePassword);
    function togglePassword() {
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            togglePasswordButton.classList.remove('bi-eye-slash');
            togglePasswordButton.classList.add('bi-eye');
        } else {
            passwordInput.type = "password";
            togglePasswordButton.classList.remove('bi-eye');
            togglePasswordButton.classList.add('bi-eye-slash');
        }
    }
};
