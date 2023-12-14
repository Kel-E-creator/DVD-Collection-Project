<?php

require_once 'src/Product.php';

class ProductModel
{
    public PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllDvds()
    {
        $query = $this->db->prepare('SELECT `dvd`.`id`, `dvd`.`title`, `dvd`.`description`, `dvd`.`run_time`, `dvd`.`image`, `genre`.`genre`, `actors`.`name`
        FROM `dvd`
            INNER JOIN `genre`
                ON `dvd`.`genre_id` = `genre`.`id`
            INNER JOIN `starring`
                ON `dvd`.`id` = `starring`.`dvd_id`
            INNER JOIN `actors`
              ON `starring`.`actor_id` = `actors`.`id`;');   

        $query->execute();
        $dvds = $query->fetchAll();

        $existingDvds = [];
        // Go through all of the new dvds
        foreach($dvds as $dvd) {
            // If we dont have any existing dvds, we add the new one to the list
            if (empty($existingDvds)) {
                $existingDvds[] = new Product(
                    $dvd['id'],
                    $dvd['title'],
                    $dvd['description'],
                    $dvd['run_time'],
                    $dvd['genre'],
                    $dvd['name'],
                    $dvd['image']
                );

                continue; // This stops the current iteration from doing anything, skips it 
                // and moves onto the next dvd because there are no other existing dvds to check
            }
            // If we get here, we know that there is atleast 1 existing dvd
            $dvdExists = false;
            // So we check through all the existing dvds
            foreach($existingDvds as $existingdvd) {
                // If the existing dvd matches the current new dvd
                if ($existingdvd->id == $dvd['id']) {
                    // Add the new actor onto the list
                    $existingdvd->starring .=", {$dvd['name']}" ;  
                    $dvdExists = true; // signal that the new dvd was found
                } 
            }
            // If the new dvd was not in the existing dvds
            if (!$dvdExists) { 
                // Add it to the list
                $existingDvds[] = new Product(
                    $dvd['id'],
                    $dvd['title'],
                    $dvd['description'],
                    $dvd['run_time'],
                    $dvd['genre'],
                    $dvd['name'],
                    $dvd['image']
                );
            }
        }

        return $existingDvds;
    }
}