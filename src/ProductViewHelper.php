<?php

require_once 'src/Product.php';

class ProductViewHelper
{
    public function displayAllProducts(array $dvds): string
    {
        $output = '';

        foreach($dvds as $dvd) {
        $output .= '<div>';
        $output .= "<h1>$dvd->title</h1>";
        $output .= "<p>$dvd->description</p>";
        $output .= "<p>$dvd->run_time</p>";
        $output .= "<p>$dvd->genre</p>";
        $output .= "<p>$dvd->starring</p>";
        $output .= "<img src = '$dvd->image'";
        $output .= '<div';
        }

        return $output;
    }
}