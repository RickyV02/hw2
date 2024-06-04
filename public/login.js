function toggleVisibility() {
  const it = document.querySelector(".pwd");
  if (it.type === "password") {
    it.type = "text";
    show_pwd.src = hide;
  } else {
    it.type = "password";
    show_pwd.src = show;
  }
}

function check_username() {
  const error_msg = document.getElementById("nouser");
  if (form.username.value.length == 0) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  }
}

function check_password() {
  const error_msg = document.getElementById("nopwd");
  if (form.password.value.length == 0) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  }
}

function check_credentials(event) {
  if (!checkSubmit) {
    event.preventDefault();
  }
}

let checkSubmit = false;
const hide = "assets/eye_slash_visible_hide_hidden_show_icon_145987.svg";
const show = "assets/eye_visible_hide_hidden_show_icon_145988.svg";
const show_pwd = document.querySelector(".show-password");
show_pwd.addEventListener("click", toggleVisibility);
const form = document.forms["login"];
form.username.addEventListener("blur", check_username);
form.password.addEventListener("blur", check_password);
form.addEventListener("submit", check_credentials);
