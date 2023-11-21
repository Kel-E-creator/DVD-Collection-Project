<?php

class Product
{
    public string $title;
    public string $description;
    public int $run_time;
    public string $genre;
    public string $starring;
    public string $image;

    public function __construct(
        string $title,
        string $description,
        int $run_time,
        string $genre,
        string $starring,
        string $image
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->run_time = $run_time;
        $this->genre = $genre;
        $this->starring = $starring;
        $this->image = $image;
    }

}
