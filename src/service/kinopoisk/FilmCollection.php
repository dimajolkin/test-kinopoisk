<?php

namespace app\service\kinopoisk;


use Traversable;

class FilmCollection implements \IteratorAggregate, \Countable
{
    /** @var FilmInterface[]  */
    protected $films = [];

    /**
     * FilmCollection constructor.
     * @param iterable $films
     */
    public function __construct(iterable $films)
    {
        $this->films = $films;
    }

    public function add(FilmInterface $film)
    {
        $this->films[] = $film;
    }

    public function toArray(): array
    {
        $array = [];
        foreach ($this->films as $film) {
            $array[] = $film->toArray();
        }

        return $array;
    }

    public function getIterator()
    {
        foreach ($this->films as $film) {
            yield $film;
        }
    }

    public function count()
    {
        return count($this->films);
    }
}