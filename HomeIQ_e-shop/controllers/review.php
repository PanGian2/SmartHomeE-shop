<?php

use MongoDB\BSON\ObjectId;

session_start();
require_once '../models/product.php';
require_once '../models/review.php';
require_once '../utils/flash_messages.php';
date_default_timezone_set("Europe/Athens");
$p = new Product();
$r = new Review();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formType = $_POST["formType"];
    if ($formType == "createReview") {
        $userId = $_POST["userId"];
        $productId = $_POST["productId"];
        $Review = array(
            "body" => $_POST["body"],
            "rating" => (int)$_POST["rating"],
            "author" => new ObjectId($userId)
        );
        //add review to db
        $result = $r->addReview($Review);
        if ($result != null) {
            $query = array(
                '$push' => array(
                    "reviews" => new ObjectId($result)
                )
            );
            //push review to product's reviews
            $result = $p->updateProduct($productId, $query);
            if ($result == 0) {
                flash("createError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
                header("location: ../views/products/product.php?id=" . $productId);
            } else {
                flash("createSuccess", "H αξιολόγηση προστέθηκε με επιτυχία!", FLASH_SUCCESS);
                header("location: ../views/products/product.php?id=" . $productId);
            }
        }
    } elseif ($formType == "deleteReview") {
        $reviewId = $_POST["reviewId"];
        $productId = $_POST["productId"];
        //delete review
        $result = $r->deleteReview($reviewId);
        if ($result == 0) {
            flash("deleteError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/products/product.php?id=" . $productId);
        } else {
            //remove review from the product's reviews
            $query = array(
                '$pull' => array(
                    "reviews" => new ObjectId($reviewId)
                )
            );
            $result = $p->updateProduct($productId, $query);
            if ($result == 0) {
                flash("deleteError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
                header("location: ../views/products/product.php?id=" . $productId);
            } else {
                flash("deleteSuccess", "H αξιολόγηση διαγράφθηκε με επιτυχία!", FLASH_SUCCESS);
                header("location: ../views/products/product.php?id=" . $productId);
            }
        }
    }
}
