<?php

class Product
{
    public int $id;
    public string $title;
    public string $description;
    public int $run_time;
    public int $run_time_mins;
    public array $genre;
    public array $starring;
    public string $image;
    public int $year;
    public string $director;

    public function __construct(
        int $id,
        string $title,
        string $description,
        int $run_time,
        int $run_time_mins,
        array $genre,
        array $starring,
        string $image,
        int $year,
        string $director
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->run_time = $run_time;
        $this->run_time_mins = $run_time_mins;
        $this->genre = $genre;
        $this->starring = $starring;
        $this->image = $image;
        $this->year = $year;
        $this->director = $director;
    }

}
