<?php
session_start();
require_once '../models/cart.php';
require_once '../models/order.php';
require_once '../models/product.php';
require_once '../utils/flash_messages.php';
date_default_timezone_set("Europe/Athens");
$o = new Order();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formType = $_POST["formType"];
    if ($formType == "createOrder") {
        $cart = unserialize($_COOKIE["cart"]);
        $status = "Reserved";
        $dateTimeOrdered = date("d-m-Y H:i");
        //suppose that the order will have been shipped in 5 days
        $deliveryDate = date("d-m-Y", strtotime("+5 days"));
        //if the order was made by a regular customer save it's id
        if (isset($_POST["regularCustomer"])) {
            $userId = $_POST["regularCustomer"];
            $Order = array(
                "user" => array(
                    "userId" => $userId,
                    "email" => $_POST["email"],
                    "name" => $_POST["name"],
                    "surname" => $_POST["last_name"],
                    "phone" => $_POST["tel"],
                    "city" => $_POST["city"],
                    "address" => $_POST["address"],
                    "postalCode" => $_POST["postalCode"],
                ),
                "cart" => $cart,
                "status" => $status,
                "dateTimeOrdered" => $dateTimeOrdered,
                "deliveryDate" => $deliveryDate
            );
        } else {
            $Order = array(
                "user" => array(
                    "email" => $_POST["email"],
                    "name" => $_POST["name"],
                    "surname" => $_POST["last_name"],
                    "phone" => $_POST["tel"],
                    "city" => $_POST["city"],
                    "address" => $_POST["address"],
                    "postalCode" => $_POST["postalCode"],
                ),
                "cart" => $cart,
                "status" => $status,
                "dateTimeOrdered" => $dateTimeOrdered,
                "deliveryDate" => $deliveryDate
            );
        }

        //add order to db
        $result = $o->addOrder($Order);
        if ($result != null) {
            flash("orderSuccess", "H παραγγελία σας έγινε με επιτυχία!", FLASH_SUCCESS);
            //erase the cart
            setcookie("cart", "", time() - 3600, "/");
            header("location: ../views/home.php");
        }
    } elseif ($formType == "cancelOrder") {
        $id = $_POST["orderid"];
        $query = array(
            '$set' => array(
                "status" => "Cancelled"
            )
        );
        //update order's status to cancelled
        $result = $o->updateOrder($id, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/orders/" . $_POST["source"]);
        } else {
            //update the product's quantity
            $p = new Product();
            foreach ($order["cart"]["items"] as $items) {
                //update only those products that haven't already been returned
                if (!isset($items["returned"])) {
                    $product = $p->getProductById($items["id"]);
                    $query = array(
                        '$set' => array(
                            "availability" => $product["avaiability"] + $items["qty"]
                        )
                    );
                    $p->updateProduct($items["id"], $query);
                }
            }
            flash("updateSuccess", "H παραγγελία ακυρώθηκε με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/orders/" . $_POST["source"]);
        }
    } elseif ($formType == "returnProduct") {
        $orderId = $_POST["orderId"];
        $productId = $_POST["productId"];
        //add the returned field and set it to true
        $query = array(
            '$set' => array(
                "cart.items." . $productId . ".returned" => true
            )
        );
        $order = $o->getOrderById($orderId);
        $result = $o->updateOrder($orderId, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/orders/order-details.php?id=" . $orderId);
        } else {
            //update the quantity of the product
            $p = new Product();
            $product = $p->getProductById($productId);
            $query = array(
                '$set' => array(
                    "availability" => $product["avaiability"] + $order["cart"]["items"][$product]["qty"]
                )
            );
            $p->updateProduct($productId, $query);
            flash("updateSuccess", "Το αίτημα σας καταχωρήθηκε με επιτυχία!. Σας έχουμε στείλει ένα email σχετικά με τις οδηγίες επιστροφής", FLASH_SUCCESS);
            header("location: ../views/orders/order-details.php?id=" . $orderId);
        }
    }
}
