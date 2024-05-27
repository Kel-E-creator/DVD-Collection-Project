<?php

require_once 'src/Product.php';

class ProductModel
{
    public PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllDvds($decade = null, $genre = null, $actor = null, $director = null)
    {
        $queryStr = '
        SELECT 
            `dvd`.`id`, 
            `dvd`.`title`, 
            `dvd`.`description`, 
            `dvd`.`run_time`, 
            `dvd`.`run_time_mins`, 
            `dvd`.`image`, 
            `dvd`.`year`, 
            GROUP_CONCAT(DISTINCT `genre`.`genre`) AS `genres`, 
            `director`.`director` AS `director_name`,
            GROUP_CONCAT(DISTINCT `actors`.`name`) AS `starring_names`
        FROM 
            `dvd`
        INNER JOIN 
            `starring` ON `dvd`.`id` = `starring`.`dvd_id`
        INNER JOIN 
            `actors` ON `starring`.`actor_id` = `actors`.`id`
        INNER JOIN 
            `director` ON `dvd`.`director_id` = `director`.`id`
        INNER JOIN 
            `content` ON `dvd`.`id` = `content`.`dvd_id`
        INNER JOIN 
            `genre` ON `content`.`genre_id` = `genre`.`id`
        WHERE 
            (:decade IS NULL OR `dvd`.`year` BETWEEN :decade AND (:decade + 9)) 
            AND (:genre IS NULL OR `genre`.`id` = :genre)
            AND (:actor IS NULL OR `actors`.`id` = :actor)
            AND (:director IS NULL OR `director`.`id` = :director)
        GROUP BY 
            `dvd`.`id`, 
            `dvd`.`title`,
            `director`.`director`;
        ';

        $query = $this->db->prepare($queryStr);

        $query->bindValue(':decade', $decade, PDO::PARAM_INT);
        $query->bindValue(':genre', $genre, PDO::PARAM_INT);
        $query->bindValue(':actor', $actor, PDO::PARAM_INT);
        $query->bindValue(':director', $director, PDO::PARAM_INT);
        $query->execute();
        $dvds = $query->fetchAll();

        $existingDvds = [];
        foreach ($dvds as $dvd) {
            $genres = explode(',', $dvd['genres']);
            $actorNames = array_unique(explode(',', $dvd['starring_names']));
            $dvdExists = false;
            foreach ($existingDvds as $existingDvd) {
                if ($existingDvd->id == $dvd['id']) {
                    foreach ($actorNames as $actorName) {
                        if (!in_array($actorName, $existingDvd->starring)) {
                            $existingDvd->starring[] = $actorName;
                        }
                    }
                    $dvdExists = true;
                    break;
                }
            }
            if (!$dvdExists) {
                $existingDvds[] = new Product(
                    $dvd['id'],
                    $dvd['title'],
                    $dvd['description'],
                    $dvd['run_time'],
                    $dvd['run_time_mins'],
                    $genres,
                    $actorNames,
                    $dvd['image'],
                    $dvd['year'],
                    $dvd['director_name']
                );
            }
        }
        return $existingDvds;
    }

    public function getGenres()
    {
        $query = $this->db->prepare('SELECT `id`, `genre` FROM `genre`');
        $query->execute();
        return $query->fetchAll();
    }

    public function getActors()
    {
        $query = $this->db->prepare('SELECT `id`, `name` FROM `actors`');
        $query->execute();
        return $query->fetchAll();
    }

    public function getDirectors()
    {
        $query = $this->db->prepare('SELECT `id`, `director` FROM `director`');
        $query->execute();
        return $query->fetchAll();
    }

    
    public function getDvdByTitle($title)
    {
        $query = $this->db->prepare('SELECT `dvd`.`id`, `dvd`.`title`, `dvd`.`description`, `dvd`.`run_time`, `dvd`.`run_time_mins`, `dvd`.`image`, `dvd`.`year`, `genre`.`genre`, `actors`.`name`, `director`.`director`
            FROM `dvd`
            INNER JOIN `starring` ON `dvd`.`id` = `starring`.`dvd_id`
            INNER JOIN `actors` ON `starring`.`actor_id` = `actors`.`id`
            INNER JOIN `director` ON `dvd`.`director_id` = `director`.`id`
            INNER JOIN `content` ON `dvd`.`id` = `content`.`dvd_id`
            INNER JOIN `genre` ON `content`.`genre_id` = `genre`.`id`
            WHERE `dvd`.`title` = :title
            ORDER BY `dvd`.`id`;');
    
        $query->bindParam(':title', $title);
        $query->execute();
        $dvd = $query->fetch(PDO::FETCH_ASSOC);
    
        if ($dvd) {
            return new Product(
                $dvd['id'],
                $dvd['title'],
                $dvd['description'],
                $dvd['run_time'],
                $dvd['run_time_mins'],
                [$dvd['genre']],
                [$dvd['name']],
                $dvd['image'],
                $dvd['year'],
                $dvd['director']
            );
        } else {
            return null;
        }
    }


    public function addDvd($title, $description, $run_time, $run_time_mins, $genre, $year, $actor_id, $image, $director_id)
    {
        $query = $this->db->prepare('INSERT INTO `dvd`
                (`title`, `description`, `run_time`, `run_time_mins`, `year`, `director_id`,`image`)
                VALUES (:title, :description, :run_time, :run_time_mins, :year, :director_id, :image);'
        );
    
        $query->bindParam(':title', $title);
        $query->bindParam(':description', $description);
        $query->bindParam(':run_time', $run_time);
        $query->bindParam(':run_time_mins', $run_time_mins);
        $query->bindParam(':year', $year);
        $query->bindParam(':director_id', $director_id);
        $query->bindParam(':image', $image);
    
        $query->execute();
    
        $dvd_id = $this->db->lastInsertId();
    
        $query = $this->db->prepare('INSERT INTO `starring`
                (`actor_id`, `dvd_id`)
                VALUES (:actor_id, :dvd_id);'
        );
    
        $query->bindParam(':dvd_id', $dvd_id);
        $query->bindParam(':actor_id', $actor_id);
    
        $query->execute(); // Execute the starring table insertion query
    
        $query = $this->db->prepare('INSERT INTO `content`
        (`genre_id`, `dvd_id`)
        VALUES (:genre_id, :dvd_id);'
        );
    
        $query->bindParam(':dvd_id', $dvd_id);
        $query->bindParam(':genre_id', $genre);
    
        $success = $query->execute();
    
        return $success;
    }

}  

