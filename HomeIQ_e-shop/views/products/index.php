<?php require_once("../partials/boilerplate.php"); ?>
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php"; ?>
    <?php
    $p = new Product();
    $products = $p->getProducts();

    //Depending on the occasion, display the appropriate flash messages on top of the page
    flash("deleteSuccess");
    flash("deleteError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>
        <section class="container mt-5">
            <h1 class="text-center mb-4">Όλα τα Προϊόντα</h1>
            <div>
                <a href="new.php" class="btn btn-success my-3">Προσθήκη Προϊόντος</a>
            </div>
            <?php if ($products == null) : ?>
                <h2 class='text-center'>Δεν υπάρχουν προϊόντα!</h2>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <div class='card mb-5'>
                        <div class='row align-items-center'>
                            <div class=' col-lg-4 col-md-12 text-center'>
                                <img src="<?php echo $product->img["0"] ?> " alt='' class='img-fluid w-75'>
                            </div>
                            <div class='col-lg-8 col-md-12'>
                                <div class='card-body'>
                                    <h2 class='card-title fs-4'><?php echo $product->name ?></h2>
                                    <h3 class="cart-subtitle fs-5"><?php echo $product->manufacturer ?></h3>
                                    <p class="cart-text"><small class="text-muted">Κατηγορία: <?php echo $product->category ?></small></p>
                                    <p class="cart-text">Τιμή: <?php echo $product->price ?>€</p>
                                    <a href='show.php?id=<?php echo $product->_id ?>' class='btn btn-primary'>View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>

    </main>
</body>

</html>