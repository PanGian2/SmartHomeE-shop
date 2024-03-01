<?php
$stylesPath = "";
$imgPath = "";
$utilsPath = "";
$viewsPath = "";
$vendorPath = "";
$modelsPath = "";
$controllersPath = "";
$currentFile = $_SERVER['PHP_SELF'];
$currentDir = dirname($currentFile);

//get directory's path
$stylesPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/public/styles/';
$utilsPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/utils/';
$imgPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/imgs/';
$viewsPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/views/';
$vendorPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/vendor/';
$modelsPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/models/';
$controllersPath .= str_repeat('../', substr_count($currentDir, '/')) . 'HomeIQ_e-shop/controllers/';
