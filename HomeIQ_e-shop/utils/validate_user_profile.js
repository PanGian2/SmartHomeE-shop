(() => {
    'use strict'

    const form = document.getElementById("updatePassword")

    const alert = document.getElementById('updateAlert');
    const pass1 = document.getElementById("InputPassword1");
    const pass2 = document.getElementById("InputPassword2");
    const pass3 = document.getElementById("InputPassword3");
    const email = document.getElementById("inputEmailAddress");
    const tel = document.getElementById("inputTel");
    const re = new RegExp("[0-9]{10}");
    // Loop over the form and prevent submission in case of invalidity
    form.addEventListener('submit', event => {

        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }
        let formType = form.querySelector('input[name="formType"]').value;

        if (formType == "passwordUpdate") {
            //check if two passwords are the same
            if (pass2.value != pass3.value) {
                event.preventDefault()
                event.stopPropagation()
                alert.style.display = "";
                alert.innerText = "Οι κωδικοί που εισάγατε δεν είναι ίδιοι!";
                alert.scrollIntoView();
            }

            if (email.value != '' && pass1.value != '') {
                //check if password corresponds to the current user
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../../controllers/users.php?verifyEmail=" + email.value + "&verifyPassword=" + pass1.value, false);
                xhr.onreadystatechange = function () {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        const response = xhr.responseText;
                        if (response == 0) {
                            event.preventDefault()
                            event.stopPropagation()
                            alert.style.display = "";
                            alert.innerText = "O κωδικός που εισάγατε είναι λανθασμένος";
                            alert.scrollIntoView();
                        }
                    }
                }
                xhr.send();
            }

        }


        form.classList.add("was-validated");
    }, false)
})()

function submitForm(event, oldEmail) {
    const form = document.getElementById("updateForm");
    const alert = document.getElementById('updateAlert');
    const email = document.getElementById("inputEmailAddress");
    const tel = document.getElementById("inputTel");
    const re = new RegExp("[0-9]{10}");

    // Loop over the form and prevent submission in case of invalidity
    if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
    }

    //check if telephone matches the 10digit pattern
    if (!tel.value.match(re)) {
        event.preventDefault()
        event.stopPropagation()
        alert.style.display = "";
        alert.innerText = "Παρακαλώ εισάγετε τον 10ψηφιο αριθμό τηλεφώνου σας!";
        alert.scrollIntoView();
    } else {
        alert.style.display = "none";
    }

    //check if oldEmail and current email are not the same
    if (email.value != '' && oldEmail != email.value) {
        //check if new email corresponds to another user
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "../../controllers/users.php?verifyEmail=" + email.value, false);
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                const response = xhr.responseText;
                if (response == 0) {
                    event.preventDefault()
                    event.stopPropagation()
                    alert.style.display = "";
                    alert.innerText = "Υπάρχει ήδη κάποιος άλλος χρήστης με αυτό το email!";
                    alert.scrollIntoView();
                }
            }
        }
        xhr.send();

    }
    form.classList.add("was-validated");
}