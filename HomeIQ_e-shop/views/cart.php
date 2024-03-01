<?php require_once("partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../public/styles/cart.css">
<link rel="stylesheet" href="../public/styles/productLink.css">
</head>

<body style="margin-top: 10em;">
    <?php require_once "partials/navbar.php";
    if (isset($_COOKIE["cart"])) {
        $cart = unserialize($_COOKIE["cart"]); // Αποσειριοποίηση του καλαθιού
        $products = $cart->generateArray(); // Παραγωγή πίνακα αντικειμένων από το καλάθι
    } else {
        $products = [];
    }
    ?>
    <main>
        <section class="container my-3">
            <?php if (count($products) > 0 && $cart->totalPrice != 0) : ?>
                <ul class="list-group">
                    <?php foreach ($products as $product) : ?>
                        <li class="list-group-item mb-1">
                            <div class="row align-items-center gy-5">
                                <div class="col-lg-2 col-4">
                                    <a href="products/product.php?id=<?php echo $product["id"] ?>" class="product_img">
                                        <img src="<?php echo $product['img'] ?>" class="img-thumbnail w-lg-75 w-100" alt="Product Image">
                                    </a>
                                </div>
                                <div class="col-lg-10 col-8">
                                    <div class="row align-items-center gy-2 main-row">
                                        <div class="col-12 col-lg-7">
                                            <a href="products/product.php?id=<?php echo $product["id"] ?>" class="product_link">
                                                <strong><?php echo $product['name'] ?></strong>
                                            </a>
                                        </div>
                                        <div class="col-lg-3 col-sm-8 col-12 amount-div">
                                            <input type="hidden" class="price" name="price" value="<?php echo $product['price'] ?>">
                                            <div class="row">
                                                <div class="col-lg-10 col-8">
                                                    <div class="input-group">
                                                        <button class="btn btn-secondary minus-btn " type="button" name="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                                <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                            </svg>
                                                        </button>
                                                        <input type="number" class="amount form-control text-center" name="qty" value="<?php echo $product['qty'] ?>" max="<?php echo $product['availability'] ?>" readonly>
                                                        <button class="btn btn-secondary plus-btn" type="button" name="button">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2 col-4">
                                                    <form action="../controllers/cart.php" method="post">
                                                        <input type="hidden" name="formType" value="removeFromCart">
                                                        <input type="hidden" class="id" name="id" value="<?php echo $product['id'] ?>">
                                                        <button class="btn" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3" viewBox="0 0 16 16">
                                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-4 col-12 text-lg-center text-end pe-3">
                                            <strong class="fs-5 text-end"><span class="totalPrice"><?php echo $product['totalPrice'] ?></span> €</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="row mt-3 ">
                    <strong class="fs-4">Σύνολο: <span id="cartTotalPrice"><?php echo $cart->totalPrice ?></span> €</strong>
                </div>

                <hr>
                <div class="row mb-3">
                    <div>
                        <a href="checkout.php" type="button" class="btn btn-lg btn-success">Checkout</a>
                    </div>


                </div>
            <?php else : ?>
                <h1 class="my-5 text-center">Δεν υπάρχουν αντικείμενα στο καλάθι!</h1>
            <?php endif; ?>
        </section>
    </main>
    <script src="../utils/updateCart.js"></script>
</body>
<?php require_once("partials/footer.php"); ?>