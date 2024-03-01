<?php require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/productLink.css">
</head>

<body>
    <?php require_once("../../utils/flash_messages.php");
    require_once('../../utils/authenticateAdmin.php');
    require_once "../partials/admin_navbar.php";
    require_once("../../models/order.php");

    ?>
    <?php

    //Get id from the url
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $o = new Order();
        $order = $o->getOrderById($id);
        $source = "show.php?id=" . $id;
    }

    flash("updateSuccess");
    flash("updateError");

    flash("createSuccess");
    flash("createError");
    ?>
    <main>
        <section class="container my-3">
            <h1 class="text-center mb-4">Πληροφορίες Παραγγελίας</h1>
            <?php if ($order["cart"]["items"]) : ?>
                <ul class="list-group">
                    <h2>Προϊόντα Παραγγελίας</h2>
                    <?php foreach ($order["cart"]["items"] as $product) : ?>
                        <li class="list-group-item">
                            <div class="row align-items-center gy-5">
                                <div class="col-lg-2 col-4">
                                    <a class="product_img" href="../products/show.php?id=<?php echo $product["id"] ?>">
                                        <img src="<?php echo $product['img'] ?>" class="img-thumbnail w-lg-75 w-100" alt="Product Image">
                                    </a>
                                </div>
                                <div class="col-lg-10 col-8">
                                    <div class="row align-items-center gy-2 main-row">
                                        <div class="col-12 col-lg-8">
                                            <a class="product_link" href="../products/show.php?id=<?php echo $product["id"] ?>">
                                                <strong><?php echo $product['name'] ?></strong>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-5">
                                            <span>x<?php echo $product['qty'] ?></span>
                                        </div>
                                        <div class="col-lg-2 col-7 text-lg-center text-end pe-3">
                                            <strong class="fs-5 text-end"><span class="totalPrice"><?php echo $product['totalPrice'] ?></span> €</strong>
                                        </div>
                                        <?php if (isset($product["returned"]) && $product["returned"] == true) : ?>
                                            <div class="row d-flex mt-4 me-2 text-end">
                                                <strong class="fs-5" style="color: #0077b6;">Επιστράφηκε</strong>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                </div>
                            </div>

                        </li>
                    <?php endforeach; ?>
                </ul>

                <div class="row mt-3 align-items-center gx-3 gy-3">
                    <h2 class="mb-3">Στοιχεία Παραγγελίας</h2>
                    <div class=" col-md-4">
                        <strong class="fs-5">Σύνολο Παραγγελίας: <span id="cartTotalPrice"><?php echo $order["cart"]["totalPrice"] ?></span> €</strong>
                    </div>
                    <div class="col-md-4 ">
                        <?php if (isset($order["user"]["userId"])) : ?>
                            <a id="product_link" href="../users/show.php?id=<?php echo $order["user"]["userId"] ?>" style="color:rgb(56, 56, 56)">
                                Ονοματεπώνυμο: <strong><?php echo $order["user"]["name"]; ?> <?php echo $order["user"]["surname"]; ?></strong>
                            </a><br>
                        <?php else : ?>
                            Ονοματεπώνυμο: <strong><?php echo $order["user"]["name"]; ?> <?php echo $order["user"]["surname"]; ?></strong><br>
                        <?php endif; ?>
                        Ημερομηνία Παραγγελίας: <strong><?php echo $order["dateTimeOrdered"]; ?></strong><br>
                        Διεύθυνση Χρέωσης: <strong><?php echo $order["user"]["address"], ", ", $order["user"]["postalCode"]; ?></strong>
                    </div>
                    <div class="col-md-4">
                        Κατάσταση: <strong><?php echo $order["status"]; ?></strong>
                    </div>
                </div>
                <hr>
                <div class="row mb-3">
                    <?php
                    if ($order["status"] == 'Reserved') : ?>

                        <form action='../../controllers/order.php' method='POST'>
                            <button class='btn btn-danger' type='submit'>Ακύρωση Παραγγελίας</button>
                            <input type='hidden' name='formType' value='cancelOrder'>
                            <input type='hidden' name='source' value='<?php echo $source ?>'>
                            <input type='hidden' name='orderid' value='<?php echo $order["_id"] ?>'>
                        </form>

                    <?php endif; ?>
                </div>
            <?php else : ?>
                <h1 class="my-5 text-center">Δεν υπάρχουν αντικείμενα σε αυτήν την παραγγελία!</h1>
            <?php endif; ?>
            <div class="container text-center">
                <a href="index.php" class="btn btn-success my-4">Επιστροφή στη Διαχείριση Παραγγελιών</a>
            </div>
        </section>
    </main>
    <script src="../utils/updateCart.js"></script>
</body>

</html>