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
            <h1 class="text-center my-2">Δημιουργία Χρήστη</h1>
            <div class="col-6 offset-3">
                <div class="alert alert-danger" id="alert" style="display: none;"></div>
                <form action="../../controllers/users.php" method="POST" id="createForm">
                    <input type="hidden" name="formType" value="createUser" />
                    <input type="hidden" name="source" value="<?php echo $source ?>" />
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" id="email-label">@</span>
                            <input type="text" class="form-control" id="email" aria-label="email" aria-describedby="email-label" name="email" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">Ονομα</label>
                        <input class="form-control" type="text" id="name" name="name" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="surname">Επιθετο</label>
                        <input class="form-control" type="text" id="surname" name="surname" required />
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Κινητό</label>
                        <input type="tel" class="form-control" id="tel" name="tel" pattern="[0-9]{10}" required>
                    </div>
                    <div class=" mb-3">
                        <label class="form-label" for="city">Πόλη</label>
                        <input type="text" class="form-control" name="city" id="city" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Διευθυνση</label>
                        <input class="form-control" type="text" id="address" name="address" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="postalCode">Τ.Κ</label>
                        <input class="form-control" type="number" id="postalCode" name="postalCode" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="type">Τύπος</label>
                        <select class="form-select" id="type" name="type" required>
                            <option selected disabled>Επέλεξε Τύπο</option>
                            <option value="1">Απλός</option>
                            <option value="2">Διαχειριστής</option>
                        </select>
                    </div>
                    <div class="my-4">
                        <button class="btn btn-info" type="submit">Δημιουργία Χρήστη</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container text-center">
            <a href="show.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Χρηστών</a>
        </div>
    </main>
    <script>
        const form = document.getElementById("createForm");
        const alert = document.getElementById("alert");
        form.addEventListener("submit", event => {
            const email = document.getElementById("email");
            const postalCode = document.getElementById("postalCode");
            if (email.value != '') {
                var xhr = new XMLHttpRequest();
                xhr.open("GET", "../../controllers/users.php?verifyEmail=" + email.value, false);
                xhr.onreadystatechange = function() {
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
        })
    </script>
</body>

</html>