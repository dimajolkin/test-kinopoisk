<?php

namespace app\service\kinopoisk\provider\site;


use app\service\kinopoisk\FilmInterface;
use DateTime;

class Film implements FilmInterface
{
    /** @var  int */
    protected $position;
    /** @var  float */
    protected $rating;
    /** @var  string */
    protected $name;
    /** @var  int */
    protected $year;
    /** @var  int */
    protected $numberVoted;
    /** @var  DateTime */
    protected $date;

    /**
     * Film constructor.
     * @param int $position
     * @param float $rating
     * @param string $name
     * @param int $year
     * @param int $numberVoted
     * @param DateTime $dateTime
     */
    public function __construct(
        int $position,
        float $rating,
        string $name,
        int $year,
        int $numberVoted,
        DateTime $dateTime
    )
    {
        $this->position = $position;
        $this->rating = $rating;
        $this->name = $name;
        $this->year = $year;
        $this->numberVoted = $numberVoted;
        $this->date = $dateTime;
    }


    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return float
     */
    public function getRating(): float
    {
        return $this->rating;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @return int
     */
    public function getNumberVoted(): int
    {
        return $this->numberVoted;
    }

    public function getDate(): \DateTime
    {
        return $this->date;
    }


}