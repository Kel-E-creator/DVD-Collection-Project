<?php

use PhpParser\Node\Stmt\Echo_;

require_once 'src/ProductModel.php';
require_once 'src/ProductViewHelper.php';

$db = new PDO('mysql:host=127.0.0.1; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$productModel = new ProductModel($db);

//var_dump($_POST) ;

// Initialize the product variable with all DVDs by default
$product = $productModel->getAllDvds();

// Handle DVD search
$searchResult = "";
$searchPerformed = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $searchPerformed = true;
    $searchTerm = $_POST['search'];
    $foundDvd = $productModel->getDvdByTitle($searchTerm);
    if ($foundDvd) {
        $viewHelper = new ProductViewHelper();
        $searchResult = $viewHelper->displayAllProducts([$foundDvd]);
    } else {
        $searchResult = ".";
    }
} else {
    // If no search is performed, reset $searchPerformed to false
    $searchPerformed = false;
}


// Check if the "Show All DVDs" button is clicked
if (isset($_POST['showAll'])) {
    $product = $productModel->getAllDvds();
    $searchPerformed = false;
}

// Handle form submission to filter DVDs by decade
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterDecade'])) {
    $selectedDecade = isset($_POST['decade']) ? intval($_POST['decade']) : null;
    if ($selectedDecade) {
        $product = $productModel->getAllDvds($selectedDecade, null, null, null);
    }
}

// Handle form submission to filter DVDs by genre
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterGenre'])) {
    $selectedGenre = isset($_POST['genre']) ? intval($_POST['genre']) : null;
    if ($selectedGenre) {
        $product = $productModel->getAllDvds(null, $selectedGenre, null, null);
    }
}

// Handle form submission to filter DVDs by actor
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterActor'])) {
    $selectedActor = isset($_POST['actor']) ? intval($_POST['actor']) : null;
    if ($selectedActor) {
        $product = $productModel->getAllDvds(null, null, $selectedActor, null);
    }
}

// Handle form submission to filter DVDs by director
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['filterDirector'])) {
    $selectedDirector = isset($_POST['director']) ? intval($_POST['director']) : null;
    if ($selectedDirector) {
        $product = $productModel->getAllDvds(null, null, null, $selectedDirector);
    }
}

if (
    isset($_POST['title']) &&
    isset($_POST['description']) &&
    isset($_POST['run_time']) &&
    isset($_POST['run_time_mins']) &&
    isset($_POST['image']) &&
    isset($_POST['year']) &&
    isset($_POST['genre']) &&
    isset($_POST['starring']) &&
    isset($_POST['director'])
  ) 
  {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $run_time = $_POST['run_time'];
    $run_time_mins = $_POST['run_time_mins'];
    $image = $_POST['image'];
    $year = $_POST['year'];
    $genre = $_POST['genre'];
    $starring = $_POST['starring'];
    $director = $_POST['director'];
  

        if (strlen($title) == 0 || strlen($title) <1) {
            echo "Please enter a valid dvd title of at least 2 characters";
        } if (strlen($description) == 0 || strlen($description) < 20) {
            echo "Please enter a valid dvd description of at least 20 characters";
        } if (is_numeric($run_time) == false) {
            echo "Please enter a valid number";
        } if (intval($genre) == 0 || intval($genre) > 5) {
            echo "Please choose a genre from the drop down menu";
        } if (intval($starring) == 0 || intval($starring) > 9) {
            echo "Please either choose an actor from the drop down menu or add a new actor";
        } if (strlen($image) == 0 || strlen($image) <10) {
            echo "Please add a valid URL address";  
        } else {
        $success = $productModel->addDvd($title, $description, $run_time, $run_time_mins, $genre, $year, $starring, $image, $director);
        if($success) {
            echo "";
        } else {
            echo "There was an error adding the DVD.";
        }
        }
    }       
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poiret+One&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Monoton" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Righteous&display=swap" rel="stylesheet">

    <title>DVD Collection</title>
   
</head>
<body>
    <h1>MOVIE SHOWCASE</h1>

        <div class="search_container">
   
       <!-- Search Bar Form -->
    
        <form class="filmstrip3" method="POST">
            
            <label for="search">Search DVD by Title:</label>
            <input type="text" id="search" name="search"/>
            <button type="submit" id="search-button">Search</button>
        <!-- Error message for search -->
            <?php if ($searchPerformed && !$foundDvd) : ?>
            <p class="error-message">No DVD found in the collection with that title.</p>
            <?php endif; ?>
            <input type="submit" name="showAll" value="Show All DVDs">
            <button id="toggle-filters">Filters</button>
            <button id="toggle-add-dvd">Add DVD</button>
        </form>
            
        </div>
        
            <!-- Display Search Result -->
            <div class="searchResult">
                <?php if ($searchPerformed) : ?>
                <?php echo $searchResult; ?>
                <?php endif; ?>
            </div>

        <div id="filters-section" class="toggle-section">
        <div class="filter_container">
            <div class="filmstrip">
                <form method="POST">
                    <label for="decade">Filter by Decade:</label>
                    <select name="decade" id="decade">
                        <option value="">--- Select Decade ---</option>
                        <option value="1930">1930s</option>
                        <option value="1940">1940s</option>
                        <option value="1950">1950s</option>
                        <option value="1960">1960s</option>
                        <option value="1970">1970s</option>
                        <option value="1980">1980s</option>
                        <option value="1990">1990s</option>
                        <option value="2000">2000s</option>
                        <option value="2010">2010s</option>
                        <option value="2020">2020s</option>
                    </select>
                    <input type="submit" name="filterDecade" value="Apply Filter">
                </form>

                <!-- Filter by Genre -->
                <form method="POST">
                    <label for="genre">Filter by Genre:</label>
                    <select name="genre" id="genre">
                        <option value="">--- Select Genre ---</option>
                        <?php
                        $genres = $productModel->getGenres();
                        foreach ($genres as $genre) {
                            echo "<option value=\"{$genre['id']}\">{$genre['genre']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="filterGenre" value="Apply Filter">
                </form>

                <!-- Filter by Actor -->
                <form method="POST">
                    <label for="actor">Filter by Actor:</label>
                    <select name="actor" id="actor">
                        <option value="">--- Select Actor ---</option>
                        <?php
                        $actors = $productModel->getActors();
                        foreach ($actors as $actor) {
                            echo "<option value=\"{$actor['id']}\">{$actor['name']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="filterActor" value="Apply Filter">
                </form>

                <!-- Filter by Director -->
                <form method="POST">
                    <label for="director">Filter by Director:</label>
                    <select name="director" id="director">
                        <option value="">--- Select Director ---</option>
                        <?php
                        $directors = $productModel->getDirectors();
                        foreach ($directors as $director) {
                            echo "<option value=\"{$director['id']}\">{$director['director']}</option>";
                        }
                        ?>
                    </select>
                    <input type="submit" name="filterDirector" value="Apply Filter">
                </form>
            </div>
        </div>
        </div>


        <!-- ADD NEW DVD Form -->
        <div id="add-dvd-section" class="toggle-section">
        <form class="filmstrip2" method="POST">
            <div class="form-header">
                <h3>ADD NEW DVD</h3>
            </div>
            <div class ="form-body">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" />

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" />

            <label for="run_time">Run Time:</label>
            <input type="number" id="run_time" name="run_time" />

            <label for="run_time_mins">Run Time Mins:</label>
            <input type="number" id="run_time_mins" name="run_time_mins" />

            <label for="image">Image:</label>
            <input type="text" id="image" name="image" />

            <label for="year">Year:</label>
            <input type="number" id="year" name="year" />

            <label for="genre">Genre:</label>
            <select name="genre" id="genre">
                <option value="">--- Choose a Genre ---</option>
                <?php
                $genres = $productModel->getGenres();
                foreach ($genres as $genre) {
                    echo "<option value=\"{$genre['id']}\">{$genre['genre']}</option>";
                }
                ?>
            </select>

            <label for="starring">Starring:</label>
            <select name="starring" id="starring">
                <option value="">--- Choose an Actor ---</option>
                <?php
                $actors = $productModel->getActors();
                foreach ($actors as $actor) {
                    echo "<option value=\"{$actor['id']}\">{$actor['name']}</option>";
                }
                ?>
            </select>

            <label for="director">Director:</label>
            <select name="director" id="director" >
                <option value="">--- Choose a Director ---</option>
                <?php
                $directors = $productModel->getDirectors();
                foreach ($directors as $director) {
                    echo "<option value=\"{$director['id']}\">{$director['director']}</option>";
                }
                ?>
            </select>
       
            <input type="submit" value="Add DVD" />
            </div>
        <?php
        if (isset($success)) {
            echo "<p class=\"success-message\">DVD added!</p>";
        }
        ?>

             
        </form>
          
        </div> 

 
    
     

   <!-- Display DVDs -->
   <?php
    $viewHelper = new ProductViewHelper();
    echo '<div class="dvds">' . $viewHelper->displayAllProducts($product) . '</div>';
    ?>

    <!-- Add this at the bottom of your PHP file just before the closing </body> tag -->
    <button id="back-to-top" title="Go to top">Back to Top</button>


</body>

<script>
 document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('toggle-filters').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the button click
        
        var filtersSection = document.getElementById('filters-section');
        var computedStyle = window.getComputedStyle(filtersSection);
        if (computedStyle.display === 'none') {
            filtersSection.style.display = 'block';
        } else {
            filtersSection.style.display = 'none';
        }
    });
    
    document.getElementById('toggle-add-dvd').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the button click
        
        var addDvdSection = document.getElementById('add-dvd-section');
        var computedStyle = window.getComputedStyle(addDvdSection);
        if (computedStyle.display === 'none') {
            addDvdSection.style.display = 'block';
        } else {
            addDvdSection.style.display = 'none';
        }
    });
});

// Get the button
let backToTopButton = document.getElementById("back-to-top");

// When the user scrolls down 20px from the top of the document, show the button
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        backToTopButton.style.display = "block";
    } else {
        backToTopButton.style.display = "none";
    }
}

// When the user clicks on the button, scroll to the top of the document
backToTopButton.onclick = function() {
    document.body.scrollTop = 0; // For Safari
    document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
}

</script>

</html>


