<?php

require_once 'src/ProductModel.php';

$db = new PDO('mysql:host=db; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$productModel = new ProductModel($db);

$product = $productModel->getAllDvds();

echo '<pre>';
var_dump($product);



