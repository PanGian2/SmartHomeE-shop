<?php require_once("partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../public/styles/cart.css">
<link rel="stylesheet" href="../public/styles/productLink.css">
</head>

<body style="margin-top: 10em;">
    <?php require_once("../utils/flash_messages.php");
    require_once('../utils/authenticateUser.php');
    require_once "partials/navbar.php";
    if (isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] == true) {
        $id = $_SESSION["userID"];
        $u = new User();
        $user = $u->getUserById($id);
        $p = new Product();
        $pid = $user["favorites"];
        $source = substr($_SERVER["PHP_SELF"], 21);
    }
    flash("updateSuccess");
    flash("updateError");
    ?>
    <main>
        <section class="container my-3">
            <?php if (count($user["favorites"]) > 0) : ?>
                <ul class="list-group">
                    <?php foreach ($user["favorites"] as $favorite) :
                        $product = $p->getProductById($favorite);
                    ?>
                        <li class="list-group-item mb-2">
                            <div class="row align-items-center">
                                <div class="col-lg-2 col-4">
                                    <a href="products/product.php?id=<?php echo $product["_id"] ?>" class="product_img">
                                        <img src="<?php echo $product['img'][0] ?>" class="img-thumbnail w-lg-75 w-100" alt="Product Image">
                                    </a>
                                </div>
                                <div class="col-lg-10 col-8">
                                    <div class="row align-items-center gy-2 mb-3 main-row">
                                        <div class="col-12 col-lg-7">
                                            <a href="products/product.php?id=<?php echo $product["_id"] ?>" class="product_link"><strong><?php echo $product['name'] ?></strong></a>
                                        </div>
                                        <div class="col-lg-3 col-sm-8 col-12 amount-div">
                                            <input type="hidden" class="price" name="price" value="<?php echo $product['price'] ?>">
                                            <div class="row">
                                                <div class="col-lg-10 col-8">
                                                    <form class="quantity" action="../controllers/cart.php" method="post">
                                                        <input type="hidden" name="formType" value="addCart">
                                                        <input type="hidden" name="id" value="<?php echo $product["_id"] ?>">
                                                        <input type="hidden" name="source" value="<?php echo $source ?>">
                                                        <div class="input-group">
                                                            <button class="btn btn-secondary minus-btn " type="button" name="button">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-dash" viewBox="0 0 16 16">
                                                                    <path d="M4 8a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7A.5.5 0 0 1 4 8" />
                                                                </svg>
                                                            </button>
                                                            <input type="number" class="amount form-control text-center" name="qty" value="1" max="<?php echo $product["availability"] ?>" readonly>
                                                            <button class="btn btn-secondary plus-btn" type="button" name="button">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
                                                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4" />
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="col-lg-2 col-4">
                                                    <form action="../controllers/users.php" method="post">
                                                        <input type="hidden" name="formType" value="removeFromFavorites">
                                                        <input type="hidden" class="id" name="productId" value="<?php echo $product['_id'] ?>">
                                                        <input type="hidden" class="id" name="userId" value="<?php echo $id ?>">
                                                        <input type="hidden" name="source" value="<?php echo $source ?>">
                                                        <button class="btn" type="submit">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16" style="color: rgb(220, 0, 0);">
                                                                <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-sm-4 col-12 text-lg-center text-end pe-3">
                                            <strong class="fs-5 text-end"><span class="totalPrice"><?php echo $product['price'] ?></span> €</strong>
                                        </div>

                                    </div>
                                    <div class="row d-flex mt-5 me-2 justify-content-end">
                                        <button class="btn btn-primary" style="width: fit-content;" onclick="submitForm(this)" <?php echo $product["availability"] > 0 ? "" : "disabled"; ?>>Προσθήκη στο καλάθι</button>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php else : ?>
                <h1 class="my-5 text-center">Δεν υπάρχουν αντικείμενα στο καλάθι!</h1>
            <?php endif; ?>
        </section>
    </main>
    <script src="../utils/amount-input.js"></script>
    <script>
        function submitForm(btn) {
            console.log(btn.closest('.col-lg-10'));
            const form = btn.closest('.col-lg-10').querySelector('.quantity')

            form.submit();
        }
    </script>
</body>
<?php require_once("partials/footer.php"); ?>