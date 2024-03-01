<?php require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/user-profile.css">

</head>

<body style="margin-top: 9em;">
    <?php require("../../utils/flash_messages.php");
    require_once('../../utils/authenticateUser.php');
    require_once "../partials/navbar.php";
    require_once("../../models/user.php");
    require_once("../../models/order.php");
    ?>
    <?php
    $source = substr($_SERVER["PHP_SELF"], 21);

    flash("updateSuccess");
    flash("updateError");
    ?>
    <main>
        <div class="container light-style flex-grow-1">
            <h1 class="py-3 mb-4 text-center">
                Ο λογαριασμός μου
            </h1>
            <div class="row gx-0 ">
                <div class="col-lg-4 col-md-12">
                    <div class="mb-3">
                        <div class=" nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <button class="nav-link active" id="v-pills-account_general-tab" data-bs-toggle="pill" data-bs-target="#v-pills-account_general" type="button" role="tab" aria-controls="v-pills-account_general" aria-selected="true">Ο λογαριασμός μου</button>
                            <button class="nav-link" id="v-pills-password-tab" data-bs-toggle="pill" data-bs-target="#v-pills-password" type="button" role="tab" aria-controls="v-pills-password" aria-selected="false">Αλλαγή Κωδικού πρόσβασης</button>
                            <button class="nav-link" id="v-pills-reservation-tab" data-bs-toggle="pill" data-bs-target="#v-pills-reservation" type="button" role="tab" aria-controls="v-pills-reservation" aria-selected="false">Ιστορικό Παραγγελιών</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-12">
                    <?php
                    if (isset($_SESSION["userID"])) {
                        //Get data from the current user
                        $userId = $_SESSION["userID"];
                        $u = new User();
                        $user = $u->getUserById($userId);
                        $email = "'" . $user->email . "'";
                    }
                    ?>
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="alert alert-danger" id="updateAlert" style="display: none;"></div>
                        <div class="tab-pane fade show active" id="v-pills-account_general" role="tabpanel" aria-labelledby="v-pills-account_general-tab" tabindex="0">
                            <div class="card-body">
                                <form action="../../controllers/users.php" method="post" class="needs-validation" id="updateForm" novalidate onsubmit="return submitForm(event, <?php echo $email; ?>)">
                                    <input type="hidden" name="formType" value="updateUser">
                                    <input type="hidden" name="id" value="<?php echo $userId ?>">
                                    <input type="hidden" name="source" value="<?php echo $source ?>">
                                    <!-- Form Row-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputEmailAddress">Email</label>
                                        <input class="form-control " id="inputEmailAddress" type="email" name="email" placeholder="Email" value="<?php echo $user["email"]; ?>" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="inputTel" class="form-label">Κινητό</label>
                                        <input type="tel" class="form-control" id="inputTel" name="tel" pattern="[0-9]{10}" value="<?php echo $user["phone"]; ?>" required>
                                    </div>
                                    <div class="row gx-3 gy-3 mb-3">
                                        <!-- Form Group (first name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputFirstName">Όνομα</label>
                                            <input class="form-control" id="inputFirstName" type="text" name="name" placeholder="Όνομα" value="<?php echo $user["name"]; ?>" required>
                                        </div>
                                        <!-- Form Group (last name)-->
                                        <div class="col-md-6">
                                            <label class="small mb-1" for="inputLastName">Επώνυμο</label>
                                            <input class="form-control " id="inputLastName" type="text" name="surname" placeholder="Επώνυμο" value="<?php echo $user["surname"]; ?>" required>
                                        </div>
                                    </div>
                                    <!-- Form Row        -->
                                    <!-- Form Group (city)-->
                                    <div class="mb-3">
                                        <label class="small mb-1" for="inputCity">Πόλη</label>
                                        <input class="form-control " id="inputCity" type="text" name="city" placeholder="Πόλη" value="<?php echo $user["city"]; ?>" required>
                                    </div>
                                    <div class="row gx-3 gy-3 mb-3">
                                        <!-- Form Group (address)-->
                                        <div class="col-sm-6">
                                            <label class="small mb-1" for="inputAddress">Διεύθυνση</label>
                                            <input class="form-control " id="inputAddress" type="text" name="address" placeholder="Διεύθυνση" value="<?php echo $user["address"]; ?>" required>
                                        </div>

                                        <div class="col-sm-6">
                                            <label class="small mb-1" for="inputPostalCode">Τ.Κ</label>
                                            <input class="form-control " id="inputPostalCode" type="text" name="postalCode" placeholder="Τ.Κ" value="<?php echo $user["postalCode"]; ?>" required>
                                        </div>
                                    </div>


                                    <!-- Save changes button-->
                                    <button class="btn btn-primary" type="submit">Αποθήκευση Αλλαγών</button>
                                </form>
                            </div>
                        </div>
                        <!-- Tab to change password -->
                        <div class="tab-pane fade" id="v-pills-password" role="tabpanel" aria-labelledby="v-pills-password-tab" tabindex="0">
                            <div class="card">
                                <div class="card-body pb-2">
                                    <form action="../../controllers/users.php" class="needs-validation" id="updatePassword" method="POST" novalidate>
                                        <input type="hidden" name="formType" value="passwordUpdate">
                                        <input type="hidden" name="id" value="<?php echo $userId; ?>">
                                        <input type="hidden" name="password" value="<?php echo $user["password"]; ?>">
                                        <div class="form-group">
                                            <label class="form-label" for="InputPassword1">Υπάρχων Κωδικός</label>
                                            <input type="password" class="form-control" id="InputPassword1" name="pass1" required>
                                            <input type="checkbox" class="form-check-input" id="check1" onclick="showPassword('InputPassword1')">
                                            <label for="check1" class="form-check-label">Εμφάνιση Κωδικού</label>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="InputPassword2">Νέος Κωδικός</label>
                                            <input type="password" class="form-control" id="InputPassword2" name="pass2" required>
                                            <input type="checkbox" class="form-check-input" id="check2" onclick="showPassword('InputPassword2')">
                                            <label for="check2" class="form-check-label">Εμφάνιση Κωδικού</label>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label" for="InputPassword3">Επανάληψη Νέου
                                                Κωδικού</label>
                                            <input type="password" class="form-control" id="InputPassword3" name="pass3" required>
                                            <input type="checkbox" class="form-check-input" id="check3" onclick="showPassword('InputPassword3')">
                                            <label for="check3" class="form-check-label">Εμφάνιση Κωδικού</label>
                                        </div>
                                        <!-- Save changes button-->
                                        <button class="btn btn-primary" type="submit">Αποθήκευση Αλλαγών</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Tab for displaying bookings -->
                        <div class="tab-pane fade" id="v-pills-reservation" role="tabpanel" aria-labelledby="v-pills-reservation-tab" tabindex="0">
                            <div class="card-body pb-2">
                                <div class="form-group">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Αρ. Παραγγελίας</th>
                                                <th scope="col">Ημερομηνία Παραγγελίας</th>
                                                <th scope="col">Κατάσταση</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $o = new Order();
                                            $orders = $o->getOrdersByUserId($userId);
                                            if (count($orders) == 0) {
                                                echo "<p>Δεν έχετε κάνει ακόμα κάποια κράτηση</p>";
                                            } else {
                                                foreach ($orders as $order) {
                                                    echo "<tr>";

                                                    echo "<td>", $order["_id"],  "</td>";
                                                    $date = date("d-m-Y", strtotime($order["dateTimeOrdered"]));
                                                    echo "<td>", $date, "</td>";


                                                    echo "<td>", $order->status, "</td>";
                                                    echo "<td><a href='../orders/order-details.php?id=", $order["_id"], "' class='btn btn-primary'>Περισσότερα</a></td>";


                                                    echo "</tr>";
                                                }
                                            }


                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../../utils/validate_user_profile.js"></script>
    <script>
        function showPassword(targetID) {
            const x = document.getElementById(targetID)

            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
</body>

</html>