(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.navNeeds-validation')

    const regAlert = document.getElementById('regAlert');
    const logAlert = document.getElementById('logAlert');
    const pass1 = document.getElementById("passwordInput");
    const passLogin = document.getElementById("passwordLogin");
    const pass2 = document.getElementById("confirmPasswordInput");
    const tel = document.getElementById("telRegister");
    const email = document.getElementById("emailRegister");
    const emailLogin = document.getElementById("emailLogin");
    const re = new RegExp("[0-9]{10}");
    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {

            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }
            let formType = form.querySelector('input[name="formType"]').value;
            if (formType == "createUser") {
                //check if two passwords are the same
                if (pass1.value != pass2.value) {
                    event.preventDefault()
                    event.stopPropagation()
                    regAlert.style.display = "";
                    regAlert.innerText = "Οι κωδικοί που εισάγατε δεν είναι ίδιοι!";
                    regAlert.scrollIntoView();
                } else {
                    regAlert.style.display = "none";
                }

                //check if telephone matches the 10digit pattern
                if (!tel.value.match(re)) {
                    event.preventDefault()
                    event.stopPropagation()
                    regAlert.style.display = "";
                    regAlert.innerText = "Παρακαλώ εισάγετε τον 10ψηφιο αριθμό τηλεφώνου σας!";
                    regAlert.scrollIntoView();
                } else {
                    regAlert.style.display = "none";
                }

                //check if email corresponds to another user
                if (email.value != '') {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", source + "users.php?verifyEmail=" + email.value, false);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            const response = xhr.responseText;
                            if (response == 0) {
                                console.log("hi")
                                event.preventDefault()
                                event.stopPropagation()
                                regAlert.style.display = "";
                                regAlert.innerText = "Υπάρχει ήδη κάποιος άλλος χρήστης με αυτό το email";
                                regAlert.scrollIntoView();
                            }
                        }
                    }
                    xhr.send();
                }
            } else if (formType == "login") {
                //check if email and password correspond to a user
                if (emailLogin.value != '' && passLogin.value != '') {
                    var xhr = new XMLHttpRequest();
                    xhr.open("GET", source + "users.php?verifyEmail=" + emailLogin.value + "&verifyPassword=" + passLogin.value, false);
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            const response = xhr.responseText;
                            if (response == 0) {
                                event.preventDefault()
                                event.stopPropagation()
                                logAlert.style.display = "";
                                logAlert.innerText = "Δεν υπάρχει αυτός ο συνδυασμός email και κωδικού";
                                logAlert.scrollIntoView();
                            }
                        }
                    }
                    xhr.send();
                }
            }


            form.classList.add("was-validated");
        }, false)
    })
})()