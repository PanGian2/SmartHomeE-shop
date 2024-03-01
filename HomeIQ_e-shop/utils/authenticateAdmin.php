<?php
// session_start();
//Αυθεντικοποίηση διαχειριστή. Πρέπει να είναι συνδεδεμένος και ο τύπος του να είναι admin. 
//Σε περίτπωση που δεν ισχύει κάποιο από τα δύο γίνεται ανακατεύθυνση στην αρχική σελίδα
if (!isset($_SESSION["loggedIn"])) {
    flash("notLoggedIn", "Πρέπει πρώτα να συνδεθείτε για να πλοηγηθήτε σε αυτή την σελίδα", FLASH_WARNING);
    header("Location: " . $viewsPath .  "home.php");
} elseif ($_SESSION["role"] != 2) {
    header('X-PHP-Response-Code: 403', true, 403);
    flash("notAdmin", "Απαγορεύεται η πρόσβαση σε αυτή την σελίδα", FLASH_ERROR);
    header("Location: " . $viewsPath .  "home.php");
}
