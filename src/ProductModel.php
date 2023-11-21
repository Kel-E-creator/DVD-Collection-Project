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
        $query = $this->db->prepare('SELECT `dvd`.`title`, `dvd`.`description`, `dvd`.`run_time`, `dvd`.`image`, `genre`.`genre`, `actors`.`name`
        FROM `dvd`
            INNER JOIN `genre`
                ON `dvd`.`genre_id` = `genre`.`id`
            INNER JOIN `starring`
                ON `dvd`.`id` = `starring`.`dvd_id`
            INNER JOIN `actors`
              ON `starring`.`actor_id` = `actors`.`id`;');   

        $query->execute();
        $dvds = $query->fetchAll();

        foreach($dvds as $dvd) {
            $productObj[] = new Product(
                $dvd['title'],
                $dvd['description'],
                $dvd['run_time'],
                $dvd['genre'],
                $dvd['name'],
                $dvd['image']
            );
        }

        return $productObj;
    }
}