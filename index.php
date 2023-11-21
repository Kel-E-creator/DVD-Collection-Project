<?php

$db = new PDO('mysql:host=db; dbname=dvdcollection', 'root', 'password');

$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$query = $db->prepare('SELECT `dvd`.`title`, `dvd`.`description`, `dvd`.`run_time`, `dvd`.`image`, `genre`.`genre`, `actors`.`name`
FROM `dvd`
	INNER JOIN `genre`
		ON `dvd`.`genre_id` = `genre`.`id`
	INNER JOIN `starring`
		ON `dvd`.`id` = `starring`.`dvd_id`
	INNER JOIN `actors`
	  ON `starring`.`actor_id` = `actors`.`id`;');


$query->execute();

$result = $query->fetchAll();

echo '<pre>';
var_dump($result);



