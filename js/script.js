function sUp() {
    var signup = document.getElementById("signup-form");
    var signin = document.getElementById("signin-form");

    signin.classList.toggle("hidden");
    signup.classList.toggle("hidden");
}

// Toggle Between Password & Text in Password Inputs
function togglePassword(inputId, btn) {
    var input = document.getElementById(inputId);
    if (input.type == "password") {
        input.type = "text";
        btn.innerHTML = "🙈";
    } else {
        input.type = "password";
        btn.innerHTML = "👀";
    }
}

