<?php

require_once 'src/ProductModel.php';
require_once 'src/ProductViewHelper.php';

$db = new PDO('mysql:host=db; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$productModel = new ProductModel($db);

var_dump($_POST) ;

if (
    isset($_POST['title']) &&
    isset($_POST['description']) &&
    isset($_POST['run_time']) &&
    isset($_POST['genre']) &&
    isset($_POST['starring']) &&
    isset($_POST['image']) 
) {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $run_time = $_POST['run_time'];
    $genre = $_POST['genre'];
    $starring = $_POST['starring'];
    $image = $_POST['image'];

    echo $title;
    echo $description;
    echo $run_time;
    echo $genre;
    echo $starring;
    echo $image;

    $success = $productModel->addDvd($title, $description, $run_time, $genre, $starring, $image);

    if ($success) {
        echo "Dvd added!";
    } 
    else {
        return "All fields not correctly filled in, please try again";
    }
}

?>



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
        <input type="number" id="run_time" name="run_time" />

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

        </select>
        <label for="starring">If your actor/actress doesnt appear in the list above please add them here:</label>
        <input type="starring" id="starring" name="starring" />


        <label for="image">Image:</label>
        <input type="text" id="image" name="image" />

        <input type="submit" value="Add DVD" />


    </form>
    
</body>
</html>

<?php


$product = $productModel->getAllDvds();

$viewHelper = new ProductViewHelper();
echo $viewHelper->displayAllProducts($product);
?>