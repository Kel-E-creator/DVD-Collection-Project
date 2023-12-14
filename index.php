<?php

use PhpParser\Node\Stmt\Echo_;

require_once 'src/ProductModel.php';
require_once 'src/ProductViewHelper.php';

$db = new PDO('mysql:host=db; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$productModel = new ProductModel($db);

//var_dump($_POST) ;

if (
    isset($_POST['title']) &&
    isset($_POST['description']) &&
    isset($_POST['run_time']) &&
    isset($_POST['image']) &&
    isset($_POST['genre']) &&
    isset($_POST['starring'])
  ) 
  {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $run_time = $_POST['run_time'];
    $image = $_POST['image'];
    $genre = $_POST['genre'];
    $starring = $_POST['starring'];
  

        if (strlen($title) == 0 || strlen($title) <1) {
            echo "Please enter a valid dvd title of at least 2 characters";
        } if (strlen($description) == 0 || strlen($description) < 20) {
            echo "Please enter a valid dvd description of at least 20 characters";
        } if (is_int($run_time) == false) {
            echo "Please enter a valid number";
        } if (intval($genre) == 0 || intval($genre) > 5) {
            echo "Please choose a genre from the drop down menu";
        } if (intval($starring) == 0 || intval($starring) > 9) {
            echo "Please either choose an actor from the drop down menu or add a new actor";
        } if (strlen($image) == 0 || strlen($image) <10) {
            echo "Please add a valid URL address";  
        } else {
        $success = $productModel->addDvd($title, $description, $run_time, $genre, $starring, $image);
    }       
  }
    //$title, $description, $run_time, $genre, $starring, $image
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel=“stylesheet” href=“style.css”>
    <title>DVD Collection</title>
</head>
<body>
    <h1>DVD Collection</h1>
    <form class="formContainer" method="POST">
        <label for="title">Title:</label>
        <input type="text" id="title" name="title" />

        <label for="description">Description:</label>
        <input type="text" id="description" name="description" />

        <label for="run_time">Run Time:</label>
        <input type="number" id="run_time" name="run_time" />

        <label for="image">Image:</label>
        <input type="text" id="image" name="image" />

        <label for="genre">Genre:</label>
        <select name="genre" id="genre">
                <option value="">--- Choose a Genre ---</option>
                <option value=1>Science Fiction</option>
                <option value=2>Romantic Comedy</option>
                <option value=3>Classic 80's Comedy</option>
                <option value=4>Dystopian</option>
                <option value=5>Action</option>
        </select>
        
        

        <label for="starring">Starring:</label>
        <select name="starring" id="starring">
                <option value="">--- Choose an Actor ---</option>
                <option value=1>Tom Hanks</option>
                <option value=2>Daryl Hannah</option>
                <option value=3>John Candy</option>
                <option value=4>Arnold Schwarzenegger</option>
                <option value=5>Harrison Ford</option>
                <option value=6>Sean Young</option>
                <option value=7>Dolph Lungren</option>
                <option value=8>Courtney Cox</option>

        <input type="submit" value="Add DVD" />

        <?php
        if (isset($success)) {
        echo "Dvd added!";
        }    
        ?>

    </form>
    
</body>
</html>

<?php


$product = $productModel->getAllDvds();

$viewHelper = new ProductViewHelper();
echo $viewHelper->displayAllProducts($product);
?>