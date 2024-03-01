<?php require_once("../partials/boilerplate.php"); ?>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php";
    $source = "users/index.php";
    ?>
    <main>

        <?php
        // Get link from the url
        if (isset($_GET["id"])) {
            $pid = $_GET["id"];
            $p = new Product();
            $product = $p->getProductById($pid);
            echo $product->requiresInstallation == true;
        }

        ?>

        <div class="row gx-0 my-3">
            <h1 class="text-center my-2">Edit Product</h1>
            <div class="col-6 offset-3">
                <form action="../../controllers/product.php" method="POST">
                    <input type="hidden" name="formType" value="productUpdate">
                    <input type="hidden" name="id" value="<?php echo $pid; ?>">
                    <div class="mb-3" id="imgDiv">
                        <?php foreach ($product["img"] as $key => $img) : ?>
                            <div class="row mt-4 gx-2 align-items-start imgSubDiv">
                                <div class="col-md-4">
                                    <img src="<?php echo $img; ?>" class="img-thumbnail w-100 p-0" alt="Image of product">
                                </div>
                                <div class="col-md-8 mb-3">
                                    <div class="imgForm mb-1">
                                        <label class="form-label" for="image<?php echo $key ?>">URL Εικόνας</label>
                                        <input class="form-control imgInput" type="url" pattern="https://.*" id="image<?php echo $key ?>" name="img_url[]" value="<?php echo $img; ?>" required />
                                    </div>
                                    <input class="form-check-input" type="checkbox" onclick="removeImg(this)">
                                    <label class="form-check-label" for="removeImg">
                                        Διαγραφή εικόνας
                                    </label>
                                </div>

                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="text-end mb-3 d-flex justify-content-end">
                        <button class="btn btn-dark mt-2" type="button" id="duplButton" onclick="duplicate()">Προσθήκη Εικόνας</button>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">Όνομα Προϊόντος</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?php echo $product["name"] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="descr">Περιγραφή</label>
                        <textarea class="form-control" rows="6" type="text" id="descr" name="description" required><?php echo $product["description"] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="manufacturer">Κατασκευαστής</label>
                        <input class="form-control" type="text" id="manufacturer" name="manufacturer" value="<?php echo $product["manufacturer"] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="price">Τιμή</label>
                        <div class="input-group">
                            <span class="input-group-text" id="price-label">€</span>
                            <input type="number" class="form-control" id="price" placeholder="0.00" min="0" step="0.01" name="price" value="<?php echo $product["price"] ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="availability">Διαθεσιμότητα</label>
                        <input type="number" class="form-control" id="availability" name="availability" min="0" value="<?php echo $product["availability"] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="category">Κατηγορία</label>
                        <select class="form-select" id="category" name="category" onchange='getOption()' required>
                            <option selected value="<?php echo $product["category"] ?>"><?php echo $product["category"] ?></option>
                            <option value='Φωτισμός'>Φωτισμός</option>
                            <option value='Πρίζες'>Πρίζες</option>
                            <option value='Ασφάλεια-Πρόσβαση'>Ασφάλεια-Πρόσβαση</option>
                            <option value='Ψύξη-Θέρμανση'>Ψύξη-Θέρμανση</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="subcategory">Υποκατηγορία</label>
                        <select class="form-select" id="subcategory" name="subcategory" required>
                            <option selected value="<?php echo $product["subcategory"] ?>"><?php echo $product["subcategory"] ?></option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="color">Χρώμα</label>
                        <input class="form-control" type="text" id="color" name="color" value="<?php echo $product["color"] ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="hasApp">Έχει εφαρμογή</label>
                        <select class="form-select" id="hasApp" name="hasApp" required>
                            <?php if ($product["hasApp"] == 1) : ?>
                                <option selected value="true">Ναι</option>
                                <option value='false'>Όχι</option>
                            <?php else : ?>
                                <option selected value='false'>Όχι</option>
                                <option value="true">Ναι</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="requiresInstallation">Απαιτεί Εγκάτασταση</label>
                        <select class="form-select" id="requiresInstallation" name="requiresInstallation" required>
                            <?php if ($product["requiresInstallation"] == 1) : ?>
                                <option selected value="true">Ναι</option>
                                <option value='false'>Όχι</option>
                            <?php else : ?>
                                <option selected value='false'>Όχι</option>
                                <option value="true">Ναι</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Συμβατότητα (Προαιρετικό)</label><br>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option1" name="compatibility[]" value="Amazon Alexa" <?php echo in_array("Amazon Alexa", iterator_to_array($product["compatibility"])) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="option1">Amazon Alexa</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option2" name="compatibility[]" value="Google Assistant" <?php echo in_array("Google Assistant", iterator_to_array($product["compatibility"])) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="option2">Google Assistant</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="option3" name="compatibility[]" value="Apple HomeKit" <?php echo in_array("Apple HomeKit", iterator_to_array($product["compatibility"])) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="option3">Apple HomeKit</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="ports">Θύρες Υποδοχής (Προαιρετικό, Απαραίτητο για πρίζες)</label>
                        <input class="form-control" type="number" id="ports" name="ports" value="<?php echo $product["ports"] != null ? $product["ports"] : '' ?>" />
                    </div>

                    <div class='mb-3'>
                        <button class="btn btn-info" id="submitButton" type="submit">Ενημέρωση Προϊόντος</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container text-center">
            <a href="show.php?id=<?php echo $pid; ?>" class="btn btn-success my-4">Επιστροφή στo Προϊόν</a>
        </div>

    </main>
    <script>
        let i = 0;
        //function to get the option from the type select
        function getOption() {

            const type = document.getElementById("category").value;
            const trainers = document.getElementById("subcategory");
            if (type == "Φωτισμός") {
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
            const clone = original.cloneNode(true); // "deep" clone
            clone.className = clone.className.replace("col-md-8", "")
            clone.childNodes[1].setAttribute("for", "newImg" + i)
            clone.childNodes[3].setAttribute("id", "newImg" + i)
            div.insertAdjacentElement("beforeend", clone);
            i++;
        }

        function removeImg(check) {
            const checkbox = check;
            const div = checkbox.closest(".imgSubDiv");
            const input = div.querySelector(".imgInput");
            if (check.checked == true) {
                div.style.display = "none";
                input.setAttribute("disabled", "")
            } else {
                div.style.display = "";
                input.removeAttribute("disabled")
            }

        }
    </script>
</body>

</html>