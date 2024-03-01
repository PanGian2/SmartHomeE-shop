<?php

use MongoDB\BSON\ObjectId;

session_start();
require_once '../models/user.php';
require_once '../utils/flash_messages.php';
date_default_timezone_set("Europe/Athens");
$u = new User();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $formType = $_POST["formType"];
    if ($formType == "createUser") {
        //user's password is the hashed version of his input
        //or if the user created by admin the default password is user12345
        $User = array(
            "password" => isset($_POST["password"]) ? password_hash($_POST["password"], PASSWORD_DEFAULT) : password_hash("user12345", PASSWORD_DEFAULT),
            "name" => $_POST["name"],
            "surname" => $_POST["surname"],
            "email" => $_POST["email"],
            "phone" => $_POST["tel"],
            "city" => $_POST["city"],
            "address" => $_POST["address"],
            "postalCode" => $_POST["postalCode"],
            "inNewsletter" => isset($_POST["newsletterInput"]) ?  $_POST["newsletterInput"] : 0,
            "role" => isset($_POST["type"]) ?  $_POST["type"] : 1,
            "favorites" => [],
            "loginHistory" => []
        );
        //add user to db
        $result = $u->addUser($User);
        if ($result == "") {
            flash("createError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/" . $_POST["source"]);
        } else {
            //login user
            if ($_POST["source"] != "users/index.php") {
                $_SESSION["loggedIn"] = true;
                $_SESSION["userID"] = $result;
                $_SESSION["role"] = 1;
                $query = array(
                    //add an entry to user's login history
                    '$push' => array(
                        'loginHistory' => array(
                            "loginTime" => date("d-m-Y, H:i"),
                            "logoutTime" => null,
                            "duration" => null
                        )
                    )
                );
                $u->updateUser($result, $query);
            }
            flash("createSuccess", "H εγγραφή έγινε με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/" . $_POST["source"]);
        }
    } elseif ($formType == "login") {
        $email = $_POST["email"];
        $password = $_POST["password"];
        $result = $u->authUser($email, $password);
        $_SESSION["loggedIn"] = true;
        $_SESSION["userID"] = $result["_id"];
        $_SESSION["role"] = $result["role"];
        //add an entry to user's login history
        $query = array(
            '$push' => array(
                'loginHistory' => array(
                    "loginTime" => date("d-m-Y, H:i"),
                    "logoutTime" => null,
                    "duration" => null
                )
            )
        );
        $u->updateUser($result["_id"], $query);
        if (!isset($_POST["source"]) && $_POST["source"] != "checkout.php") {
            flash("loggedIn", "Καλωσήλθατε και πάλι!", FLASH_SUCCESS);
            header("location: ../views/home.php");
        }
    } elseif ($formType == "addFavorites") {
        $productId = $_POST["productId"];
        $userId = $_POST["userId"];
        //push product id to user's favorites
        $query = array(
            '$push' => array(
                "favorites" => new ObjectId($productId)
            )
        );
        $result = $u->updateUser($userId, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/products/product.php?id=" . $productId);
        } else {
            header("location: ../views/products/product.php?id=" . $productId);
        }
    } elseif ($formType == "removeFromFavorites") {
        $productId = $_POST["productId"];
        $userId = $_POST["userId"];
        //remove product id from user's favorites
        $query = array(
            '$pull' => array(
                "favorites" => new ObjectId($productId)
            )
        );
        $result = $u->updateUser($userId, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/" . $_POST["source"]);
        } else {
            flash("updateSuccess", "Το προϊόν αφαιρέθηκε από τα αγαπημένα με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/" . $_POST["source"]);
        }
    } elseif ($formType == "updateUser") {
        $userId = $_POST["id"];
        $query = array(
            '$set' => array(
                "name" => $_POST["name"],
                "surname" => $_POST["surname"],
                "email" => $_POST["email"],
                "phone" => $_POST["tel"],
                "city" => $_POST["city"],
                "address" => $_POST["address"],
                "postalCode" => $_POST["postalCode"],
                "role" => isset($_POST["type"]) ?  $_POST["type"] : 1,
            )
        );
        //update user
        $result = $u->updateUser($userId, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/" . $_POST["source"]);
        } else {
            flash("updateSuccess", "Τα στοιχεία ενημερώθηκαν με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/" . $_POST["source"]);
        }
    } elseif ($formType == "passwordUpdate") {
        $userId = $_POST["id"];
        $pass3 = $_POST["pass3"];
        $query = array(
            '$set' => array(
                "password" => password_hash($pass3, PASSWORD_DEFAULT)
            )
        );
        //update user's password
        $result = $u->updateUser($userId, $query);
        if ($result == 0) {
            flash("updateError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/users/user-profile.php");
        } else {
            flash("updateSuccess", "Τα στοιχεία ενημερώθηκαν με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/users/user-profile.php");
        }
    } elseif ($formType == "deleteUser") {
        $userId = $_POST["userId"];
        //delete user
        $result = $u->deleteUser($userId);
        if ($result == 0) {
            flash("deleteError", "Κάτι πήγε λάθος. Ξαναπροσπάθησε αργότερα!", FLASH_ERROR);
            header("location: ../views/users/index.php");
        } else {
            flash("deleteSuccess", "O χρήστης διαγράφηκε με επιτυχία!", FLASH_SUCCESS);
            header("location: ../views/users/index.php");
        }
    }
}

if (isset($_GET["verifyEmail"]) && isset($_GET["verifyPassword"])) {
    $email = $_GET["verifyEmail"];
    $password = $_GET["verifyPassword"];
    //check if there is a user with these values
    $result = $u->authUser($email, $password);
    if ($result == false) {
        echo $result;
    } else {
        echo true;
    }
} else if (isset($_GET["verifyEmail"])) {
    //check if there is a user with this email
    $email = $_GET["verifyEmail"];
    $result = $u->getUserByEmail($email)->toArray();
    echo $result == null;
}
