function submitform(event) {
    event.currentTarget.parentNode.submit();
}

const formSubmits = document.querySelectorAll("form h3");
for (item of formSubmits) item.addEventListener("click", submitform);
