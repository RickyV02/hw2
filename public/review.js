function Rng() {
  return Math.floor(Math.random() * 10);
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

function onJsonReview(json) {
  const formTitle = document.querySelector(".review-form h1");
  if (!json.ok) {
    formTitle.textContent = "Write Your Review !";
  } else {
    formTitle.textContent = "Already Reviewed !";
    form.classList.add("nascosto");
    const profileLink = document.createElement("a");
    profileLink.href = "profile.php?q=" + encodeURIComponent(username);
    profileLink.textContent = "See Your Review At Your Profile";
    const formDiv = document.querySelector(".review-form");
    formDiv.appendChild(profileLink);
  }
}

function saveReview() {
  const formData = new FormData();
  formData.append("id", id);
  formData.append("name", namer);
  formData.append("cover", img);
  formData.append("review", reviewContent.value);
  formData.append("rating", form.rating.value);
  fetch("saveReview.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonReview)
    .then(getInfo);
}

function check_credentials(event) {
  event.preventDefault();
  if (checkSubmit) {
    saveReview();
    getInfo();
  }
}

function onResponse(response) {
  if (!response.ok) {
    return null;
  }
  return response.json();
}

function onJsonLike(json) {
  if (json.ok) {
    heart.src = fullheart;
    checkLike = true;
  } else {
    heart.src = emptyheart;
    checkLike = false;
  }
}

function getLike() {
  const formData = new FormData();
  formData.append("id", id);
  fetch("getLike.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonLike);
}

function getReview() {
  const formData = new FormData();
  formData.append("id", id);
  fetch("getReview.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonReview);
}

function onJsonRandomReviews(json) {
  const sectionTitle = document.querySelector("#other_reviews h1");
  if (!json.norev) {
    sectionTitle.textContent = "Some of Our Users Reviews";
    const revDiv = document.getElementById("reviews-box");
    const displayedReviews = [];
    if (json.length > 10) {
      for (let i = 0; i < 5; i++) {
        let index;
        do {
          index = Rng();
        } while (displayedReviews.includes(index));
        displayedReviews.push(index);
        const item = json[index];
        const moviediv = document.createElement("div");
        moviediv.classList.add("review");
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
        const likeHeart = document.createElement("img");
        likeHeart.src = emptyheart;
        likeHeart.classList.add("review-heart");
        likeHeart.addEventListener("click", toggleReviewHeart);
        moviediv.appendChild(likeHeart);
        revDiv.appendChild(moviediv);
      }
    } else {
      for (item of json) {
        const moviediv = document.createElement("div");
        moviediv.classList.add("review");
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
        const likeHeart = document.createElement("img");
        likeHeart.src = emptyheart;
        likeHeart.classList.add("review-heart");
        likeHeart.addEventListener("click", toggleReviewHeart);
        moviediv.appendChild(likeHeart);
        revDiv.appendChild(moviediv);
      }
    }
  } else {
    sectionTitle.textContent = "This title has not been reviewed yet!";
  }
}

function onJsonReviewLikes(json) {
  const reviews = document.querySelectorAll(".review");
  for (item of reviews) {
    if (item.querySelector("div h2").textContent == json.USERNAME) {
      if (!item.querySelector(".likes")) {
        const likes = document.createElement("p");
        likes.textContent = json.NUMLIKE + " likes";
        likes.classList.add("likes");
        item.appendChild(likes);
      } else {
        item.querySelector(".likes").textContent = json.NUMLIKE + " likes";
      }
      return;
    }
  }
}

function getReviewLike() {
  const reviews = document.querySelectorAll(".review");
  const formData = new FormData();
  formData.append("id", id);
  for (item of reviews) {
    formData.append("username", item.querySelector("div h2").textContent);
    fetch("getReviewLikes.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonReviewLikes);
  }
}

function getRandomReviews() {
  fetch("getRandomReviews.php?q=" + encodeURIComponent(id))
    .then(onResponse)
    .then(onJsonRandomReviews)
    .then(getReviewLike)
    .then(getMyReviewLikes);
}

function onJsonShowLike(json) {
  const par = document.getElementById("likes");
  par.textContent = json.info + " likes";
}

function onJsonShowReviews(json) {
  const par = document.getElementById("reviews");
  par.textContent = json.info + " reviews";
}

function getInfo() {
  const formData = new FormData();
  formData.append("id", id);
  fetch("getNumLikes.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonShowLike);
  fetch("getNumReviews.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonShowReviews);
}

function ToggleHeart() {
  const formData = new FormData();
  formData.append("id", id);
  if (!checkLike) {
    formData.append("name", namer);
    formData.append("cover", img);
    fetch("saveLikes.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonLike)
      .then(getInfo);
  } else {
    fetch("deleteLikes.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonLike)
      .then(getInfo);
  }
}

function onJsonMyReviewLikes(json) {
  if (!json.nolike) {
    const indexs = [];
    for (item of json) {
      indexs.push(item.REVIEW_ID);
    }
    const reviews = document.querySelectorAll(".review");
    for (item of reviews) {
      if (indexs.includes(item.dataset.reviewid)) {
        const heart = item.querySelector(".review-heart");
        heart.src = fullheart;
      }
    }
  }
}

function getMyReviewLikes() {
  const formData = new FormData();
  formData.append("id", id);
  fetch("fetchMyReviewLikes.php", { method: "post", body: formData })
    .then(onResponse)
    .then(onJsonMyReviewLikes);
}

function onJsonRHeart(json) {
  const allHearts = document.querySelectorAll(".review-heart");
  for (item of allHearts) {
    if (json.id == item.parentNode.dataset.reviewid) {
      if (json.ok === "insert") {
        item.src = fullheart;
      } else {
        item.src = emptyheart;
      }
    }
  }
}

function toggleReviewHeart(event) {
  const formData = new FormData();
  const div = event.currentTarget.parentNode;
  formData.append("id", div.dataset.reviewid);
  formData.append("reference_id", id);
  if (event.currentTarget.src === "http://localhost/hw1/" + emptyheart) {
    fetch("addReviewLike.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonRHeart)
      .then(getReviewLike);
  } else {
    fetch("deleteReviewLike.php", { method: "post", body: formData })
      .then(onResponse)
      .then(onJsonRHeart)
      .then(getReviewLike);
  }
}

let checkSubmit = false;
let checkLike = false;
const emptyheart = "assets/empty.svg";
const fullheart = "assets/full.svg";
const form = document.querySelector("form");
form.rating.addEventListener("blur", checkRating);
const reviewContent = document.getElementById("review");
reviewContent.addEventListener("blur", checkReview);
form.addEventListener("submit", check_credentials);
form.addEventListener("submit", getInfo);
const heart = document.getElementById("heart");
heart.addEventListener("click", ToggleHeart);
const namer = document.getElementById("name").dataset.name;
const img = document.getElementById("cover").dataset.image;
const username = document.querySelector(".review-form").dataset.username;
const id = document.querySelector(".review-form").dataset.id;

getLike();
getReview();
getRandomReviews();
getInfo();
