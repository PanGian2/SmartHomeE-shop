<?php require_once("../partials/boilerplate.php"); ?>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php";
    $source = "users/index.php";
    ?>
    <main>
        <div class="row gx-0 my-3">
            <h1 class="text-center my-2">Νέο Προϊόν</h1>
            <div class="col-6 offset-3">
                <form action="../../controllers/product.php" method="POST">
                    <input type="hidden" name="formType" value="productCreate">
                    <div class="mb-3" id="imgDiv">
                        <div class="imgForm mt-3">
                            <label class="form-label" for="image">URL Εικόνας</label>
                            <input class="form-control imgInput" type="url" pattern="https://.*" name="img_url[]" required />
                        </div>
                    </div>
                    <div class="text-end d-flex justify-content-end">
                        <button class="btn btn-dark mt-2" type="button" id="duplButton" onclick="duplicate()">Προσθήκη Εικόνας</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">Όνομα Προϊόντος</label>
                        <input class="form-control" type="text" id="name" name="name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descr">Περιγραφή</label>
                        <textarea class="form-control" rows="6" type="text" id="descr" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="manufacturer">Κατασκευαστής</label>
                        <input class="form-control" type="text" id="manufacturer" name="manufacturer" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Τιμή</label>
                        <div class="input-group">
                            <span class="input-group-text" id="price-label">€</span>
                            <input type="number" class="form-control" id="price" placeholder="0.00" min="0" step=0.01 name="price" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="availability">Διαθεσιμότητα</label>
                        <input type="number" class="form-control" id="availability" name="availability" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category">Κατηγορία</label>
                        <select class="form-select" id="category" name="category" onchange='getOption()' required>
                            <option selected disabled value=''>Επιλέξτε την κατηγορία του προϊόντος</option>
                            <option value='Φωτισμός'>Φωτισμός</option>
                            <option value='Πρίζες'>Πρίζες</option>
                            <option value='Ασφάλεια-Πρόσβαση'>Ασφάλεια-Πρόσβαση</option>
                            <option value='Ψύξη-Θέρμανση'>Ψύξη-Θέρμανση</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="subcategory">Υποκατηγορία</label>
                        <select class="form-select" id="subcategory" name="subcategory" required>
                            <option selected disabled value=''>Επιλέξτε την υποκατηγορία του προϊόντος</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="color">Χρώμα</label>
                        <input class="form-control" type="text" id="color" name="color" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="hasApp">Έχει εφαρμογή</label>
                        <select class="form-select" id="hasApp" name="hasApp" required>
                            <option selected disabled value=''>Επιλέξτε αν το προϊόν έχει εφαρμογή ή όχι</option>
                            <option value='false'>Όχι</option>
                            <option value='true'>Ναι</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="requiresInstallation">Απαιτεί Εγκάτασταση</label>
                        <select class="form-select" id="requiresInstallation" name="requiresInstallation" required>
                            <option selected disabled value=''>Επιλέξτε αν το προϊόν έχει απαιτεί εγκατάσταση ή όχι</option>
                            <option value='false'>Όχι</option>
                            <option value='true'>Ναι</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Συμβατότητα (Προαιρετικό)</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option1" name="compatibility[]" value="Amazon Alexa">
                            <label class="form-check-label" for="option1">Amazon Alexa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option2" name="compatibility[]" value="Google Assistant">
                            <label class="form-check-label" for="option2">Google Assistant</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option3" name="compatibility[]" value="Apple HomeKit">
                            <label class="form-check-label" for="option3">Apple HomeKit</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ports">Θύρες Υποδοχής (Προαιρετικό, Απαραίτητο για πρίζες)</label>
                        <input class="form-control" type="number" id="ports" name="ports" />
                    </div>

                    <div class='mb-3'>
                        <button class="btn btn-info" id="submitButton" type="submit">Δημιουργία Προϊόντος</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container text-center">
            <a href="index.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Προϊόντων</a>
        </div>

    </main>
    <script>
        var i = 1;

        //function to get the option from the type select
        function getOption() {

            const type = document.getElementById("category").value;
            const trainers = document.getElementById("subcategory");
            if (type == "Φωτισμός") {
                //The program is a group program
                let value = "<option selected disabled value=''>Επιλέξτε την υποκατηγορία του προϊόντος</option><option value='Ταινίες LED'>Ταινίες LED</option><option value='Έξυπνες Λάμπες'>Έξυπνες Λάμπες</option>"
                subcategory.innerHTML = value;
            } else if (type == "Πρίζες") {
                let value = "<option selected disabled value=''>Επιλέξτε την υποκατηγορία του προϊόντος</option><option value='Σούκο'>Σούκο</option>"
                subcategory.innerHTML = value;
            } else if (type == "Ασφάλεια-Πρόσβαση") {
                let value = "<option selected disabled value=''>Επιλέξτε την υποκατηγορία του προϊόντος</option><option value='Κάμερες'>Κάμερες</option><option value='Θυροτηλεοράσεις'>Θυροτηλεοράσεις</option>"
                subcategory.innerHTML = value;
            } else if (type == "Ψύξη-Θέρμανση") {
                let value = "<option selected disabled value=''>Επιλέξτε την υποκατηγορία του προϊόντος</option><option value='Θερμοστάτες'>Θερμοστάτες</option><option value='Βαβλίδες Καλοριφέρ'>Βαβλίδες Καλοριφέρ</option>"
                subcategory.innerHTML = value;
            }
        }

        //Function that duplicates the trainerSelect
        function duplicate() {
            const original = document.getElementsByClassName("imgForm")[0];
            const duplButton = document.getElementById("duplButton");
            const div = document.getElementById("imgDiv");
            console.log(div)
            const clone = original.cloneNode(true); // "deep" clone

            div.insertAdjacentElement("beforeend", clone);

        }
    </script>
</body>

</html>