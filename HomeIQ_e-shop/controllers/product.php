<?php
session_start();
require_once '../models/product.php';
require_once '../utils/flash_messages.php';
date_default_timezone_set("Europe/Athens");
$p = new Product();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formType = $_POST["formType"];
    if ($formType == "productCreate") {
        $Product = array(
            "name" => $_POST["name"],
            "description" => $_POST["description"],
            "manufacturer" =>  $_POST["manufacturer"],
            "price" =>  (float)$_POST["price"],
            "availability" =>  (int)$_POST["availability"],
            "color" =>  $_POST["color"],
            "img" =>  $_POST["img_url"],
            "ports" =>  $_POST["ports"] != '' ? $_POST["ports"] : null,
            "subcategory" =>  $_POST["subcategory"],
            "category" =>  $_POST["category"],
            "hasApp" =>  filter_var($_POST["hasApp"], FILTER_VALIDATE_BOOLEAN),
            "compatibility" =>  $_POST["compatibility"] != '' ? $_POST["compatibility"] : [],
            "requiresInstallation" =>  filter_var($_POST["requiresInstallation"], FILTER_VALIDATE_BOOLEAN),
            "reviews" => []
        );
        //add product to db
        $result = $p->addProduct($Product);
        if ($result != null) {
            flash("createSuccess", "Το προϊόν δημιουργήθηκε με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/products/index.php");
        } else {
            flash("createError", "Κάτι πήγε λάθος! Ξαναπροσπάθησε ξανά αργότερα", FLASH_ERROR);
            header("location: ../views/products/index.php");
        }
    } elseif ($formType == "productUpdate") {
        $id = $_POST["id"];
        $query = array(
            '$set' => array(
                "name" => $_POST["name"],
                "description" => $_POST["description"],
                "manufacturer" =>  $_POST["manufacturer"],
                "price" =>  (float)$_POST["price"],
                "availability" =>  (int)$_POST["availability"],
                "color" =>  $_POST["color"],
                "video" =>  $_POST["video"] != '' ? $_POST["video"] : null,
                "ports" =>  $_POST["ports"] != '' ? $_POST["ports"] : null,
                "subcategory" =>  $_POST["subcategory"],
                "category" =>  $_POST["category"],
                "hasApp" =>  filter_var($_POST["hasApp"], FILTER_VALIDATE_BOOLEAN),
                "compatibility" =>  $_POST["compatibility"] != '' ? $_POST["compatibility"] : [],
                "requiresInstallation" =>  filter_var($_POST["requiresInstallation"], FILTER_VALIDATE_BOOLEAN),
            )
        );
        //update product
        $result = $p->updateProduct($id, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/products/show.php?id=" . $id);
        } else {
            flash("updateSuccess", "Τα στοιχεία ενημερώθηκαν με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/products/show.php?id=" . $id);
        }
    } elseif ($formType == "deleteProduct") {
        $id = $_POST["id"];
        //delete product
        $result = $p->deleteProduct($id);
        if ($result == 0) {
            flash("deleteError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/products/index.php");
        } else {
            flash("deleteSuccess", "Το προϊόν διαγράφηκε με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/products/index.php");
        }
    }
}

if (isset($_GET["updateCart"])) {
    $json = $_GET["updateCart"];
    $data = json_decode($json, true);
    $c = unserialize($_COOKIE["cart"]);
    $c->updateQty($data["id"], $data["qty"], $data["price"]);
    setcookie("cart", serialize($c), time() + (86400 * 1), "/");
    echo print_r($c);
}
if (isset($_GET["getFilters"])) {
    //get json with product filters (used for search)
    $result = $p->getProductFilters();
    $json = json_encode($result);
    echo $json;
}
