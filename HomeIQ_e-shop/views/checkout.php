<?php require_once("partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../public/styles/checkout.css">

</head>

<body>
    <?php require_once "partials/navbar.php";
    require_once "../models/user.php";
    if (isset($_COOKIE["cart"])) {
        $cart = unserialize($_COOKIE["cart"]); // Αποσειριοποίηση του καλαθιού
        $products = $cart->generateArray(); // Παραγωγή πίνακα αντικειμένων από το καλάθι
    } else {
        $products = []; // Αν το καλάθι είναι άδειο, αρχικοποιούμε τον πίνακα ως κενό
    }
    if (isset($_SESSION["userID"])) {
        $id = $_SESSION["userID"];
        $u = new User();
        $user = $u->getUserById($id);
    }
    ?>
    <main>
        <?php if (isset($_COOKIE["cart"])) : ?>
            <div class="container justify-content-center align-items-center my-3">
                <div class="row mx-2">
                    <div class="card  mx-auto">
                        <div class="card-body">
                            <h1 class="card-title text-center mb-5">Ολοκλήρωση Αγοράς</h1>
                            <form id="regForm" action="../controllers/order.php" method="post" class="needs-validation checkout-form" novalidate>
                                <!-- One "tab" for each step in the form: -->
                                <input type="hidden" name="formType" value="createOrder">
                                <?php
                                if (isset($_SESSION["userID"])) {
                                    echo '<input type="hidden" name="regularCustomer" value="', $_SESSION["userID"], '">';
                                }
                                ?>
                                <div class="tab">
                                    <div class="row gx-1 gy-2 text-center">
                                        <div class="col-12 col-lg-6 ps-1 pe-3" id="register2">
                                            <h2>Δεν έχεις λογαριασμό;</h2>
                                            <p>Γίνε μέλος της κοινότητάς μας και επωφελήσου από αποκλειστικές προσφορές, ειδικές εκπτώσεις και πρώτη πρόσβαση σε νέες προσφορές!
                                                Με τον προσωπικό σας λογαριασμό, μπορείτε να διαχειριστείτε εύκολα τις παραγγελίες σας, να αποθηκεύσετε τα αγαπημένα σας προϊόντα και
                                                να λάβετε εξατομικευμένες προτάσεις βασισμένες στις προτιμήσεις σας.</p>
                                            <button class="btn btn-success mb-4" type="button" data-bs-toggle="modal" data-bs-target="#registerModal">Δημιούργησε τώρα λογαριασμό</button>
                                            <h2>Συνέχεια ως επισκέπτης</h2>
                                            <p>Δεν έχετε λογαριασμό; Κανένα πρόβλημα! Συνεχίστε τη διαδικασία αγοράς ως επισκέπτης και επωφεληθείτε αμέσως από τα αγαπημένα σας προϊόντα.
                                                Απλά συμπληρώστε τις απαραίτητες πληροφορίες για την αποστολή και την πληρωμή και είστε έτοιμοι! Επιλέξτε την επιλογή 'Συνέχισε ως Επισκέπτης'
                                                και απολαύστε την ευκολία και τη γρήγορη αγορά των προϊόντων σας. Αφήστε την ανησυχία για μετέπειτα και εξασφαλίστε τα προϊόντα σας τώρα!</p>
                                            <button type="button" class="btn btn-success mb-3" id="visitorBtn" onclick="visitor()">Συνέχισε ως επισκέπτης</button>
                                        </div>
                                        <div class="col-12  col-lg-6 px-3">
                                            <h2 class="mb-4">Έχεις λογαριασμό;</h2>
                                            <h3 class="fs-4 mb-2">Συνδέσου με τα Social Media</h3>

                                            <a href="#" class="btn mb-2" style="background-color: #3B5998; color: white;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-facebook me-1 mb-1" viewBox="0 0 16 16">
                                                    <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951" />
                                                </svg> Σύνδεση με Facebook
                                            </a>
                                            <a href="#" class="google btn mb-2" style="background-color: #dd4b39; color: white;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" class="bi bi-google me-1 mb-1" viewBox="0 0 16 16">
                                                    <path d="M15.545 6.558a9.4 9.4 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.7 7.7 0 0 1 5.352 2.082l-2.284 2.284A4.35 4.35 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.8 4.8 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.7 3.7 0 0 0 1.599-2.431H8v-3.08z" />
                                                </svg> Σύνδεση με Google+
                                            </a>
                                            <h3 class="fs-4 mt-3">Ή συνδέσου με email</h3>
                                            <div class="alert alert-danger" id="alert" style="display: none;"></div>
                                            <div class="form-floating mb-3">
                                                <input type="email" class="form-control" id="emailLogin1" name="email" placeholder="name@example.com" required>
                                                <label for="emailLogin1">Email address</label>
                                            </div>
                                            <div class="form-floating input-group mb-3" style="border-radius: 10px;">
                                                <input type="password" class="form-control" id="passwordLogin1" name="password" placeholder="password" required>
                                                <label for="passwordLogin1">Κωδικός</label>
                                                <span class="input-group-text" id="hidden">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" id="togglePassword" style="cursor: pointer;">
                                                        <path d="M13.359 11.238C15.06 9.72 16 8 16 8s-3-5.5-8-5.5a7 7 0 0 0-2.79.588l.77.771A6 6 0 0 1 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755q-.247.248-.517.486z" />
                                                        <path d="M11.297 9.176a3.5 3.5 0 0 0-4.474-4.474l.823.823a2.5 2.5 0 0 1 2.829 2.829zm-2.943 1.299.822.822a3.5 3.5 0 0 1-4.474-4.474l.823.823a2.5 2.5 0 0 0 2.829 2.829" />
                                                        <path d="M3.35 5.47q-.27.24-.518.487A13 13 0 0 0 1.172 8l.195.288c.335.48.83 1.12 1.465 1.755C4.121 11.332 5.881 12.5 8 12.5c.716 0 1.39-.133 2.02-.36l.77.772A7 7 0 0 1 8 13.5C3 13.5 0 8 0 8s.939-1.721 2.641-3.238l.708.709zm10.296 8.884-12-12 .708-.708 12 12z" />
                                                    </svg>
                                                </span>
                                                <span class="input-group-text" id="shown" style="display: none;">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" id="untogglePassword" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16" style="cursor: pointer;">
                                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z" />
                                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0" />
                                                    </svg>
                                                </span>
                                            </div>
                                            <button type="button" id="loginBtn" class="btn btn-primary" onclick="nextPrev(1)">Σύνδεση</button>

                                        </div>
                                    </div>
                                </div>

                                <div class="tab">
                                    <h2 class="mb-2 text-start fs-3">Στοιχεία επικοινωνίας και αποστολής</h2>
                                    <div class="row mb-3">
                                        <div class="col-6">
                                            <label for="nameCheckout" class="form-label">Όνομα</label>
                                            <input type="text" class="form-control" name="name" id="nameCheckout" value="<?php echo isset($_SESSION["userID"]) ? $user["name"] : ""; ?>" required>
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                        <div class="col-6">
                                            <label for="surnameCheckout" class="form-label">Επίθετο</label>
                                            <input type="text" class="form-control" name="last_name" id="surnameCheckout" value="<?php echo isset($_SESSION["userID"]) ? $user["surname"] : ""; ?>" required>
                                        </div>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                    <div class="row mb-3 gy-2">
                                        <div class="col-md-6 col-sm-12">
                                            <label for="emailCheckout" class="form-label">Email address</label>
                                            <input type="email" class="form-control" name="email" id="emailCheckout" value="<?php echo isset($_SESSION["userID"]) ? $user["email"] : ""; ?>" required>
                                        </div>
                                        <div class="col-md-6 col-sm-12">
                                            <label for="telCheckout" class="form-label">Κινητό</label>
                                            <input type="tel" class="form-control" id="telCheckout" name="tel" pattern="[0-9]{10}" value="<?php echo isset($_SESSION["userID"]) ? $user["phone"] : ""; ?>" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3 gy-2">
                                        <div class="col-md-5 col-12">
                                            <label for="cityCheckout" class="form-label">Πόλη</label>
                                            <input type="text" class="form-control" id="cityCheckout" name="city" value="<?php echo isset($_SESSION["userID"]) ? $user["city"] : ""; ?>" required>
                                        </div>
                                        <div class="col-md-5 col-6">
                                            <label for="addressCheckout" class="form-label">Διεύθυνση</label>
                                            <input type="text" class="form-control" id="addressCheckout" name="address" value="<?php echo isset($_SESSION["userID"]) ? $user["address"] : ""; ?>" required>
                                        </div>
                                        <div class="col-md-2 col-6">
                                            <label for="postalCodeCheckout" class="form-label">T.K</label>
                                            <input type="number" class="form-control" id="postalCodeCheckout" name="postalCode" value="<?php echo isset($_SESSION["userID"]) ? $user["postalCode"] : ""; ?>" required>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab">

                                    <div class="row mb-3 gx-5 gy-3">
                                        <div class="col-lg-6">
                                            <h2 class="mb-2 text-start fs-3">Στοιχεία πληρωμής</h2>
                                            <div class="mb-3">
                                                <label for="cardNumber" class="form-label">Αριθμός Κάρτας</label>
                                                <input type="text" class="form-control" name="cardNumber" id="cardNumber" required>
                                            </div>
                                            <div class="row mb-3 gy-2 align-items-end">
                                                <div class="col-sm-3 col-6">
                                                    <label class="form-label">Ημ. Λήξης</label>
                                                    <label for="expMonth" hidden>Μήνας Λήξης</label>
                                                    <input type="number" class="form-control" name="expMonth" id="expMonth" min="1" max="12" placeholder="MM" required>
                                                </div>
                                                <div class="col-sm-3 col-6">
                                                    <label class="form-label" hidden for="expYear">Έτος Λήξης</label>
                                                    <input type="number" class="form-control" id="expYear" name="expYear" min="2024" max="2053" placeholder="YYYY" required>
                                                </div>
                                                <div class="col-sm-6 col-12 text-sm-end">
                                                    <label for="cvv" class="form-label">CVV</label>
                                                    <div class="d-flex justify-content-end">
                                                        <input type="text" class="form-control w-sm-50 w-100" id="cvv" pattern="[0-9]{3}" name="cvv" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3 gy-2">
                                                <div class="col-12">
                                                    <label for="fullname" class="form-label">Ονοματεπώνυμο Κατόχου</label>
                                                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6" style="background-color: white; border-radius:7px;">
                                            <div class="row align-items-center">
                                                <div class="col-6">
                                                    <h2 class="fs-3 mb-3">Σύνοψη καλαθιού</h2>
                                                </div>
                                                <div class="col-6 text-end mb-3">
                                                    <a href="cart.php" class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover">
                                                        Επιστροφή στο καλάθι
                                                    </a>
                                                </div>
                                            </div>

                                            <ul class="list-group list-group-flush">
                                                <?php $requiresInstallation = false;
                                                foreach ($products as $product) :
                                                    if ($requiresInstallation == false && $product["requiresInstallation"] == true) {
                                                        $requiresInstallation = true;
                                                    }
                                                ?>
                                                    <li class="list-group-item list-group-item-primary">
                                                        <div class="row align-items-center d-flex justify-content-between gy-2">
                                                            <div class="col-sm-8 col-7">
                                                                <span><?php echo $product['name'] ?></span>
                                                            </div>
                                                            <div class="col-2">
                                                                <span>x<?php echo $product['qty'] ?></span>
                                                            </div>

                                                            <div class="col-sm-2 col-3">
                                                                <strong class="text-end"><span class="totalPrice"><?php echo $product['totalPrice'] ?></span> €</strong>
                                                            </div>
                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <hr>
                                            <?php if ($requiresInstallation == true && $cart->totalPrice > 100) : ?>
                                                <div class="row my-3 ">
                                                    <strong>Διακαιούστε δωρεάν εγκατάσταση!</strong>
                                                </div>
                                            <?php endif; ?>
                                            <div class="row my-3 ">
                                                <strong class="fs-5">Σύνολο: <span id="cartTotalPrice"><?php echo $cart->totalPrice ?></span> €</strong>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div style="overflow:auto; margin-top: 4%;">
                                    <div style="float:right;">
                                        <button type="button" class="btn btn-dark" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                        <button type="button" class="btn btn-dark" id="nextBtn" onclick="nextPrev(1)">Next</button>
                                    </div>
                                </div>

                                <!-- Circles which indicates the steps of the form: -->
                                <div style="text-align:center;margin-top:40px;">
                                    <span class="step"></span>
                                    <span class="step"></span>
                                    <span class="step"></span>

                                </div>

                            </form>

                        </div>

                    </div>
                </div>
            </div>
        <?php else : ?>
            <h1 class="text-center my-5">Δεν έχετε προιόντα στο καλάθι</h1>
        <?php endif; ?>
    </main>
    <?php if (isset($_SESSION["userID"])) {
        echo "<script>let currentTab=1; let loggedin=true;</script>";
    } else {
        echo "<script>let currentTab=0; let loggedin=false;</script>";
    }
    ?>
    <script src="../utils/checkout.js"></script>
</body>
<?php require_once("partials/footer.php"); ?>