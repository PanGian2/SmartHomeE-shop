<?php
session_start();
require_once '../models/cart.php';
require_once '../models/product.php';
require_once '../utils/flash_messages.php';
date_default_timezone_set("Europe/Athens");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formType = $_POST["formType"];
    if ($formType == "addCart") {
        $id = $_POST["id"];
        $qty = (int)$_POST["qty"];
        if (isset($_COOKIE["cart"])) {
            // if cart is set, unserialize it
            $c = unserialize($_COOKIE["cart"]);
        } else {
            // else create new cart
            $c = new Cart([]);
        }

        $p = new Product();
        $product = $p->getProductById($id);
        //Add product to cart providing the necessary info
        $c->add((string)$product->_id, $product['price'], $qty, $product["img"][0], $product["name"], $product["requiresInstallation"], $product["availability"]);
        //set cookie to end in 24 hours
        setcookie("cart", serialize($c), time() + (86400 * 1), "/");
        //update the quantity of the product
        $query = array(
            '$set' => array(
                "availability" => (int)$product["availability"] - $qty
            )
        );
        $p->updateProduct($id, $query);
        header("location: ../views/" . $_POST["source"]);
    } elseif ($formType == "removeFromCart") {
        $id = $_POST["id"];
        $p = new Product();
        $product = $p->getProductById($id);
        $c = unserialize($_COOKIE["cart"]);

        $query = array(
            '$set' => array(
                "availability" => (int)$product["availability"] + $c->items[$id]['qty']
            )
        );
        //remove product from cart
        $c->removeProduct((string)$id);
        //update the quantity of the product
        $p->updateProduct($id, $query);
        //set cookie to end in 24 hours
        setcookie("cart", serialize($c), time() + (86400 * 1), "/");
        header("location: ../views/cart.php");
    } elseif ($formType == "addKitCart") {
        $kit = $_POST["kit"];
        if (isset($_COOKIE["cart"])) {
            $c = unserialize($_COOKIE["cart"]);
        } else {
            $c = new Cart([]);
        }
        //add to cart the kit's products and update their quantity
        if ($kit == "kit1") {
            $arr = ["65de31fbfcd216b28d02fe54", "65de3170fcd216b28d02fe53", "65e08c077290e3b87906fd86"];
            $qty = [2, 2, 1];
            for ($i = 0; $i < 3; $i++) {
                $p = new Product();
                $product = $p->getProductById($arr[$i]);
                $c->add((string)$product->_id, $product['price'], $qty[$i], $product["img"][0], $product["name"], $product["requiresInstallation"], $product["availability"]);
                $query = array(
                    '$set' => array(
                        "availability" => (int)$product["availability"] - $qty[$i]
                    )
                );
                $p->updateProduct($arr[$i], $query);
            }
        } elseif ($kit == "kit2") {
            $arr = ["65de31fbfcd216b28d02fe54", "65e08caf7290e3b87906fd87", "65de2b80fcd216b28d02fe50"];
            $qty = [2, 1, 1];
            for ($i = 0; $i < 3; $i++) {
                $p = new Product();
                $product = $p->getProductById($arr[$i]);
                $c->add((string)$product->_id, $product['price'], $qty[$i], $product["img"][0], $product["name"], $product["requiresInstallation"], $product["availability"]);
                $query = array(
                    '$set' => array(
                        "availability" => (int)$product["availability"] - $qty[$i]
                    )
                );
                $p->updateProduct($arr[$i], $query);
            }
        } elseif ($kit == "kit3") {
            $arr = ["65e08de17290e3b87906fd89", "65de2e1bfcd216b28d02fe51", "65de2b80fcd216b28d02fe50"];
            $qty = [1, 1, 2];
            for ($i = 0; $i < 3; $i++) {
                $p = new Product();
                $product = $p->getProductById($arr[$i]);
                $c->add((string)$product->_id, $product['price'], $qty[$i], $product["img"][0], $product["name"], $product["requiresInstallation"], $product["availability"]);
                $query = array(
                    '$set' => array(
                        "availability" => (int)$product["availability"] - $qty[$i]
                    )
                );
                $p->updateProduct($arr[$i], $query);
            }
        }
        //set cookie to end in 24 hours
        setcookie("cart", serialize($c), time() + (86400 * 1), "/");

        header("location: ../views/home.php");
    }
}

if (isset($_GET["updateCart"])) {
    //update cart
    $json = $_GET["updateCart"];
    $data = json_decode($json, true);
    $p = new Product();
    $product = $p->getProductById($data["id"]);
    //based on the operatrion, increase or reduce the qty of the product by 1
    if ($_GET["op"] == "add") {
        $query = array(
            '$set' => array(
                "availability" => (int)$product["availability"] - 1
            )
        );
    } elseif ($_GET["op"] == "sub") {
        $query = array(
            '$set' => array(
                "availability" => (int)$product["availability"] + 1
            )
        );
    }

    $p->updateProduct($data["id"], $query);
    //update the cart
    $c = unserialize($_COOKIE["cart"]);
    $c->updateQty($data["id"], $data["qty"], $data["price"]);
    //set cookie to end in 24 hours
    setcookie("cart", serialize($c), time() + (86400 * 1), "/");
    echo print_r($c);
}
