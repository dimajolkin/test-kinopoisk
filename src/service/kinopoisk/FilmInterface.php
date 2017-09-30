<?php

namespace app\service\kinopoisk;


interface FilmInterface
{
    public function getPosition(): int;

    public function getRating(): float;

    public function getName(): string;

    public function getYear(): int;

    public function getNumberVoted(): int;

    public function getDate(): \DateTime;
}