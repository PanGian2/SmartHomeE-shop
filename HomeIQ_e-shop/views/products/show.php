<?php require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/showProduct.css">
<!-- <link rel="stylesheet" href="../../public/styles/product.css""> -->
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php"; ?>
    <?php

    //Get id from the url
    $productId = $_GET["id"];
    $p = new Product();
    $product = $p->getProductById($productId);

    //Depending on the occasion, display the appropriate flash messages on top of the page

    flash("updateSuccess");
    flash("updateError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>
        <div class="container-fluid ">
            <div id="productCarousel" class="carousel slide my-3" data-bs-theme="dark">
                <div class="carousel-inner">
                    <?php foreach ($product["img"] as $i => $img) : ?>
                        <div class="carousel-item <?php echo $i === 0 ? 'active' : '' ?>">
                            <img src="<?php echo $img ?>" class="d-block" alt="">
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php if (count($product["img"]) > 1) : ?>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                <?php endif; ?>
            </div>
            <div class="row justify-content-center">
                <div class="card mb-3 " style="width: 65%;">
                    <div class="row">
                        <div class="card-body ">
                            <h1 class="card-title text-center fs-2"><?php echo $product->name; ?></h1>
                            <h2 class="fs-3">Περιγραφή</h2>
                            <p class="card-text"><?php echo $product->description; ?></p>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item text-muted">Κατηγορία: <?php echo $product->category ?></li>
                            <li class="list-group-item text-muted">Υποκατηγορία: <?php echo $product->subcategory ?></li>
                            <li class="list-group-item text-muted">Κατασκευαστής: <?php echo $product->manufacturer ?></li>
                            <li class="list-group-item"><?php echo $product->price ?>€</li>
                            <li class="list-group-item text">Διαθεσιμότητα: <?php echo $product->availability ?> τεμάχια</li>
                            <li class="list-group-item text">Χρώμα: <?php echo $product->color != null ? $product->color : 'Δεν έχει'  ?></li>
                            <li class="list-group-item text">Συμβατότητα:
                                <?php
                                if (count($product["compatibility"]) == 0) {
                                    echo "Δεν είναι συμβατό με smart home assistants.";
                                } else {
                                    foreach ($product["compatibility"] as $key => $p) {
                                        echo $key == count($product["compatibility"]) - 1 ? '<strong>' . $p . '</strong>' : '<strong>' . $p . '</strong> | ';
                                    }
                                }
                                ?>
                            </li>
                            <?php
                            if ($product["ports"] != null) : ?>
                                <li class="list-group-item">Θύρες: <?php echo $product->ports ?></li>
                            <?php endif; ?>
                            <?php
                            if ($product["requiresInstallation"] == true) : ?>
                                <li class="list-group-item">Απαιτεί εγκατάσταση</li>
                            <?php else : ?>
                                <li class="list-group-item">Δεν απαιτεί εγκατάσταση</li>
                            <?php endif; ?>
                            <li class="list-group-item text">Έχει εφαρμογή: <?php echo $product->hasApp == true ? 'Ναι' : 'Όχι'  ?></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="text-center mb-5">
                <a class="btn btn-warning my-1" href="edit.php?id=<?php echo $productId; ?>">Edit</a>
                <form class="d-inline me-0" action="../../controllers/product.php" method="POST">
                    <input type='hidden' name='id' value='<?php echo $productId; ?>'>
                    <input type='hidden' name='formType' value='deleteProduct'>
                    <button class="btn btn-danger" type="submit">Delete</button>
                </form>
            </div>
            <div class="container text-center">
                <a href="index.php" class="btn btn-success my-4">Επιστροφή στην Διαχείριση Προγρμμάτων</a>
            </div>


    </main>
</body>

</html>