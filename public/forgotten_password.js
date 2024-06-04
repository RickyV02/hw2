function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function validateEmail(email) {
  const emailRegex = /^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/;
  if (emailRegex.test(email)) return true;
  else return false;
}

function check_email() {
  const error_msg = document.getElementById("em");
  if (!validateEmail(form.email.value)) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    fetch("checkEmail.php?email=" + encodeURIComponent(form.email.value))
      .then(onResponse)
      .then(onJsonEmail);
  }
}

function onJsonEmail(json) {
  const error_msg = document.getElementById("em2");
  if (json.exists) {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  } else {
    error_msg.classList.add("errormsg");
    error_msg.classList.remove("nascosto");
    checkSubmit = false;
  }
}

function onJsonEmailSent(json) {
  document.getElementById("status").textContent = json.status;
}

function hideErrors() {
  const errors = document.querySelectorAll(".errormsg");
  for (item of errors) {
    item.classList.remove("errormsg");
    item.classList.add("nascosto");
  }
}

function sendMail() {
  hideErrors();
  checkSubmit = false;
  const formData = new FormData();
  formData.append("email", form.email.value);
  fetch("sendMail.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonEmailSent);
}

function checkSub(event) {
  event.preventDefault();
  if (checkSubmit) sendMail();
}

let checkSubmit = false;
const form = document.forms["login"];
form.email.addEventListener("blur", check_email);
form.addEventListener("submit", checkSub);
