<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DVD Collection</title>
</head>
<body>
    <h1>DVD Collection</h1>
    <form method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" />

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" />

        <label for="run_time">Run Time:</label>
        <input type="number" id="run_time" name="description" />

        <label for="genre">Genre:</label>
        <input type="text" id="text" name="text" />

        <label for="starring">Starring:</label>
        <input type="starring" id="starring" name="starring" />

        <label for="image">Image:</label>
        <input type="text" id="image" name="image" />

        <input type="submit" value="Add DVD" />


    </form>
    
</body>
</html>




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