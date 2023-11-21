<?php

class ProductViewHelper
{
    public function displaySingleProduct(dvd $dvd): string
    {
        $output = '<div>';
        $output .= "<h1>$dvd->title</h1>";
        $output .= "<p>$dvd->description</p>";
        $output .= "<p>$dvd->genre</p>";
        $output .= "<p>$dvd->starring</p>";
        $output .= "<img src = '$dvd->image'"
    }
}