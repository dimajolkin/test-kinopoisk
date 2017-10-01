<?php

namespace app\service\kinopoisk\provider;


use app\service\kinopoisk\film\FilmBuilder;
use app\service\kinopoisk\FilmCollection;
use app\service\kinopoisk\FilmInterface;
use DateTime;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver\PDOStatement;
use Doctrine\DBAL\Driver\Statement;

class DbProvider implements ProviderInterface
{
    /** @var  Connection */
    protected $connection;

    const DATE_FORMAT = 'Y-m-d';

    /**
     * DbProvider constructor.
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function insert(FilmInterface $film)
    {
        $builder =  $this->connection->createQueryBuilder();

        $values = [];
        $params = [];
        foreach ($film->toArray() as $name => $value) {
            $values[$name] = '?';
            $params[] = $value;
        }

        $builder->insert('film')
            ->values($values)
            ->setParameters($params);

        $builder->execute();
    }

    public function exist(FilmInterface $film)
    {
        $builder = $this->connection->createQueryBuilder();
        $builder
            ->select('count(1) as count')
            ->from('film')
            ->setMaxResults(1)
            ->andWhere("name = ? and year = ? and date = ?");

        $builder->setParameters([
            $film->getName(),
            $film->getYear(),
            $film->getDate()->format(static::DATE_FORMAT)
        ]);

        $statement = $builder->execute();

        return !!$statement->fetchColumn(0);
    }

    public function insertAll(FilmCollection $collection)
    {
        foreach ($collection as $film) {
            if (!$this->exist($film)) {
                $this->insert($film);
            }
        }
    }

    public function fetchTopByDate($limit = 10, DateTime $time = null): FilmCollection
    {
        $builder = $this->connection->createQueryBuilder();
        $time =  $time ?: new DateTime('now');

        $builder
            ->from('film')
            ->select('*')
            ->orderBy('position')
            ->where('date = ?')
            ->setMaxResults($limit)
            ->setParameters([$time->format(static::DATE_FORMAT)]);

        $statement = $builder->execute();

        return $this->buildFilmCollection($statement->fetchAll());
    }

    public function fetchAll(DateTime $time = null): FilmCollection
    {
        $builder = $this->connection->createQueryBuilder();
        $time =  $time ?: new DateTime('now');

        $builder
            ->from('film')
            ->orderBy('position')
            ->where('date = ?')
            ->setParameters([$time->format(static::DATE_FORMAT)]);;

        $statement = $builder->execute();

        return $this->buildFilmCollection($statement->fetchAll());
    }

    /**
     * @param $list
     * @return FilmCollection
     */
    protected function buildFilmCollection(iterable $list): FilmCollection
    {
        $collection = new FilmCollection([]);
        foreach ($list as $value) {
            $collection->add((new FilmBuilder($value))->create());
        }

        return $collection;
    }
}