<?php

require_once 'src/ProductModel.php';
require_once 'src/ProductViewHelper.php';

$db = new PDO('mysql:host=db; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$productModel = new ProductModel($db);

$product = $productModel->getAllDvds();

$viewHelper = new ProductViewHelper();
echo $viewHelper->displayAllProducts($product);

echo "hello";

//echo ProductViewHelper::displayAllProducts($product);

// echo '<pre>';
// var_dump($product);