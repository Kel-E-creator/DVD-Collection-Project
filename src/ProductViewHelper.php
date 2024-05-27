<?php

require_once 'src/Product.php';

class ProductViewHelper
{
    public function displayAllProducts(array $dvds): string
    {
        $output = '';
        
        foreach($dvds as $dvd) {
        $output .= '<div class="dvd">';
        $output .= "<img src = '$dvd->image'/>";
        $output .= "<h2>$dvd->title</h2>";
        $output .= "<p>$dvd->description</p>";
        $output .= "<p>Year: $dvd->year</p>";
        $output .= "<p>Starring: " . implode(', ', $dvd->starring) . "</p>"; // Convert array to string
        $output .= '<div class="runtime">';
        $output .= "<span>Run time: $dvd->run_time hour</span>";
        $output .= "<span> : $dvd->run_time_mins minutes</span>";
        $output .= '</div>';
        $output .= "<p>Genre: " . implode(', ', $dvd->genre) . "</p>";
        $output .= "<p>Director: $dvd->director</p>";
        $output .= '</div>';
        }
    
        return $output;
    }
}

