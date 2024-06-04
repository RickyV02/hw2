function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function toggleVisibility() {
  const it = document.getElementById("pwd_input");
  const show_pwd = document.querySelector(".show-password");
  if (it.type === "password") {
    it.type = "text";
    show_pwd.src = hide;
  } else {
    it.type = "password";
    show_pwd.src = show;
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

function onJsonEmail(json) {
  const error_msg = document.getElementById("em2");
  if (json.exists) {
    error_msg.classList.remove("nascosto");
    error_msg.classList.add("errormsg");
    checkSubmit = false;
  } else {
    error_msg.classList.remove("errormsg");
    error_msg.classList.add("nascosto");
    checkSubmit = true;
  }
}

function check_email() {
  if (form.email.value !== "") {
    const error_msg = document.getElementById("em");
    if (!validateEmail(form.email.value)) {
      error_msg.classList.remove("nascosto");
      error_msg.classList.add("errormsg");
      checkSubmit = false;
    } else {
      error_msg.classList.remove("errormsg");
      error_msg.classList.add("nascosto");
      fetch(
        "checkEmail.php?email=" +
          encodeURIComponent(String(form.email.value).toLowerCase())
      )
        .then(onResponse)
        .then(onJsonEmail);
    }
  } else {
    hideAll();
  }
}

function check_password() {
  if (form.password.value !== "") {
    const error_msg = document.getElementById("pwd");
    if (!validatePassword(form.password.value)) {
      error_msg.classList.remove("nascosto");
      error_msg.classList.add("errormsg");
      checkSubmit = false;
    } else {
      error_msg.classList.remove("errormsg");
      error_msg.classList.add("nascosto");
      checkSubmit = true;
    }
  } else {
    hideAll();
  }
}

function check_minlength() {
  if (form.password.value !== "") {
    const error_msg = document.getElementById("minlength");
    if (form.password.value.length < 8) {
      error_msg.classList.remove("nascosto");
      error_msg.classList.add("errormsg");
      checkSubmit = false;
    } else {
      error_msg.classList.remove("errormsg");
      error_msg.classList.add("nascosto");
      checkSubmit = true;
    }
  } else {
    hideAll();
  }
}

function hideAll() {
  const errors1 = document.querySelectorAll(".errormsg");
  for (item of errors1) {
    item.classList.remove("errormsg");
    item.classList.add("nascosto");
  }
  const errors2 = document.querySelectorAll(".mainerror");
  for (item of errors2) {
    item.classList.remove("mainerror");
    item.classList.add("nascosto");
  }
  const errors3 = document.querySelectorAll(".updatemsg");
  for (item of errors3) {
    item.classList.remove("updatemsg");
    item.classList.add("nascosto");
  }
}

function onJsonChangeSettings(json) {
  const statusDiv = document.getElementById("updateResponse");
  hideAll();
  form.email.value = "";
  form.password.value = "";
  fileInput.value = "";
  if (json.UpdateLog) {
    if (json.UpdateLog.email) {
      const p = document.createElement("p");
      p.classList.add("updatemsg");
      p.textContent = json.UpdateLog.email;
      statusDiv.appendChild(p);
    }
    if (json.UpdateLog.password) {
      const p = document.createElement("p");
      p.classList.add("updatemsg");
      p.textContent = json.UpdateLog.password;
      statusDiv.appendChild(p);
    }
    if (json.UpdateLog.avatar) {
      const p = document.createElement("p");
      p.classList.add("updatemsg");
      p.textContent = json.UpdateLog.avatar;
      statusDiv.appendChild(p);
      fetchAvatar();
    }
  }
  if (json.UpdateError) {
    const array = json.UpdateError;
    for (let i = 0; i < array.length; i++) {
      const p = document.createElement("p");
      p.classList.add("mainerror");
      p.textContent = array[i];
      statusDiv.appendChild(p);
    }
  }
  toggleSettings();
}

function check_credentials(event) {
  event.preventDefault();
  if (checkSubmit) {
    checkSubmit = false;
    const formData = new FormData();
    if (form.email.value) {
      formData.append("email", form.email.value);
    }
    if (form.password.value) {
      formData.append("password", form.password.value);
    }
    if (fileInput.files[0]) {
      const fileUpload = fileInput.files[0];
      formData.append("file", fileUpload);
    }
    fetch("changeSettings.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonChangeSettings);
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
      checkSubmit = false;
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
      checkSubmit = false;
      return;
    }
    hideFileErrors();
    checkSubmit = true;
  }
}

function onJsonAvatar(json) {
  if (!json.nouser) {
    const avatar = document.getElementById("main-avatar");
    avatar.src = json.AVATAR;
    const mainusername = document.getElementById("main-username");
    mainusername.textContent = json.USERNAME;
  }
}

function fetchAvatar() {
  fetch("fetchUserAvatar.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonAvatar);
}

function onJsonUserGames(json) {
  const h1 = document.getElementById("game-header");
  if (json.nouser) {
    h1.textContent = "NO FAVOURITE GAMES YET";
  } else {
    h1.textContent = "FAVOURITE GAMES";
    const section = document.getElementById("favourite-games");
    for (item of json) {
      const gameLink = document.createElement("a");
      gameLink.href =
        "result.php?name=" +
        encodeURIComponent(item.GAME_NAME) +
        "&qid=videoGame";
      const cover = document.createElement("img");
      cover.src = item.COVER;
      gameLink.appendChild(cover);
      section.appendChild(gameLink);
    }
  }
}

function onJsonUserMovies(json) {
  const h1 = document.getElementById("movie-header");
  if (json.nouser) {
    h1.textContent = "NO FAVOURITE MOVIES OR SHOWS YET";
  } else {
    h1.textContent = "FAVOURITE MOVIES & SHOWS";
    const section = document.getElementById("favourite-movies");
    for (item of json) {
      const gameLink = document.createElement("a");
      gameLink.href = "result.php?id=" + encodeURIComponent(item.FILM_ID);
      const cover = document.createElement("img");
      cover.src = item.COVER;
      gameLink.appendChild(cover);
      section.appendChild(gameLink);
    }
  }
}

function onJsonDeleteReview(json) {
  if (json.ok == "delete") {
    const reviews = document.querySelectorAll(
      "#your-reviews .review-container .review"
    );
    for (item of reviews) {
      if (
        item.dataset.id == json.referenceid &&
        item.dataset.reviewid == json.id
      ) {
        item.parentNode.classList.add("nascosto");
        fetchUserInfo();
        break;
      }
    }
    const OtherReviews = document.querySelectorAll(
      "#favourite-reviews .review-container .review"
    );
    for (item of OtherReviews) {
      if (
        item.dataset.id == json.referenceid &&
        item.dataset.reviewid == json.id
      ) {
        item.parentNode.classList.add("nascosto");
        return;
      }
    }
  }
}

function deleteReview(event) {
  const button = event.currentTarget;
  const buttonDiv = button.parentNode.parentNode;
  const id = buttonDiv.querySelector(".review").dataset.reviewid;
  const referenceid = buttonDiv.querySelector(".review").dataset.id;
  const formData = new FormData();
  formData.append("id", id);
  formData.append("reference_id", referenceid);
  fetch("deleteReview.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonDeleteReview);
}

function onJsonMyReviews(json) {
  const sectionTitle = document.getElementById("my-header");
  if (!json.norev) {
    sectionTitle.textContent = "REVIEWS";
    const revDiv = document.getElementById("your-reviews");
    for (item of json) {
      const reviewBox = document.createElement("div");
      reviewBox.classList.add("review-container");
      const redirectLink = document.createElement("a");
      const moviediv = document.createElement("div");
      moviediv.classList.add("review");
      const redirectReviewLink = document.createElement("a");
      if (item.hasOwnProperty("GAME_ID")) {
        moviediv.dataset.id = item.GAME_ID;
        redirectLink.href =
          "result.php?name=" +
          encodeURIComponent(item.GAME_NAME) +
          "&qid=videoGame";
        redirectReviewLink.href =
          "editReview.php?id=" +
          encodeURIComponent(item.GAME_ID) +
          "&user=" +
          encodeURIComponent(item.USERNAME);
      } else {
        moviediv.dataset.id = item.FILM_ID;
        redirectLink.href = "result.php?id=" + encodeURIComponent(item.FILM_ID);
        redirectReviewLink.href =
          "editReview.php?id=" +
          encodeURIComponent(item.FILM_ID) +
          "&user=" +
          encodeURIComponent(item.USERNAME);
      }
      const cover = document.createElement("img");
      cover.src = item.COVER;
      cover.classList.add("poster");
      redirectLink.appendChild(cover);
      reviewBox.appendChild(redirectLink);
      moviediv.dataset.reviewid = item.ID;
      const review = document.createElement("div");
      const profileLink = document.createElement("a");
      profileLink.href = "profile.php?q=" + encodeURIComponent(item.USERNAME);
      const avatar = document.createElement("img");
      avatar.src = item.AVATAR;
      avatar.classList.add("avatar");
      profileLink.appendChild(avatar);
      review.appendChild(profileLink);
      const user = document.createElement("h2");
      user.textContent = item.USERNAME;
      review.appendChild(user);
      const revrat = document.createElement("p");
      revrat.textContent = "Rating: " + item.VOTO;
      revrat.classList.add("rating");
      review.appendChild(revrat);
      moviediv.appendChild(review);
      const revtxt = document.createElement("p");
      revtxt.textContent = item.RECENSIONE;
      revtxt.classList.add("text");
      moviediv.appendChild(revtxt);
      reviewBox.appendChild(moviediv);
      if (verifyUserSession) {
        const optionsBlock = document.createElement("div");
        optionsBlock.classList.add("options-block");
        const deleteButton = document.createElement("button");
        deleteButton.textContent = "DELETE";
        deleteButton.classList.add("delete-button");
        deleteButton.addEventListener("click", deleteReview);
        optionsBlock.appendChild(deleteButton);
        const editButton = document.createElement("button");
        editButton.textContent = "EDIT";
        editButton.classList.add("edit-button");
        redirectReviewLink.appendChild(editButton);
        optionsBlock.appendChild(redirectReviewLink);
        reviewBox.appendChild(optionsBlock);
      }
      revDiv.appendChild(reviewBox);
    }
    getReviewLikes();
  } else {
    sectionTitle.textContent = "YOU HAVEN'T WRITTEN ANY REVIEW YET";
  }
}

function onJsonMyLikedReviews(json) {
  const sectionTitle = document.getElementById("favourite-header");
  if (!json.norev) {
    sectionTitle.textContent = "LIKED REVIEWS";
    const revDiv = document.getElementById("favourite-reviews");
    for (item of json) {
      const reviewBox = document.createElement("div");
      reviewBox.classList.add("review-container");
      const moviediv = document.createElement("div");
      moviediv.classList.add("review");
      const redirectLink = document.createElement("a");
      if (item.hasOwnProperty("GAME_ID")) {
        moviediv.dataset.id = item.GAME_ID;
        redirectLink.href =
          "result.php?name=" +
          encodeURIComponent(item.GAME_NAME) +
          "&qid=videoGame";
      } else {
        moviediv.dataset.id = item.FILM_ID;
        redirectLink.href = "result.php?id=" + encodeURIComponent(item.FILM_ID);
      }
      const cover = document.createElement("img");
      cover.src = item.COVER;
      cover.classList.add("poster");
      redirectLink.appendChild(cover);
      reviewBox.appendChild(redirectLink);
      moviediv.dataset.reviewid = item.ID;
      const review = document.createElement("div");
      const profileLink = document.createElement("a");
      profileLink.href = "profile.php?q=" + encodeURIComponent(item.USERNAME);
      const avatar = document.createElement("img");
      avatar.src = item.AVATAR;
      avatar.classList.add("avatar");
      profileLink.appendChild(avatar);
      review.appendChild(profileLink);
      const user = document.createElement("h2");
      user.textContent = item.USERNAME;
      review.appendChild(user);
      const revrat = document.createElement("p");
      revrat.textContent = "Rating: " + item.VOTO;
      revrat.classList.add("rating");
      review.appendChild(revrat);
      moviediv.appendChild(review);
      const revtxt = document.createElement("p");
      revtxt.textContent = item.RECENSIONE;
      revtxt.classList.add("text");
      moviediv.appendChild(revtxt);
      reviewBox.appendChild(moviediv);
      if (verifyUserSession) {
        const likeHeart = document.createElement("img");
        likeHeart.src = "public/full.svg";
        likeHeart.classList.add("heart");
        likeHeart.addEventListener("click", RemoveReview);
        reviewBox.appendChild(likeHeart);
      }
      revDiv.appendChild(reviewBox);
    }
    getReviewLikes();
  } else {
    sectionTitle.textContent = "YOU HAVEN'T LIKED ANY REVIEW YET";
  }
}

function onJsonReviewLikes(json) {
  const reviews = document.querySelectorAll(".review");
  for (item of reviews) {
    if (
      item.querySelector("div h2").textContent == json.USERNAME &&
      item.dataset.reviewid == json.ID
    ) {
      if (!item.querySelector(".likes")) {
        const likes = document.createElement("p");
        likes.textContent = json.NUMLIKE + " likes";
        likes.classList.add("likes");
        item.appendChild(likes);
      } else {
        item.querySelector(".likes").textContent = json.NUMLIKE + " likes";
      }
    }
  }
}

function getReviewLikes() {
  const reviews = document.querySelectorAll(".review");
  const formData = new FormData();
  for (item of reviews) {
    const checkId = item.dataset.id;
    formData.append("id", checkId);
    formData.append("username", item.querySelector("div h2").textContent);
    fetch("getReviewLikes.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonReviewLikes);
  }
}

function onJsonShowMyLike(json) {
  const p = document.getElementById("favourites");
  if (json.nolikes) {
    p.textContent = "0 likes";
  } else {
    p.textContent = json.likes + " likes";
  }
}

function onJsonShowMyReviews(json) {
  const p = document.getElementById("written");
  if (json.norev) {
    p.textContent = "0 reviews";
  } else {
    p.textContent = json.rev + " reviews";
  }
}

function onJsonRemoveReview(json) {
  if (json.ok == "delete") {
    const reviews = document.querySelectorAll(
      "#favourite-reviews .review-container .review"
    );
    for (item of reviews) {
      if (
        item.dataset.id == json.referenceid &&
        item.dataset.reviewid == json.id
      ) {
        item.parentNode.classList.add("nascosto");
        return;
      }
    }
  }
}

function RemoveReview(event) {
  const img = event.currentTarget;
  const imgDiv = img.parentNode;
  const id = imgDiv.querySelector(".review").dataset.reviewid;
  const referenceid = imgDiv.querySelector(".review").dataset.id;
  const formData = new FormData();
  formData.append("id", id);
  formData.append("reference_id", referenceid);
  fetch("deleteReviewLike.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonRemoveReview);
}

function fetchUserFavourites() {
  fetch("fetchUserMovies.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonUserMovies);
  fetch("fetchUserGames.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonUserGames);
  fetch("fetchMyReviews.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonMyReviews);
  fetch("fetchMyLikedReviews.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonMyLikedReviews);
}

function fetchUserInfo() {
  fetch("fetchMyLikes.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonShowMyLike);
  fetch("fetchReviewCount.php?q=" + encodeURIComponent(username))
    .then(onResponse)
    .then(onJsonShowMyReviews);
}

function toggleSettings() {
  const settingsDiv = document.getElementById("settings-div");
  const profileContent = document.getElementById("profile-content");
  if (settingsStatus) {
    settingsStatus = false;
    form.classList.remove("settings-form");
    form.classList.add("nascosto");
    settingsDiv.classList.add("nascosto");
    profileContent.classList.remove("nascosto");
  } else {
    settingsStatus = true;
    settingsDiv.classList.remove("nascosto");
    form.classList.add("settings-form");
    form.classList.remove("nascosto");
    profileContent.classList.add("nascosto");
  }
}

let verifyUserSession = false;
let form;
let checkSubmit = false;
let fileLabel;
let fileInput;
if (document.getElementById("settings") !== null) {
  verifyUserSession = true;
  const settings = document.getElementById("settings");
  settings.addEventListener("click", toggleSettings);
  form = document.querySelector("form");
  form.password.addEventListener("blur", check_password);
  form.password.addEventListener("blur", check_minlength);
  form.email.addEventListener("blur", check_email);
  form.addEventListener("submit", check_credentials);
  fileLabel = document.getElementById("avatar");
  fileLabel.addEventListener("click", activateClick);
  fileInput = document.getElementById("file");
  fileInput.addEventListener("change", checkFile);
  const show_pwd = document.querySelector(".show-password");
  show_pwd.addEventListener("click", toggleVisibility);
}

const hide = "public/eye_slash_visible_hide_hidden_show_icon_145987.svg";
const show = "public/eye_visible_hide_hidden_show_icon_145988.svg";
let settingsStatus = false;
const username = document.getElementById("main-username").dataset.username;
fetchAvatar();
fetchUserInfo();
fetchUserFavourites();
