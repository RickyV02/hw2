function RandomNumber() {
  return Math.floor(Math.random() * 100);
}

function RandomBigNumber() {
  return Math.floor(Math.random() * 500);
}

function onJsonWeekly(json) {
  const topMovies = json.data;
  const livefeed = document.querySelector("#livefeed div");
  for (item of topMovies) {
    const movielink = document.createElement("a");
    movielink.href = "result.php?id=" + encodeURIComponent(item.id);
    const movieThumb = item.primaryImage.imageUrl;
    const thumbImg = document.createElement("img");
    thumbImg.src = movieThumb;
    thumbImg.dataset.id = item.imdbid;
    thumbImg.onerror = function () {
      thumbImg.src = placeholder_img;
    };
    movielink.appendChild(thumbImg);
    livefeed.appendChild(movielink);
  }
}

function onJsonRandomMovies(json) {
  const livefeed = document.querySelector("#randommovies div");
  for (let i = 0; i < 10; i++) {
    let index = RandomNumber();
    if (i >= 1) {
      const images = document.querySelectorAll("#randommovies div a img");
      const ids = [];
      for (let j = 0; j < images.length; j++) {
        ids.push(images[j].dataset.id);
      }
      while (ids.includes(json[index].imdbid)) {
        index = RandomNumber();
      }
    }
    const item = json[index];
    const movielink = document.createElement("a");
    movielink.href = "result.php?id=" + encodeURIComponent(item.imdbid);
    let movieThumb;
    if (item.hasOwnProperty("image")) {
      movieThumb = item.image;
    } else if (item.hasOwnProperty("thumbnail")) {
      movieThumb = item.thumbnail;
    } else {
      movieThumb = placeholder_img;
    }
    const thumbImg = document.createElement("img");
    thumbImg.src = movieThumb;
    thumbImg.dataset.id = item.imdbid;
    thumbImg.onerror = function () {
      thumbImg.src = placeholder_img;
    };
    movielink.appendChild(thumbImg);
    livefeed.appendChild(movielink);
  }
}

function onJsonRandomSeries(json) {
  const livefeed = document.querySelector("#randomseries div");
  for (let i = 0; i < 10; i++) {
    let index = RandomNumber();
    if (i >= 1) {
      const images = document.querySelectorAll("#randomseries div a img");
      const ids = [];
      for (let j = 0; j < images.length; j++) {
        ids.push(images[j].dataset.id);
      }
      while (ids.includes(json[index].imdbid)) {
        index = RandomNumber();
      }
    }
    const item = json[index];
    const movielink = document.createElement("a");
    movielink.href = "result.php?id=" + encodeURIComponent(item.imdbid);
    let movieThumb;
    if (item.hasOwnProperty("image")) {
      movieThumb = item.image;
    } else if (item.hasOwnProperty("thumbnail")) {
      movieThumb = item.thumbnail;
    } else {
      movieThumb = placeholder_img;
    }
    const thumbImg = document.createElement("img");
    thumbImg.src = movieThumb;
    thumbImg.dataset.id = item.imdbid;
    thumbImg.onerror = function () {
      thumbImg.src = placeholder_img;
    };
    movielink.appendChild(thumbImg);
    livefeed.appendChild(movielink);
  }
}

function onJsonRandomGames(json) {
  const gamefeed = document.querySelector("#randomgames div");
  for (let i = 0; i < 20; i++) {
    let index = RandomBigNumber();
    if (i >= 1) {
      const images = document.querySelectorAll("randomgames div a img");
      const ids = [];
      for (let j = 0; j < images.length; j++) {
        ids.push(images[j].dataset.id);
      }
      while (ids.includes(json[index].cover.image_id)) {
        index = RandomBigNumber();
      }
    }
    const item = json[index];
    const gamelink = document.createElement("a");
    gamelink.href =
      "result.php?name=" +
      encodeURIComponent(item.name) +
      "&qid=" +
      encodeURIComponent("videoGame");
    const img_id = item.cover.image_id;
    const cover_url =
      "https://images.igdb.com/igdb/image/upload/t_cover_big/" +
      img_id +
      ".jpg";
    const thumbImg = document.createElement("img");
    thumbImg.src = cover_url;
    thumbImg.dataset.id = img_id;
    thumbImg.onerror = function () {
      thumbImg.src = placeholder_img;
    };
    gamelink.appendChild(thumbImg);
    gamefeed.appendChild(gamelink);
  }
}

function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function getContent() {
  fetch("FetchWeekly.php").then(onResponse).then(onJsonWeekly);
  fetch("FetchRandomMovies.php").then(onResponse).then(onJsonRandomMovies);
  fetch("FetchRandomSeries.php").then(onResponse).then(onJsonRandomSeries);
  fetch("FetchRandomGames.php").then(onResponse).then(onJsonRandomGames);
}

function checkInput(event) {
  if (form.search.value === "") event.preventDefault();
}

getContent();
const placeholder_img =
  "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png";
const form = document.querySelector("form");
form.addEventListener("submit", checkInput);
