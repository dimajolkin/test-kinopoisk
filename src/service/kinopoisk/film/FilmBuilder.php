<?php

namespace app\service\kinopoisk\film;

use app\service\kinopoisk\FilmInterface;
use DateTime;

class FilmBuilder
{
    /** @var  int */
    protected $id;
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
     * FilmBuilder constructor.
     * @param array $properties
     */
    public function __construct(array $properties = [])
    {
        foreach ($properties as $name => $value) {
            if ($name == 'date') {
                $value = new DateTime($value);
            }

            $this->{'set' . $name}($value);
        }
    }


    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param int $position
     * @return $this
     */
    public function setPosition(int $position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @param float $rating
     * @return $this
     */
    public function setRating(float $rating)
    {
        $this->rating = $rating;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param int $year
     * @return $this
     */
    public function setYear(int $year)
    {
        $this->year = $year;

        return $this;
    }

    /**
     * @param int $numberVoted
     * @return $this
     */
    public function setNumberVoted(int $numberVoted)
    {
        $this->numberVoted = $numberVoted;

        return $this;
    }

    /**
     * @param DateTime $date
     * @return $this
     */
    public function setDate(?DateTime $date)
    {
        $this->date = $date;

        return $this;
    }


    public function create(): FilmInterface
    {
        return new Film(
            $this->position,
            $this->rating,
            $this->name,
            $this->year,
            $this->numberVoted,
            $this->date
        );
    }
}