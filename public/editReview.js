function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function checkRating() {
  const error_msg = document.getElementById("maxrat");
  if (
    !form.rating.value ||
    isNaN(form.rating.value) ||
    form.rating.value < 0 ||
    form.rating.value > 10
  ) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  }
}

function checkReview() {
  const error_msg = document.getElementById("norev");
  if (reviewContent.value.length < 1 || reviewContent.value.length > 255) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  }
}

function onJsonShowRedirect(json) {
  const formTitle = document.querySelector(".review-form h1");
  if (json.ok) {
    formTitle.textContent = "Edit Saved!";
    form.classList.add("nascosto");
    const profileLink = document.createElement("a");
    profileLink.href = "profile.php?q=" + encodeURIComponent(username);
    profileLink.textContent = "See Your Review At Your Profile";
    const formDiv = document.querySelector(".review-form");
    formDiv.appendChild(profileLink);
  }
}

function editReview() {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("review", reviewContent.value);
  formData.append("rating", form.rating.value);
  fetch("saveEditReview.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonShowRedirect);
}

function onJsonShowOldReview(json) {
  if (json.ok) {
    const item = json.content;
    const h1 = document.querySelector("header h1");
    if (item.hasOwnProperty("GAME_NAME")) {
      h1.textContent += item.GAME_NAME;
    } else {
      h1.textContent += item.FILM_NAME;
    }
    document.getElementById("cover").src = item.COVER;
    reviewContent.textContent = item.RECENSIONE;
    form.rating.value = item.VOTO;
  }
}

function check_credentials(event) {
  event.preventDefault();
  if (checkSubmit) {
    editReview();
  }
}

function getOldReviewInfo() {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("content", "");
  fetch("getReview.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonShowOldReview);
}

let checkSubmit = true;
const form = document.querySelector("form");
form.rating.addEventListener("blur", checkRating);
const reviewContent = document.getElementById("review");
reviewContent.addEventListener("blur", checkReview);
form.addEventListener("submit", check_credentials);
const id = document.querySelector(".review-form").dataset.id;
const username= document.querySelector(".review-form").dataset.username;

getOldReviewInfo();
