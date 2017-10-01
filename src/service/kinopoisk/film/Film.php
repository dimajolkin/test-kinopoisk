<?php

namespace app\service\kinopoisk\film;


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
     * @param DateTime $date
     */
    public function __construct($position = null, $rating = null, $name = null, $year = null, $numberVoted = null, DateTime $date = null)
    {
        $this->position = $position;
        $this->rating = $rating;
        $this->name = $name;
        $this->year = $year;
        $this->numberVoted = $numberVoted;
        $this->date = $date;
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

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public static function createByArray(array $properties): self
    {
        $film = new static();
        foreach ($properties as $name => $value) {
            $film->{$name} = $value;
        }

        return $film;
    }

    public function toArray(): array
    {
        return [
            'position' => $this->getPosition(),
            'rating' => $this->getRating(),
            'name' => $this->getName(),
            'year' => $this->getYear(),
            'numberVoted' => $this->getNumberVoted(),
            'date' => (string)$this->getDate()->format('Y-m-d'),
        ];
    }
 }