function checkInput(event) {
    if (form.search.value === "") event.preventDefault();
}

const form = document.querySelector("form");
form.addEventListener("submit", checkInput);
