<?php

require_once 'src/ProductViewHelper.php';

use PHPUnit\Framework\TestCase;

class ProductViewHelperTest extends TestCase
{
    public function testdisplayAllProductsPositive(): void
    {
        $output = '<div>';
        $output .= "<h1>Mary Poppins</h1>";
        $output .= "<p>Family fun</p>";
        $output .= "<p>60</p>";
        $output .= "<p>Comedy</p>";
        $output .= "<p>Julie Walters</p>";
        $output .= "<img src = 'https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Mary_Poppins_screen_2.jpg/250px-Mary_Poppins_screen_2.jpg'/>";
        $output .= '<div>';

        $dvd1 = new Product (
            4,
            'Mary Poppins',
            'Family fun',
            60,
            'Comedy',
            'Julie Walters',
            'https://upload.wikimedia.org/wikipedia/commons/thumb/1/16/Mary_Poppins_screen_2.jpg/250px-Mary_Poppins_screen_2.jpg'
        );

        
        $result = ProductViewHelper::displayAllProducts([$dvd1]);


        $this->assertEquals($output, $result);
    }
}