function onResponse(response) {
  if (!response.ok) {
    console.log("Error: " + response);
    return null;
  } else return response.json();
}

function submitform(event) {
  event.currentTarget.parentNode.submit();
}

function onJsonGame(json) {
  modal_search.innerHTML = "";
  for (item of json) {
    const game = item;
    const game_div = document.createElement("div");
    game_div.classList.add("modal_game");
    const game_cover = document.createElement("img");
    const img_id = game.cover.image_id;
    const cover_url =
      "https://images.igdb.com/igdb/image/upload/t_cover_big/" +
      img_id +
      ".jpg";
    game_cover.src = cover_url;
    game_cover.classList.add("cover");
    const review_form = document.createElement("form");
    review_form.setAttribute("action", "review.php");
    review_form.setAttribute("method", "post");
    const data = {
      id: game.id,
      name: game.name,
      image: cover_url,
    };
    for (const key in data) {
      if (data.hasOwnProperty(key)) {
        const input = document.createElement("input");
        input.setAttribute("type", "hidden");
        input.setAttribute("name", key);
        input.value = data[key];
        review_form.appendChild(input);
      }
    }
    const reviewh2 = document.createElement("h3");
    reviewh2.textContent = "Leave a Review !";
    review_form.appendChild(game_cover);
    review_form.appendChild(reviewh2);
    reviewh2.addEventListener("click", submitform);
    const game_info = document.createElement("div");
    const game_title = document.createElement("p");
    game_title.textContent = game.name;
    game_info.appendChild(game_title);
    if (game.platforms) {
      const game_platform = document.createElement("p");
      game_platform.textContent = "Platforms: ";
      for (item of game.platforms) {
        game_platform.textContent += item.name + " ";
      }
      game_info.appendChild(game_platform);
    }
    if (game.release_dates) {
      const first_release = document.createElement("p");
      first_release.textContent =
        "First Release Date: " + game.release_dates[0].human;
      game_info.appendChild(first_release);
    }
    const summary = document.createElement("p");
    summary.textContent = "Summary: " + game.summary;
    const storyline = document.createElement("p");
    storyline.textContent = "Storyline: " + game.storyline;
    const game_genre = document.createElement("p");
    game_genre.textContent = "Genres: ";
    if (game.genres) {
      for (item of game.genres) {
        game_genre.textContent += item.name + " ";
      }
      game_info.appendChild(game_genre);
    }
    if (game.franchise) {
      const franchise = document.createElement("p");
      franchise.textContent = "Franchise: " + game.franchise.name;
      game_info.appendChild(franchise);
    }
    const themes = document.createElement("p");
    themes.textContent = "Themes: ";
    if (game.themes) {
      for (item of game.themes) {
        themes.textContent += item.name + " ";
      }
      game_info.appendChild(themes);
    }
    if (game.expansions) {
      const dlc = document.createElement("p");
      dlc.textContent = "Expansions: ";
      for (item of game.expansions) {
        dlc.textContent += item.name + " ";
      }
      game_info.appendChild(dlc);
    }
    if (game.dlcs) {
      const dlc = document.createElement("p");
      dlc.textContent = "Dlcs: ";
      for (item of game.dlcs) {
        dlc.textContent += item.name + " ";
      }
      game_info.appendChild(dlc);
    }
    if (game.involved_companies) {
      const dlc = document.createElement("p");
      dlc.textContent = "Involved Companies: ";
      for (item of game.involved_companies) {
        dlc.textContent += item.company.name + " ";
      }
      game_info.appendChild(dlc);
    }
    if (summary.textContent !== "Summary: undefined") {
      game_info.appendChild(summary);
    }
    if (storyline.textContent !== "Storyline: undefined") {
      game_info.appendChild(storyline);
    }
    game_div.appendChild(review_form);
    game_div.appendChild(game_info);
    modal_search.appendChild(game_div);
  }
}

function onJsonMovie(json) {
  modal_search.innerHTML = "";
  const film = json;
  const movie_div = document.createElement("div");
  movie_div.classList.add("modal_game");
  const poster = document.createElement("img");
  poster.classList.add("cover");
  if (film.primaryImage !== null) {
    poster.src = json.primaryImage.url;
  } else {
    poster.src = placeholder_img;
  }
  const review_form = document.createElement("form");
  review_form.setAttribute("action", "review.php");
  review_form.setAttribute("method", "post");
  const data = {
    id: film.id,
    name: film.titleText.text,
    image: poster.src,
  };
  for (const key in data) {
    if (data.hasOwnProperty(key)) {
      const input = document.createElement("input");
      input.setAttribute("type", "hidden");
      input.setAttribute("name", key);
      input.value = data[key];
      review_form.appendChild(input);
    }
  }
  const reviewh2 = document.createElement("h3");
  reviewh2.textContent = "Leave a Review !";
  review_form.appendChild(poster);
  review_form.appendChild(reviewh2);
  reviewh2.addEventListener("click", submitform);
  movie_div.appendChild(review_form);
  const movie_info = document.createElement("div");
  const movie_title = document.createElement("p");
  movie_title.textContent = film.titleText.text;
  movie_info.appendChild(movie_title);
  if (film.releaseDate !== null) {
    const releaseDate = document.createElement("p");
    releaseDate.textContent = "Release Date: ";
    if (film.releaseDate.day !== null) {
      releaseDate.textContent += film.releaseDate.day + "/";
    }
    if (film.releaseDate.month !== null) {
      releaseDate.textContent += film.releaseDate.month + "/";
    }
    if (film.releaseDate.year !== null) {
      releaseDate.textContent += film.releaseDate.year;
    }
    movie_info.appendChild(releaseDate);
  }
  if (film.ratingsSummary.aggregateRating !== null) {
    const rating = document.createElement("p");
    rating.textContent =
      "Rating Summary: " + film.ratingsSummary.aggregateRating;
    movie_info.appendChild(rating);
  }
  if (film.metacritic !== null) {
    const metascore = document.createElement("p");
    metascore.textContent =
      "Metacritic Score: " + film.metacritic.metascore.score;
    movie_info.appendChild(metascore);
  }
  if (film.canHaveEpisodes) {
    const ep = document.createElement("p");
    ep.textContent = "Episodes: " + film.episodes.episodes.total;
    movie_info.appendChild(ep);
  }
  if (film.genres !== null) {
    const genres = document.createElement("p");
    genres.textContent = "Genres: ";
    for (item of film.genres.genres) {
      genres.textContent += item.text + " ";
    }
    movie_info.appendChild(genres);
  }
  if (film.directors.length !== 0) {
    const director = document.createElement("p");
    director.textContent = "Director: ";
    for (item of film.directors[0].credits) {
      director.textContent += item.name.nameText.text;
    }
    movie_info.appendChild(director);
  }
  if (film.countriesOfOrigin !== null) {
    const country = document.createElement("p");
    country.textContent = "Countries of Origin: ";
    for (item of film.countriesOfOrigin.countries) {
      country.textContent += item.id + "";
    }
    movie_info.appendChild(country);
  }
  if (film.directors.length !== 0 && film.directors.credits) {
    const director = document.createElement("p");
    director.textContent = "Director: ";
    for (item of film.directors) {
      if (item.credits.length !== 0) {
        director.textContent += item.credits[0].name.nameText.text + " ";
      }
    }
    movie_info.appendChild(director);
  }
  if (json.nominations.total !== 0) {
    const info = document.createElement("p");
    info.textContent = "Nominations: " + json.nominations.total;
    movie_info.appendChild(info);
  }
  if (film.production.edges.length !== 0) {
    const info = document.createElement("p");
    info.textContent =
      "Production Company: " +
      film.production.edges[0].node.company.companyText.text;
    movie_info.appendChild(info);
  }
  if (film.productionBudget !== null) {
    const info = document.createElement("p");
    info.textContent =
      "Production Budget: " +
      film.productionBudget.budget.amount +
      " " +
      film.productionBudget.budget.currency;
    movie_info.appendChild(info);
  }
  if (film.plot !== null) {
    const mainplot = document.createElement("p");
    mainplot.textContent = "Plot: " + film.plot.plotText.plainText;
    movie_info.appendChild(mainplot);
  }
  if (film.cast.edges.length !== 0) {
    const movie_credits = document.createElement("section");
    movie_credits.classList.add("credits");
    const cast = film.cast.edges;
    for (item of cast) {
      const movie_li = document.createElement("a");
      movie_li.classList.add("search");
      const obj = item.node;
      const actor_name = document.createElement("p");
      actor_name.textContent = obj.name.nameText.text;
      movie_li.href = "result.php?id=" + encodeURIComponent(obj.name.id);
      movie_li.appendChild(actor_name);
      const img = document.createElement("img");
      if (!obj.name.primaryImage) {
        img.src = placeholder_img;
      } else {
        img.src = obj.name.primaryImage.url;
      }
      const ch = obj.characters;
      if (ch !== null) {
        for (item of ch) {
          const character = document.createElement("p");
          character.textContent = item.name;
          movie_li.appendChild(character);
        }
      }
      movie_li.appendChild(img);
      movie_credits.appendChild(movie_li);
    }
    const movie_cast = document.createElement("p");
    movie_cast.textContent = "Cast: ";
    movie_cast.appendChild(movie_credits);
    movie_info.appendChild(movie_cast);
  }
  movie_div.appendChild(movie_info);
  modal_search.appendChild(movie_div);
}

function onJsonOthers(json) {
  modal_search.innerHTML = "";
  const movie_div = document.createElement("div");
  movie_div.classList.add("modal_game");
  const poster = document.createElement("img");
  poster.classList.add("cover");
  if (json.primaryImage !== null) {
    poster.src = json.primaryImage.url;
  } else {
    poster.src = placeholder_img;
  }
  movie_div.appendChild(poster);
  const movie_info = document.createElement("div");
  const actor_name = document.createElement("p");
  actor_name.textContent = json.nameText.text;
  movie_info.appendChild(actor_name);
  if (json.birthDate) {
    const birthDay = document.createElement("p");
    birthDay.textContent =
      "Birth Date: " +
      json.birthDate.dateComponents.day +
      "/" +
      json.birthDate.dateComponents.month +
      "/" +
      json.birthDate.dateComponents.year;
    movie_info.appendChild(birthDay);
  }
  if (json.birthLocation) {
    const birthLoc = document.createElement("p");
    birthLoc.textContent = "Birth Location: " + json.birthLocation.text;
    movie_info.appendChild(birthLoc);
  }
  if (json.deathDate) {
    const deathDay = document.createElement("p");
    deathDay.textContent =
      "Death Date: " +
      json.deathDate.dateComponents.day +
      "/" +
      json.deathDate.dateComponents.month +
      "/" +
      json.deathDate.dateComponents.year;
    movie_info.appendChild(deathDay);
  }
  if (json.deathLocation) {
    const deathLoc = document.createElement("p");
    deathLoc.textContent = "Death Location: " + json.deathLocation.text;
    movie_info.appendChild(deathLoc);
  }
  if (json.deathCause) {
    const death_Cause = document.createElement("p");
    death_Cause.textContent =
      "Death Cause: " + json.deathCause.displayableProperty.value.plainText;
    movie_info.appendChild(death_Cause);
  }
  if (json.children) {
    const children = document.createElement("p");
    children.textContent = "Children: " + json.children.total;
    movie_info.appendChild(children);
  }
  if (json.jobs.length !== 0) {
    const jobs = document.createElement("p");
    jobs.textContent = "Jobs: ";
    for (item of json.jobs) {
      jobs.textContent += item.category.text + " ";
    }
    movie_info.appendChild(jobs);
  }
  if (json.wins.total !== 0) {
    const info = document.createElement("p");
    info.textContent = "Wins: " + json.wins.total;
    movie_info.appendChild(info);
  }
  if (json.nominations.total !== 0) {
    const info = document.createElement("p");
    info.textContent = "Nominations: " + json.nominations.total;
    movie_info.appendChild(info);
  }
  if (json.knownForFeature.edges.length !== 0) {
    const movie_credits = document.createElement("section");
    movie_credits.classList.add("credits");
    const cast = json.knownForFeature.edges;
    for (item of cast) {
      const movie_li = document.createElement("a");
      movie_li.classList.add("search");
      const obj = item.node.title;
      const actor_name = document.createElement("p");
      actor_name.textContent = obj.titleText.text;
      movie_li.appendChild(actor_name);
      const img = document.createElement("img");
      if (!obj.primaryImage) {
        img.src = placeholder_img;
      } else {
        img.src = obj.primaryImage.url;
      }
      movie_li.appendChild(img);
      movie_li.href = "result.php?id=" + encodeURIComponent(obj.id);
      movie_credits.appendChild(movie_li);
    }
    const movie_cast = document.createElement("p");
    movie_cast.textContent = "Known For: ";
    movie_cast.appendChild(movie_credits);
    movie_info.appendChild(movie_cast);
  }
  movie_div.appendChild(movie_info);
  modal_search.appendChild(movie_div);
}

function showResults() {
  if (search_qid === "videoGame") {
    fetch("FetchGame.php?q=" + encodeURIComponent(search))
      .then(onResponse)
      .then(onJsonGame);
  } else if (search.includes("tt")) {
    fetch("FetchMovie.php?q=" + encodeURIComponent(search))
      .then(onResponse)
      .then(onJsonMovie);
  } else if (search.includes("nm")) {
    fetch("FetchOthers.php?q=" + encodeURIComponent(search))
      .then(onResponse)
      .then(onJsonOthers);
  }
}

const modal_search = document.getElementById("modal_search");
const search = modal_search.dataset.search;
const search_qid = modal_search.dataset.search_qid;
const placeholder_img =
  "https://upload.wikimedia.org/wikipedia/commons/thumb/6/65/No-Image-Placeholder.svg/330px-No-Image-Placeholder.svg.png";
  
showResults();