<?php require_once("../partials/boilerplate.php"); ?>
<link rel="stylesheet" href="../../public/styles/cart.css">
<link rel="stylesheet" href="../../public/styles/productLink.css">
</head>

<body style="margin-top: 10em;">
    <?php require("../../utils/flash_messages.php");
    require_once('../../utils/authenticateUser.php');
    require_once "../partials/navbar.php";
    require_once("../../models/order.php");
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        $o = new Order();
        $order = $o->getOrderById($id);
        $source = "order-details.php?id=" . $id;
    }
    flash("updateSuccess");
    flash("updateError");
    ?>
    <main>
        <section class="container my-3">
            <h1 class="text-center mb-4">Πληροφορίες Παραγγελίας</h1>
            <?php if ($order["cart"]["items"]) : ?>
                <h2>Προϊόντα Παραγγελίας</h2>
                <ul class="list-group">
                    <?php foreach ($order["cart"]["items"] as $product) : ?>
                        <li class="list-group-item mb-1">
                            <div class="row align-items-center gy-5">
                                <div class="col-lg-2 col-4">
                                    <a href="../products/product.php?id=<?php echo $product["id"] ?>" class="product_img">
                                        <img src="<?php echo $product['img'] ?>" class="img-thumbnail w-lg-75 w-100" alt="Product Image">
                                    </a>
                                </div>
                                <div class="col-lg-10 col-8">
                                    <div class="row align-items-center gy-2 main-row">
                                        <div class="col-12 col-lg-8">
                                            <a href="../products/product.php?id=<?php echo $product["id"] ?>" class="product_link">
                                                <strong><?php echo $product['name'] ?></strong>
                                            </a>
                                        </div>
                                        <div class="col-lg-2 col-5">
                                            <span>x<?php echo $product['qty'] ?></span>
                                        </div>
                                        <div class="col-lg-2 col-7 text-lg-center text-end pe-3">
                                            <strong class="fs-5 text-end"><span class="totalPrice"><?php echo $product['totalPrice'] ?></span> €</strong>
                                        </div>
                                    </div>
                                    <?php if ($order["status"] == "Completed" && !isset($product["returned"])) :
                                    ?>
                                        <div class="row d-flex mt-4 me-2 justify-content-end text-end">
                                            <form action="../../controllers/order.php" method="post">
                                                <input type="hidden" name="formType" value="returnProduct">
                                                <input type="hidden" name="productId" value="<?php echo $product["id"] ?>">
                                                <input type="hidden" name="orderId" value="<?php echo $id ?>">
                                                <button class=" btn btn-warning" type="submit" style="width: fit-content;">Επιστροφή προϊόντος</button>
                                            </form>
                                        </div>
                                    <?php endif;
                                    ?>
                                    <?php if (isset($product["returned"]) && $product["returned"] == true) : ?>
                                        <div class="row d-flex mt-4 me-2 text-end">
                                            <strong class="fs-5" style="color: #0077b6;">Επιστράφηκε</strong>
                                        </div>
                                    <?php endif; ?>
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
                    date_default_timezone_set("Europe/Athens");
                    $time = date("d-m-Y H:i", strtotime("+24 hours", strtotime($order["dateTimeOrdered"])));
                    //If the booking status is Reserved and today is passed the booking day or today is the day of the booking and the hour is passed the booking
                    //disable the cancellation button
                    if ($order["status"] == 'Reserved' && $order["dateTimeOrdered"] < $time) : ?>

                        <form action='../../controllers/order.php' method='POST'>
                            <button class='btn btn-danger' type='submit'>Ακύρωση Παραγγελίας</button>
                            <input type='hidden' name='formType' value='cancelOrder'>
                            <input type='hidden' name='source' value='<?php echo $source; ?>'>
                            <input type='hidden' name='orderid' value='<?php echo $order["_id"] ?>'>
                        </form>

                    <?php endif; ?>
                </div>
            <?php else : ?>
                <h1 class="my-5 text-center">Δεν υπάρχουν αντικείμενα σε αυτήν την παραγγελία!</h1>
            <?php endif; ?>
            <div class="container text-center">
                <a href="../users/user-profile.php" class="btn btn-success my-4">Επιστροφή στo προφίλ</a>
            </div>
        </section>
    </main>
</body>
<?php require_once("../partials/footer.php"); ?>