function createAccount() {
    var fname = document.getElementById("signup-fistname").value;
    var lname = document.getElementById("signup-lastname").value;
    var email = document.getElementById("signup-email").value;
    var password = document.getElementById("signup-password").value;
    var pconfirm = document.getElementById("signup-password-confirm").value;
    var seller = document.getElementById("account_type_seller");
    var buyer = document.getElementById("account_type_buyer");
    var termsconditions = document.getElementById("terms_conditions");
    var serror = document.getElementById("singup-error-Message");
    serror.classList.remove("hidden");

    if (!fname || !lname || !email || !password || !pconfirm) {
        serror.innerHTML = "All fields are required";
    } else if (password.length < 8) {
        serror.innerHTML = "Password must contain at least 8 characters.";
    } else if (password != pconfirm) {
        serror.innerHTML = "Passwords do not match.";
    } else if (!seller.checked && !buyer.checked) {
        serror.innerHTML = "Please select Account type.";
    } else if (!termsconditions.checked) {
        serror.innerHTML = "Please read and check I agree to the Terms & Conditions.";
    } else {
        serror.classList.add("hidden");

        var form = new FormData();
        form.append("fname", fname);
        form.append("lname", lname);
        form.append("email", email);
        form.append("password", password);
        form.append("re_password", pconfirm);
        form.append("account_type", seller.checked ? seller.value : buyer.value);
        form.append("termsConditions", termsconditions.checked);


        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4) {

                serror.classList.remove("hidden");
                if (r.status == 200) {

                    if (r.responseText == "success") {
                        serror.classList.remove("text-red-500");
                        serror.classList.add("text-green-500");
                        serror.innerHTML = "Registion Successfull!";

                        setTimeout(() => {
                            window.location.reload();
                        }, 2000);
                    } else {
                        serror.innerHTML = r.responseText;
                    }
                } else {
                    serror.innerHTML = "Request failed !" + r.responseText;
                }
            }
        }
        r.open("POST", "process/createAccountProcess.php", true);
        r.send(form);

    }
}

function login() {
    var email = document.getElementById("signin-email").value;
    var password = document.getElementById("signin-password").value;
    var remembarMe = document.getElementById("rememberMe");
    var serror = document.getElementById("signin_error");
    serror.classList.remove("hidden");

    if (!email || !password) {
        serror.innerHTML = "All fields are required";
    } else if (!validateEmail(email)) {
        serror.innerHTML = "Invalid email format!";
    } else {
        serror.classList.add("hidden");

        var form = new FormData();
        form.append("email", email);
        form.append("password", password);
        form.append("remembarMe", remembarMe.checked ? "true" : "false");

        var r = new XMLHttpRequest();

        r.onreadystatechange = function () {
            if (r.readyState == 4) {

                serror.classList.remove("hidden");
                if (r.status == 200) {

                    if (r.responseText == "success") {
                        serror.classList.remove("text-red-500");
                        serror.classList.add("text-green-500");
                        serror.innerHTML = "Login Successfull!";

                        setTimeout(() => {
                            window.location = "home.php";
                        }, 2000);
                    } else {
                        serror.innerHTML = r.responseText;
                    }
                } else {
                    serror.innerHTML = "Request failed! :" + r.responseText;
                }
            }
        }
        r.open("POST", "process/loginProcess.php", true);
        r.send(form);
    }
}

function validateEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function forgotPassword() {
    var email = document.getElementById("forgot-email").value;
    var forgot_message = document.getElementById("forgot-message");
    forgot_message.classList.remove("hidden");
    var sendBtn = document.getElementById("forgot-password-send-code-btn");

    if (!email || !validateEmail(email)) {
        forgot_message.innerHTML = "Invalid email!";
    } else {

        var form = new FormData();
        form.append("email", email);

        forgot_message.innerHTML = "Sending .. <span class='inline-block animate-spin'>⏳</span>";
        sendBtn.disabled = true;
        sendBtn.style.opacity = "0.6";
        var r = new XMLHttpRequest();

        r.open("POST", "process/forgotPasswordProcess.php", true);
        r.onload = () => {
            sendBtn.disabled = false;
            sendBtn.style.opacity = "1";
            var response = r.responseText;
            forgot_message.classList.remove("hidden");
            forgot_message.className = (response == "success" ? "text-green-500" : "text-red-500");
            forgot_message.innerHTML = response == "success" ? "Code sent to your email!" : response;
            if (response == "success") setTimeout(() => {
                document.getElementById("forgot-step-1").classList.add("hidden");
                document.getElementById("forgot-step-2").classList.remove("hidden");
                document.getElementById("verify-message").classList.add("hidden");
            }, 1500);
        };
        r.onerror = () => {
            sendBtn.disabled = false;
            sendBtn.style.opacity = "1";
            forgot_message.classList.remove("hidden");
            forgot_message.className = "text-red-500 text-sm rounded-1g mb-2 p-2";
            forgot_message.innerHTML = "Network error. Please try again.";
        };
        r.send(form);
    }
}

// Verify Code
function verifyCode() {
    var code = document.getElementById("verify-code").value;
    var email = document.getElementById("forgot-email").value;
    var msg = document.getElementById("verify-message");
    var verifyBtn = document.querySelector("#forgot-step-2 button[onclick='verifyCode();']");

    msg.classList.remove("hidden");

    if (code.length !== 6 || !/^\d+$/.test(code)) {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
        msg.innerHTML = "Enter exactly 6 digits!";
    } else {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-blue-500";
        msg.innerHTML = "Verifying... <span class='inline-block animate-spin'>⏳</span>";
        verifyBtn.disabled = true;
        verifyBtn.style.opacity = "0.6";

        var form = new FormData();
        form.append("email", email);
        form.append("code", code);
        form.append("action", "verify");

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process/resetPasswordProcess.php", true);
        xhr.onload = () => {
            verifyBtn.disabled = false;
            verifyBtn.style.opacity = "1";
            var response = xhr.responseText.trim();
            msg.classList.remove("hidden");
            msg.className = "mb-4 p-3 rounded-lg text-sm " + (response == "success" ? "text-green-500" : "text-red-500");
            msg.innerHTML = response == "success" ? "✓ Code verified!" : response;
            if (response == "success") setTimeout(() => {
                document.getElementById("forgot-step-2").classList.add("hidden");
                document.getElementById("forgot-step-3").classList.remove("hidden");
                document.getElementById("reset-message").classList.add("hidden");
            }, 1500);
        };
        xhr.onerror = () => {
            verifyBtn.disabled = false;
            verifyBtn.style.opacity = "1";
            msg.classList.remove("hidden");
            msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
            msg.innerHTML = "Network error. Please try again.";
        };
        xhr.send(form);
    }
}

// Reset Password
function resetPassword() {
    var pwd = document.getElementById("reset-password").value;
    var confirm = document.getElementById("reset-password-confirm").value;
    var email = document.getElementById("forgot-email").value;
    var msg = document.getElementById("reset-message");
    var resetBtn = document.querySelector("#forgot-step-3 button[onclick='resetPassword();']");

    msg.classList.remove("hidden");

    if (!pwd || !confirm) {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
        msg.innerHTML = "All fields required!";
    } else if (pwd.length < 8) {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
        msg.innerHTML = "Password must be 8+ characters!";
    } else if (pwd !== confirm) {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
        msg.innerHTML = "Passwords don't match!";
    } else {
        msg.className = "mb-4 p-3 rounded-lg text-sm text-blue-500";
        msg.innerHTML = "Resetting... <span class='inline-block animate-spin'>⏳</span>";
        resetBtn.disabled = true;
        resetBtn.style.opacity = "0.6";

        var form = new FormData();

        form.append("email", email);
        form.append("password", pwd);
        form.append("cpassword", confirm);
        form.append("action", "reset");

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "process/resetPasswordProcess.php", true);
        xhr.onload = () => {
            resetBtn.disabled = false;
            resetBtn.style.opacity = "1";
            var response = xhr.responseText.trim();
            msg.classList.remove("hidden");
            msg.className = "mb-4 p-3 rounded-lg text-sm " + (response == "success" ? "text-green-500" : "text-red-500");
            msg.innerHTML = response == "success" ? "✓ Password reset successfully!" : response;
            if (response == "success") setTimeout(() => {
                closeForgotPasswordModal();
                document.getElementById("reset-password").value = "";
                document.getElementById("reset-password-confirm").value = "";
            }, 2000);
        };
        xhr.onerror = () => {
            resetBtn.disabled = false;
            resetBtn.style.opacity = "1";
            msg.classList.remove("hidden");
            msg.className = "mb-4 p-3 rounded-lg text-sm text-red-500";
            msg.innerHTML = "Network error. Please try again.";
        };
        xhr.send(form);
    }
}



function Fogetpassword() {
    document.getElementById("forgot-password-modal").classList.remove("hidden");
    document.getElementById("forgot-step-1").classList.remove("hidden");
    document.getElementById("forgot-step-2").classList.add("hidden");
    document.getElementById("forgot-step-3").classList.add("hidden");
    document.getElementById("forgot-email").focus();
}

function closeForgotPasswordModal() {
    document.getElementById("forgot-password-modal").classList.add("hidden");

    document.getElementById("forgot-email").value = "";
    document.getElementById("verify-code").value = "";
    document.getElementById("reset-password").value = "";
    document.getElementById("reset-password-confirm").value = "";

    document.getElementById("forgot-message").classList.add("hidden");
    document.getElementById("verify-message").classList.add("hidden");
    document.getElementById("reset-message").classList.add("hidden");

}
function backToEmail() {
    document.getElementById("forgot-step-2").classList.add("hidden");
    document.getElementById("forgot-step-1").classList.remove("hidden");
    document.getElementById("verify-code").value = "";
    document.getElementById("verify-message").classList.add("hidden");
    document.getElementById("forgot-message").classList.add("hidden");
}