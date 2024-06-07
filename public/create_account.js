function toggleVisibility() {
    const pwdInputs = document.querySelectorAll(".pwd");
    for (item of pwdInputs) {
        if (item.type === "password") {
            item.type = "text";
            for (item of show_pwd) {
                item.src = hide;
            }
        } else {
            item.type = "password";
            for (item of show_pwd) {
                item.src = show;
            }
        }
    }
}

function validatePassword(password) {
    const maiuscRegex = /[A-Z]/;
    if (!maiuscRegex.test(password)) {
        return false;
    }

    const spCharsRegex = /[!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?]/;
    if (!spCharsRegex.test(password)) {
        return false;
    }

    return true;
}

function validateEmail(email) {
    const emailRegex = /^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/;
    if (emailRegex.test(email)) return true;
    else return false;
}

function onResponse(response) {
    if (!response.ok) return null;
    else return response.json();
}

function onJsonEmail(json) {
    const error_msg = document.getElementById("em2");
    if (json.exists) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
    }
}

function onJsonUsername(json) {
    const error_msg = document.getElementById("user");
    if (json.exists) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
    }
}

function check_email() {
    const error_msg = document.getElementById("em");
    if (!validateEmail(form.email.value)) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        fetch(
            "signup/check/email?q=" +
                encodeURIComponent(String(form.email.value).toLowerCase())
        )
            .then(onResponse)
            .then(onJsonEmail);
    }
}

function check_username() {
    const error_msg = document.getElementById("nouser");
    if (form.username.value.length < 4 || form.username.value.length > 16) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
        fetch(
            "signup/check/username?q=" + encodeURIComponent(form.username.value)
        )
            .then(onResponse)
            .then(onJsonUsername);
    }
}

function check_password() {
    const error_msg = document.getElementById("pwd");
    if (!validatePassword(form.password.value)) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
    }
}

function check_minlength() {
    const error_msg = document.getElementById("minlength");
    if (form.password.value.length < 8) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
    }
}

function check_match() {
    const error_msg = document.getElementById("pwdmatch");
    if (form.password.value !== form.rpassword.value) {
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        checkSub = false;
    } else {
        error_msg.classList.remove("errormsg");
        error_msg.classList.add("nascosto");
        checkSub = true;
    }
}

function check_credentials(event) {
    if (!form.terms.checked) {
        const error_msg = document.getElementById("noterms");
        error_msg.classList.remove("nascosto");
        error_msg.classList.add("errormsg");
        event.preventDefault();
    } else if (!checkSub) {
        event.preventDefault();
    }
}

function activateClick() {
    fileInput.click();
}

function hideFileErrors() {
    const error_msg1 = document.getElementById("nosize");
    error_msg1.classList.remove("errormsg");
    error_msg1.classList.add("nascosto");
    const error_msg2 = document.getElementById("noext");
    error_msg2.classList.remove("errormsg");
    error_msg2.classList.add("nascosto");
}

function checkFile() {
    const fileUpload = fileInput.files[0];
    if (fileUpload) {
        const maxSize = 5 * 1024 * 1024;
        if (fileUpload.size >= maxSize) {
            const error_msg = document.getElementById("nosize");
            error_msg.classList.remove("nascosto");
            error_msg.classList.add("errormsg");
            checkSub = false;
            return;
        }
        const allowedExtensions = [".jpg", ".jpeg", ".png", ".gif"];
        const fileName = fileUpload.name.toLowerCase();
        let validExtension = false;
        for (item of allowedExtensions) {
            if (fileName.endsWith(item)) {
                validExtension = true;
                break;
            }
        }
        if (!validExtension) {
            const error_msg = document.getElementById("noext");
            error_msg.classList.remove("nascosto");
            error_msg.classList.add("errormsg");
            checkSub = false;
            return;
        }
        hideFileErrors();
        checkSub = true;
    }
}

let checkSub = false;
const hide = "assets/eye_slash_visible_hide_hidden_show_icon_145987.svg";
const show = "assets/eye_visible_hide_hidden_show_icon_145988.svg";
const show_pwd = document.querySelectorAll(".show-password");
for (item of show_pwd) {
    item.addEventListener("click", toggleVisibility);
}
const form = document.forms["login"];
form.username.addEventListener("blur", check_username);
form.password.addEventListener("blur", check_password);
form.password.addEventListener("blur", check_minlength);
form.email.addEventListener("blur", check_email);
form.rpassword.addEventListener("blur", check_match);
form.addEventListener("submit", check_credentials);
const fileLabel = document.getElementById("avatar");
fileLabel.addEventListener("click", activateClick);
const fileInput = document.getElementById("file");
fileInput.addEventListener("change", checkFile);
