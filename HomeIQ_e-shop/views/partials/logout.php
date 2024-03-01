<?php
//Clear session info
session_start();
if (isset($_SESSION["loggedIn"])) {
    require_once("../../models/user.php");
    date_default_timezone_set("Europe/Athens");
    $u = new User();
    $logout_time = date("d-m-Y H:i");
    $test = $u->getUserById($_SESSION["userID"]);
    $login = array_slice(iterator_to_array($test["loginHistory"]), -1)[0];
    $duration = strtotime($logout_time) - strtotime($login["loginTime"]);
    $duration = $duration / 60;
    $result = $u->updateUserLoginHours($_SESSION["userID"], $login["loginTime"], $logout_time, $duration);

    $_SESSION = array();
    session_destroy();
    header("location: ../home.php");
    exit;
}
