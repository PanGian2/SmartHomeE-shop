<?php

use MongoDB\BSON\ObjectId;

require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/product.css">
<link rel="stylesheet" href="../../public/styles/stars.css">

</head>

<body style="margin-top: 9em;">
    <?php require_once("../../utils/flash_messages.php");
    require_once "../partials/navbar.php";
    require_once "../../models/review.php";
    require_once "../../models/order.php";
    ?>
    <main>
        <?php
        flash("updateError");
        flash("createSuccess");
        flash("createError");
        flash("deleteSuccess");
        flash("deleteError");
        $hasBoughtProduct = null;
        $product = [];
        if (isset($_GET["id"]) && strlen($_GET["id"]) == 24) {
            $id = $_GET["id"];
            $p = new Product();
            $product = $p->getProductById($id);
            $source = substr($_SERVER["PHP_SELF"], 21) . "?id=" . $id;
            $inFavorites = false;
            if (isset($_SESSION["userID"])) {
                $u = new User();
                $user = $u->getUserById($_SESSION["userID"]);
                $favs = $user["favorites"]->getArrayCopy();
                $inFavorites = in_array($id, $favs);
                $o = new Order();
                $orders = $o->getOrdersByUserId($_SESSION["userID"]);
                $hasBoughtProduct = $o->userHasBoughtProduct($_SESSION["userID"], $id);
            }
            $r = new Review();
        }

        ?>
        <?php if (!$product) : ?>
            <h1 class="text-center my-5">Φαίνεται πως δεν υπάρχει αυτό το προϊόν</h1>
        <?php else : ?>
            <section class="container mb-5">
                <div class="alert alert-warning" id="favoritesAlert" style="display: none;">
                    Πρέπει πρώτα να συνδεθείτε για να προσθέσετε αυτό το προϊον στα αγαπημένα σας!
                </div>

                <div class="row ps-0 gx-2 gy-3">

                    <!-- Στήλη με εικόνες προϊόντος -->
                    <div class="col-lg-6 ps-0">
                        <div class="row">
                            <div class="col-lg-2 text-end d-none d-lg-block" id="other_photos">
                                <?php
                                foreach ($product["img"] as $key => $value) {
                                    $img = '"' . $value . '"';
                                    echo "<img src=", $value, " alt='Product Photo' onclick='changeImage(", $img, ")' class='img-fluid mb-2'>";
                                }
                                ?>
                            </div>
                            <div class="col-12 col-lg-10" id="main_photo">
                                <div id="mobilePhotoSlider" class="carousel slide d-block d-lg-none" data-bs-theme="dark">
                                    <div class="carousel-indicators">
                                        <button type="button" data-bs-target="#mobilePhotoSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                        <button type="button" data-bs-target="#mobilePhotoSlider" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                        <button type="button" data-bs-target="#mobilePhotoSlider" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                    </div>
                                    <div class="carousel-inner">
                                        <?php
                                        foreach ($product["img"] as $key => $value) {
                                            echo "<div class='carousel-item", $key === 0 ? ' active' : '', "'>";
                                            echo "<img src='", $value, "' class='d-block w-100' alt='Product Photo'>";
                                            echo "</div>";
                                        }
                                        ?>
                                    </div>
                                    <button class="carousel-control-prev align-items-end mb-2" type="button" data-bs-target="#mobilePhotoSlider" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next align-items-end mb-2" type="button" data-bs-target="#mobilePhotoSlider" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                <img src="<?php echo $product["img"][0]; ?>" alt="Main Product Photo" id="mainImage" class="img-fluid d-none d-lg-block">
                            </div>
                        </div>
                    </div>



                    <div class="col-lg-6 ">
                        <!-- Στήλη με πληροφορίες προϊόντος -->
                        <div class="card mb-3" style="height: 100%;">
                            <div class="card-body mb-1">
                                <h1 class="card-title fs-4"><?php echo $product["name"]; ?></h1>
                                <div class="container ps-0">
                                    <div class="row d-flex align-itmes-center">
                                        <div class="col-10">
                                            <p class="card-subtitle text-muted fs-5"><?php echo $product["manufacturer"]; ?></p>
                                        </div>
                                        <div class="col-2">
                                            <?php if (isset($_SESSION["userID"]) && $inFavorites == true) : ?>
                                                <form action="../../controllers/users.php" id="addToFavorites" method="post">
                                                    <input type="hidden" name="formType" value="removeFromFavorites">
                                                    <input type="hidden" name="source" value="<?php echo $source ?>">
                                                    <input type="hidden" name="productId" value="<?php echo $id ?>">
                                                    <input type="hidden" id="userId" name="userId" value="<?php echo isset($_SESSION["userID"]) ? $_SESSION["userID"] : "" ?>">
                                                    <button type="submit" id="heartButton" class="btn px-0 py-0" aria-label="Reduce product from favorites">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16" style="color: rgb(220, 0, 0);">
                                                            <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php else : ?>
                                                <form action="../../controllers/users.php" id="addToFavorites" method="post">
                                                    <input type="hidden" name="formType" value="addFavorites">
                                                    <input type="hidden" name="source" value="<?php echo $source ?>">
                                                    <input type="hidden" name="productId" value="<?php echo $id ?>">
                                                    <input type="hidden" id="userId" name="userId" value="<?php echo isset($_SESSION["userID"]) ? $_SESSION["userID"] : "" ?>">
                                                    <button type="submit" id="heartButton" class="btn px-0 py-0" aria-label="Add product to favorites">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>


                            </div>

                            <ul class="list-group list-group-flush mb-3" style="border-bottom: none;">
                                <li class="list-group-item">Χρώμα: <strong><?php echo $product["color"] ?></strong></li>
                                <li class="list-group-item text">Συμβατότητα:
                                    <?php
                                    if (count($product["compatibility"]) == 0) {
                                        echo "Δεν είναι συμβατό με smart home assistants.";
                                    } else {
                                        foreach ($product["compatibility"] as $key => $p) {
                                            echo $key == count($product["compatibility"]) - 1 ? '<strong>' . $p . '</strong>' : '<strong>' . $p . '</strong> | ';
                                        }
                                    }
                                    ?></li>
                                <?php
                                if ($product["requiresInstallation"] == true) {
                                    echo '<li class="list-group-item">Απαιτεί εγκατάσταση</li>';
                                }
                                ?>
                                <li class="list-group-item">Τιμή: <strong><?php echo $product["price"] ?>€</strong></li>
                                <li class="list-group-item">
                                    <?php
                                    if ($product["availability"] > 0) {
                                        echo '<div id="availability">Διαθέσιμο για Αποστολή</div>';
                                    } else {
                                        echo '<div id="availability">Διαθέσιμο Κατόπιν Παραγγελίας</div>';
                                    }
                                    ?>
                                </li>
                            </ul>

                            <div class="card-body">
                                <form class="quantity" action="../../controllers/cart.php" method="post">
                                    <input type="hidden" name="formType" value="addCart">
                                    <input type="hidden" name="source" value="<?php echo $source ?>">
                                    <input type="hidden" name="id" value="<?php echo $product["_id"] ?>">
                                    <div class="row">
                                        <div class="col-lg-6 justify-content-center text-center align-items-center d-flex d-lg-block">
                                            <div class="input-group mb-3">
                                                <button class="btn btn-secondary mx-0 minus-btn" type="button" name="button" aria-label="Reduce quantity by 1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                        <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                    </svg>
                                                </button>
                                                <input type="number" class="form-control" id="input" name="qty" value="1" max="<?php echo $product["availability"] ?>" readonly aria-label="Quantity">
                                                <button class="btn btn-secondary plus-btn me-2" type="button" name="button" aria-label="Increase quantity by 1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 text-lg-end text-center">
                                            <button class="btn btn-primary px-2" type="submit" id="add-cart" <?php echo $product["availability"] > 0 ? "" : "disabled"; ?>>Προσθήκη στο καλάθι</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>



            <section id="info mt-5" class="container">
                <div class="row" style="background-color: white;">
                    <div class="col text-center">
                        <h2 class="mb-3">Περιγραφή</h2>
                        <hr>
                        <p><?php echo $product["description"] ?></p>
                    </div>

                </div>
            </section>

            <section id="ratings" class="container my-3">
                <?php if (isset($_SESSION["userID"]) && $hasBoughtProduct != null) : ?>
                    <h2>Αξιολόγησε το προϊόν</h2>
                    <form action="../../controllers/review.php" method="POST" class="mb-3">
                        <input type="hidden" name="formType" value="createReview">
                        <input type="hidden" name="userId" value="<?php echo $_SESSION["userID"] ?>">
                        <input type="hidden" name="productId" value="<?php echo $id ?>">
                        <div class="mb-1 mt-3">
                            <fieldset class="starability-grow">
                                <input type="radio" id="no-rate" class="input-no-rate" name="rating" value="1" checked aria-label="No rating." />
                                <input type="radio" id="first-rate1" name="rating" value="1" />
                                <label for="first-rate1" title="Χάλια">1 star</label>
                                <input type="radio" id="first-rate2" name="rating" value="2" />
                                <label for="first-rate2" title="Κακό">2 stars</label>
                                <input type="radio" id="first-rate3" name="rating" value="3" />
                                <label for="first-rate3" title="Μέτριο">3 stars</label>
                                <input type="radio" id="first-rate4" name="rating" value="4" />
                                <label for="first-rate4" title="Καλό">4 stars</label>
                                <input type="radio" id="first-rate5" name="rating" value="5" />
                                <label for="first-rate5" title="Τέλειο">5 stars</label>
                            </fieldset>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="body">Κείμενο Αξιολόγησης</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="3" required></textarea>
                        </div>
                        <button class="btn btn-success" type="submit">Υποβολή</button>
                    </form>
                <?php endif; ?>
                <h2 class="text-center">Αξιολογήσεις</h2>
                <?php if (count($product["reviews"]) > 0) : ?>
                    <?php foreach ($product["reviews"] as $rev) : ?>
                        <?php $review = $r->getReviewsById($rev)[0]; ?>

                        <div class="card mb-3">

                            <div class="card-body">
                                <h3 class="card-title fs-5"><?php echo $review["user"]["name"] ?></h5>
                                    <p class="starability-result" data-rating="<?php echo $review["rating"] ?>">
                                        Έδωσε: <?php echo (int)$review["rating"] ?> αστέρια
                                    </p>
                                    <p class="card-text">Αξιολόγηση: <?php echo $review["body"] ?></p>
                                    <?php if (isset($_SESSION["userID"]) && $review["author"] == $_SESSION["userID"]) : ?>
                                        <form action="../../controllers/review.php" method="POST">
                                            <input type="hidden" name="formType" value="deleteReview">
                                            <input type="hidden" name="reviewId" value="<?php echo $review["_id"] ?>">
                                            <input type="hidden" name="productId" value="<?php echo $id ?>">
                                            <button class="btn btn-sm btn-danger">Διαγραφή</button>
                                        </form>
                                    <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <h3 class="text-center mt-3">Δεν υπάρχουν αξιολογήσεις για αυτό το προϊόν</h3>
                <?php endif; ?>
                </div>
            </section>
        <?php endif; ?>
    </main>
    <?php require_once("../partials/footer.php"); ?>
    <script src="../../utils/changeImage.js"></script>
    <script src="../../utils/amount-input.js"></script>
    <script>
        const form = document.getElementById("addToFavorites");
        form.addEventListener("submit", event => {
            const user = document.getElementById("userId").value;
            const alert = document.getElementById("favoritesAlert");
            if (!user) {
                event.preventDefault();
                event.stopPropagation();
                alert.style.display = ""
            }
        })
    </script>
</body>