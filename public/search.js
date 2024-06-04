function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function onJson(json) {
  const results = json.d;
  modal_search.innerHTML = "";
  if (results.length === 0) {
    const msg = document.createElement("h2");
    msg.textContent = "NO RESULTS !";
    modal_search.appendChild(msg);
  }
  for (item of results) {
    const nome = item.l;
    let poster;
    if (!item.i) {
      poster = placeholder_img;
    } else {
      poster = item.i.imageUrl;
    }
    const movie_list = document.createElement("a");
    movie_list.classList.add("search");
    const poster_url = document.createElement("img");
    poster_url.src = poster;
    poster_url.classList.add("cover");
    const title = document.createElement("h2");
    title.textContent = nome;
    if (item.qid === "videoGame") {
      movie_list.href =
        "result.php?name=" +
        encodeURIComponent(nome) +
        "&qid=" +
        encodeURIComponent("videoGame");
    } else {
      movie_list.href =
        "result.php?id=" +
        encodeURIComponent(item.id) +
        "&qid=" +
        encodeURIComponent(item.qid);
    }
    movie_list.appendChild(title);
    movie_list.appendChild(poster_url);
    modal_search.appendChild(movie_list);
  }
}

function showSearch() {
  fetch("FetchRequest.php?q=" + encodeURIComponent(searchname))
    .then(onResponse)
    .then(onJson);
}


const modal_search = document.getElementById("modal_search");
const searchname = modal_search.dataset.searchname;
const placeholder_img =
  "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png";

showSearch();