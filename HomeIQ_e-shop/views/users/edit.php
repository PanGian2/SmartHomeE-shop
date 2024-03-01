<?php require_once("../partials/boilerplate.php"); ?>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php";
    $source = "users/show.php?id=" . $_GET["id"];
    ?>
    <main>
        <?php
        //Get id from the url
        $userId = $_GET["id"];
        $u = new User();
        $user = $u->getUserById($userId);
        $email = "'" . $user->email . "'";
        ?>

        <div class="row gx-0 my-3">
            <h1 class="text-center my-2">Edit User</h1>
            <div class="col-6 offset-3">
                <div class="alert alert-danger" id="alert" style="display: none;"></div>
                <form action="../../controllers/users.php" method="post" onsubmit="return submitForm(event, <?php echo $email ?>)">
                    <input type="hidden" name="formType" value="updateUser">
                    <input type="hidden" name="source" value="<?php echo $source ?>">
                    <input type="hidden" name="id" value="<?php echo $userId ?>">
                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" id="email-label">@</span>
                            <input type="text" class="form-control" id="email" aria-label="email" aria-describedby="email-label" name="email" value="<?php echo $user->email; ?>" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="name">Ονομα</label>
                        <input class="form-control" type="text" id="name" name="name" value="<?php echo $user->name; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="surname">Επιθετο</label>
                        <input class="form-control" type="text" id="surname" name="surname" value="<?php echo $user->surname; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="tel" class="form-label">Κινητό</label>
                        <input type="tel" class="form-control" id="tel" name="tel" pattern="[0-9]{10}" value="<?php echo $user->phone; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="city">Πόλη</label>
                        <input type="text" class='form-control' name="city" id="city" value="<?php echo $user->city ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="address">Διευθυνση</label>
                        <input class="form-control" type="text" id="address" name="address" value="<?php echo $user->address; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="postalCode">Τ.Κ</label>
                        <input class="form-control" type="number" id="postalCode" name="postalCode" value="<?php echo $user->postalCode; ?>" required />
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="type">Τύπος</label>
                        <select class="form-select" id="type" name="role" required>
                            <?php
                            if ($user->role == "1") {
                                echo "<option selected value='1'>Απλός</option>";
                                echo "<option value='2'>Διαχειριστής</option>";
                            } else {
                                echo "<option selected value='2'>Διαχειριστής</option>";
                                echo "<option value='1'>Απλός</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="my-4">
                        <button class="btn btn-info" type="submit">Ενημέρωση Χρήστη</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="container text-center">
            <a href="show.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Χρηστών</a>
        </div>

    </main>
    <script>
        "use strict"
        const alert = document.getElementById("alert");

        function submitForm(event, oldEmail) {
            const email = document.getElementById("email");
            const postalCode = document.getElementById("postalCode");
            if (email.value != '' && oldEmail != email.value) {
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
                            return false;
                        }
                    }
                }
                xhr.send();

            }
        }
    </script>
</body>

</html>