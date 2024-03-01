const togglePassword = document.getElementsByClassName("togglePassword");
const untogglePassword = document.getElementsByClassName('untogglePassword');

//add click listeners to all toggle and untoggle password icons
Array.from(togglePassword).forEach(function (element) {
    element.addEventListener("click", toggle);
});

Array.from(untogglePassword).forEach(function (element) {
    element.addEventListener("click", untoggle);
});

function toggle() {
    // Toggle using the type attribute
    const hidden = this.closest(".hidden");
    const password = this.closest("div").querySelector(".password")
    const shown = this.closest("div").querySelector(".shown");
    const type = password.getAttribute('type') === 'password' ?
        'text' : 'password';
    password.setAttribute('type', type);
    // Toggle the eye and bi-eye icon
    if (hidden.style.display != "none") {
        hidden.style.display = "none";
        shown.style.display = "";
    }
}

function untoggle() {
    // Toggle using the type attribute
    const hidden = this.closest("div").querySelector(".hidden");
    const password = this.closest("div").querySelector(".password")
    const shown = this.closest(".shown");

    const type = password.getAttribute('type') === 'password' ?
        'text' : 'password';
    password.setAttribute('type', type);
    // Toggle the eye and bi-eye icon
    if (shown.style.display != "none") {
        hidden.style.display = "";
        shown.style.display = "none";
    }
}
