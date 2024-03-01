<?php require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/product_list.css">
<link rel="stylesheet" href="../../public/styles/productLink.css">

</head>

<body style="margin-top: 9em;">
    <?php require_once "../partials/navbar.php";
    // require("../../models/product.php");
    $list = [];
    if (isset($_GET["subcategory"])) {
        $category = $_GET["subcategory"];
        $p = new Product();
        $list = $p->getProductsBySubcategory($category);
        $source = substr($_SERVER["PHP_SELF"], 21) . "?subcategory=" . $category;
    } else if (isset($_GET["name"])) {
        $name = $_GET["name"];
        $p = new Product();
        $list = $p->getProductsByName($name);
        $source = substr($_SERVER["PHP_SELF"], 21) . "?name=" . $name;
    } else if (isset($_GET["category"])) {
        $category = $_GET["category"];
        $p = new Product();
        $list = $p->getProductsByCategory($category);
        $source = substr($_SERVER["PHP_SELF"], 21) . "?category=" . $category;
    } else if (isset($_GET["manufacturer"])) {
        $manufacturer = $_GET["manufacturer"];
        $p = new Product();
        $list = $p->getProductsByManufacturer($manufacturer);
        $source = substr($_SERVER["PHP_SELF"], 21) . "?manufacturer=" . $manufacturer;
    } else {
        $p = new Product();
        $list = $p->getProducts();
        $source = substr($_SERVER["PHP_SELF"], 21);
    }
    $json = [];
    ?>
    <main>
        <div class="container">
            <div class="row">
                <h1 class="text-center mb-4">Προβολή Προϊόντων</h1>
                <div class="col-md-3 filters-container">
                    <h2>Φίλτρα</h2>
                    <div class="dropdown my-3">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#availability" aria-expanded="false" aria-controls="availability">
                            Διαθεσιμότητα για αποστολή
                        </button>
                        <div class="collapse my-2" id="availability">
                            <form>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="available" id="availableForShipping">
                                    <label class="form-check-label" for="availableForShipping">
                                        Διαθέσιμο για αποστολή
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="available" id="orderOnly">
                                    <label class="form-check-label" for="orderOnly">
                                        Κατόπιν Παραγγελίας
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown my-3">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#priceRange" aria-expanded="false" aria-controls="priceRange">
                            Τιμή
                        </button>
                        <div class="collapse my-2" id="priceRange">
                            <form>
                                <label for="price1" class="form-label">Αρχική τιμή</label>
                                <input type="range" class="form-range" min="0" max="100" step="10" id="price1">
                                <div id="chosenPrice1" class="text-center my-2"></div>
                                <label for="price2" class="form-label">Tελική τιμή</label>
                                <input type="range" class="form-range" min="0" max="100" step="10" id="price2">
                                <div id="chosenPrice2" class="text-center"></div>
                            </form>
                        </div>
                    </div>
                    <div class="dropdown my-3">
                        <button class="btn btn-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#color" aria-expanded="false" aria-controls="color">
                            Θερμοκρασία Χρώματος
                        </button>
                        <div class="collapse my-2" id="color">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lColor" id="warm">
                                <label class="form-check-label" for="warm">
                                    Θερμό
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lColor" id="neutral">
                                <label class="form-check-label" for="neutral">
                                    Ουδέτερο
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="lColor" id="cold">
                                <label class="form-check-label" for="cold">
                                    Ψυχρό
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- Προσθέστε περισσότερα φίλτρα ανάλογα με τις ανάγκες σας -->
                </div>
                <div class="col-md-9">
                    <h2 class="mb-4">Προιόντα</h2>
                    <div class="row align-items-center">
                        <div class="col-md-4 product-stats">
                            <p>Συνολικά Προϊόντα: <span id="totalProducts"><?php echo count($list) ?></span></p>
                        </div>

                        <!-- Σελίδα -->
                        <div class="col-md-4 product-stats">
                            <p>Σελίδα: <span id="currentPage">1</span></p>
                        </div>

                        <!-- Κουμπί ταξινόμησης -->
                        <div class="col-md-4">
                            <select class="form-select" id="sortFilter" onchange="sortProducts()" aria-label="Order by">
                                <option value="bestSellers" selected>Best Sellers</option>
                                <option value="ascending">Τιμή Αύξουσα</option>
                                <option value="descending">Τιμή Φθίνουσα</option>
                            </select>
                        </div>
                    </div>

                    <div class="row gy-1 mb-3" id="productRow">
                        <?php foreach ($list as $l) :
                            $rating = $p->getProductsAvgRating($l["_id"]);
                            $json[] = $rating
                        ?>
                            <div class="col-lg-4 col-md-6">
                                <div class="card product-card">
                                    <a href="product.php?id=<?php echo $l["_id"] ?>" class="product_img">
                                        <img src="<?php echo $l["img"][0] ?>" class="card-img-top mt-1" alt="Εξυπνη Λαμπα LED 1">
                                    </a>
                                    <div class="card-body">
                                        <h3 class="card-title fs-5">
                                            <a href="product.php?id=<?php echo $l["_id"] ?>" class="product_link">
                                                <?php echo $l["name"] ?>
                                            </a>
                                        </h3>
                                        <p class="card-text font-weight-bold">Τιμή: <span class="price"><?php echo $l["price"] ?>€</span></p>
                                        <?php if ($l["availability"] > 0) : ?>
                                            <form class="quantity d-flex align-self-center mt-5" action="../../controllers/cart.php" method="post">
                                                <input type="hidden" name="formType" value="addCart">
                                                <input type="hidden" name="source" value="<?php echo $source ?>">
                                                <input type="hidden" name="subcategory" value="<?php echo $category ?>">
                                                <input type="hidden" class="pid" name="id" value="<?php echo $l["_id"] ?>">
                                                <input type="hidden" name="qty" value="1">
                                                <button class="btn btn-primary">Προσθήκη στο Καλάθι</button>
                                            </form>
                                        <?php else : ?>
                                            <div id="availability">Διαθέσιμο Κατόπιν Παραγγελίας</div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>


        </section>
    </main>
    <?php require_once("../partials/footer.php"); ?>
    <script>
        let products = <?php echo json_encode($json) ?>;

        function getProductAverageRating(productId) {
            let rating = 0;

            var nonEmptyRatings = products.filter(ratings => ratings.length > 0);
            // Αν το μέσο όρος αξιολόγησης δεν είναι διαθέσιμος, επιστρέφουμε NaN
            // console.log(nonEmptyRatings)
            let item = nonEmptyRatings.find(element => element[0]._id.$oid === productId);

            if (item) {
                rating = item[0].averageRating;
            }
            return rating; // Επιστρέφει τον μέσο όρο των κριτικών ή 0 αν δεν υπάρχουν αξιολογήσεις
        }
    </script>
    <script>
        function sortProducts() {
            var sortFilter = document.getElementById('sortFilter').value;
            var productRow = document.getElementById('productRow');
            var cards = productRow.querySelectorAll('.product-card');
            //var cards = productRow.getElementsByClassName('product-card');
            var cardsArray = Array.from(cards);

            if (sortFilter === 'bestSellers') {

                cardsArray.sort(function(a, b) {
                    var averageRatingA = getProductAverageRating(a.querySelector(".pid").value);
                    var averageRatingB = getProductAverageRating(b.querySelector(".pid").value);
                    return averageRatingB - averageRatingA;
                });

                cardsArray.forEach(function(card) {
                    productRow.appendChild(card.closest('.col-lg-4'));
                });

            } else if (sortFilter === 'ascending') {
                // Ταξινόμηση από τη χαμηλότερη τιμή στη υψηλότερη τιμή
                cardsArray.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price").innerText);
                    var priceB = parseFloat(b.querySelector(".price").innerText);
                    return priceA - priceB;
                });

                cardsArray.forEach(function(card) {
                    productRow.appendChild(card.closest('.col-lg-4'));
                });

            } else if (sortFilter === 'descending') {
                // Ταξινόμηση από τη υψηλότερη τιμή στη χαμηλότερη τιμή
                cardsArray.sort(function(a, b) {
                    var priceA = parseFloat(a.querySelector(".price").innerText);
                    var priceB = parseFloat(b.querySelector(".price").innerText);
                    return priceB - priceA;
                });

                cardsArray.forEach(function(card) {
                    productRow.appendChild(card.closest('.col-lg-4'));
                });
            }
        }
    </script>
</body>

</html>