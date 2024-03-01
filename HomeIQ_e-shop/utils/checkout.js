showTab(currentTab); // Display the current tab
if (loggedin) {
    //if user is loggedin jump to second tab
    document.getElementsByClassName("step")[currentTab - 1].className += " finish";
}

function showTab(n) {
    // This function will display the specified tab of the form 
    var x = document.getElementsByClassName("tab");
    x[n].style.display = "block";
    // fix the Previous/Next buttons:
    if (n == 0 || (n == 1 && loggedin == true)) {
        document.getElementById("prevBtn").style.display = "none";
    } else {
        document.getElementById("prevBtn").style.display = "inline";
    }
    if (n == (x.length - 1)) {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("nextBtn").innerHTML = "Submit";
    } else if (n == 0) {
        document.getElementById("nextBtn").style.display = "none";
    } else {
        document.getElementById("nextBtn").innerHTML = "Next";
        document.getElementById("nextBtn").style.display = "inline";
    }
    // run a function that displays the correct step indicator:
    fixStepIndicator(n)
}

function nextPrev(n) {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Exit the function if any field in the current tab is invalid:
    if (n == 1 && !validateForm()) return false;
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    currentTab = currentTab + n;
    // if you have reached the end of the form :
    if (currentTab >= x.length) {
        //the form gets submitted:
        document.getElementById("regForm").submit();
    }
    // Otherwise, display the correct tab:
    showTab(currentTab);
}

function visitor() {
    // This function will figure out which tab to display
    var x = document.getElementsByClassName("tab");
    // Hide the current tab:
    x[currentTab].style.display = "none";
    // Increase or decrease the current tab by 1:
    document.getElementsByClassName("step")[currentTab].className += " finish";
    currentTab = currentTab + 1;
    // Otherwise, display the correct tab:

    showTab(currentTab);
}

function validateForm() {
    // This function deals with validation of the form fields
    'use strict';
    const forms = document.getElementById("regForm");
    var x, y, i, valid = true;
    x = document.getElementsByClassName("tab");
    //the form submitted from the first tab
    if (currentTab == 0) {
        y = x[currentTab].getElementsByTagName("input");
        const alert = document.getElementById("alert");
        const passLogin = document.getElementById("passwordLogin1");
        const emailLogin = document.getElementById("emailLogin1");
        if (emailLogin.value != '' && passLogin.value != '') {
            //send request to check if user provided the correct values
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "../controllers/users.php?verifyEmail=" + emailLogin.value + "&verifyPassword=" + passLogin.value, false);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    const response = xhr.responseText;
                    //if response is 0 it means that values are wrong
                    if (response == 0) {
                        alert.style.display = "";
                        alert.innerText = "Δεν υπάρχει αυτός ο συνδυασμός email και κωδικού";
                        valid = false;
                    } else {
                        //send POST request to controller to login user
                        var request = new XMLHttpRequest();
                        request.open("POST", "../controllers/users.php", false);
                        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                        request.onreadystatechange = function () {
                            if (request.readyState == 4 && request.status == 200) {
                                //redirect to checkout.php
                                document.location.assign("../views/checkout.php");
                                valid = false;
                            }
                        }

                        request.send("email=" + emailLogin.value + "&password=" + passLogin.value + "&formType=login&source=checkout.php");
                    }
                }
            }
            xhr.send();
        } else {
            //check validity for the inputs
            for (i = 0; i < 2; i++) {
                if (!y[i].checkValidity()) {
                    y[i].className += " invalid";
                    valid = false;
                }
            }
        }

    } else {
        //check validity for the inputs
        y = x[currentTab].getElementsByTagName("input");
        for (i = 0; i < y.length; i++) {
            if (!y[i].checkValidity()) {
                valid = false;
            }
        }

        forms.classList.add("was-validated");


    }
    if (valid && currentTab == 0) {
        document.getElementsByClassName("step")[0].className += " finish";
        document.getElementsByClassName("step")[1].className += " finish";

    } else if (valid) {
        document.getElementsByClassName("step")[currentTab].className += " finish";
        forms.classList.remove("was-validated");
    }

    return valid; // return the valid status
}

function fixStepIndicator(n) {
    // This function removes the "active" class of all steps
    var i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    //add the "active" class to the current step:
    x[n].className += " active";
}
