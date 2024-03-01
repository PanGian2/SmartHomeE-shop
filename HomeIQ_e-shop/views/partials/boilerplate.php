<?php
session_start();

$configPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);
$configPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/';
include_once $configPath . "config.php";
require_once $modelsPath . 'cart.php';
require_once $modelsPath . 'product.php';
require_once $modelsPath . 'user.php';
//}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HomeIQ</title>
    <link rel="stylesheet" href="<?php echo $stylesPath ?>navbar.css">
    <link rel="stylesheet" href="<?php echo $stylesPath ?>footer.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script defer src="<?php echo $utilsPath ?>showPassword.js"></script>
    <script defer>
        let source = "<?php echo $controllersPath ?>"
        let views = "<?php echo $viewsPath ?>"
    </script>
    <script defer src="<?php echo $utilsPath ?>search.js"></script>
    <script defer src="<?php echo $utilsPath ?>validate.js"></script>