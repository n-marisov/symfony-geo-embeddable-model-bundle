<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Entity;



use Maris\Interfaces\Geo\Aggregate\LocationAggregateInterface;
use Maris\Interfaces\Geo\Model\BoundsInterface;
use Maris\Interfaces\Geo\Model\GeometryInterface;
use Maris\Interfaces\Geo\Model\LocationInterface;


/**
 * Объект границ образованный двумя точками
 */
class Bounds implements BoundsInterface
{
    /**
     * Крайняя северная координата объекта.
     * @var float|null
     */
    protected ?float $north = null;

    /**
     * Крайняя западная координата объекта.
     * @var float|null
     */
    protected ?float $west = null;

    /**
     * Крайняя южная координата объекта.
     * @var float|null
     */
    protected ?float $south = null;

    /**
     * Крайняя восточная координата объекта.
     * @var float|null
     */
    protected ?float $east = null;

    /**
     * @param float $north
     * @param float $west
     * @param float $south
     * @param float $east
     */
    public function __construct( float $north, float $west, float $south, float $east )
    {
        $this->north = $north;
        $this->west = $west;
        $this->south = $south;
        $this->east = $east;
    }

    /**
     * @return float
     */
    public function getNorth(): float
    {
        return $this->north;
    }

    /**
     * @return float
     */
    public function getWest(): float
    {
        return $this->west;
    }

    /**
     * @return float
     */
    public function getSouth(): float
    {
        return $this->south;
    }

    /**
     * @return float
     */
    public function getEast(): float
    {
        return $this->east;
    }

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): array
    {
        return [ $this->north, $this->west, $this->south, $this->east ];
    }

    /**
     * @inheritDoc
     */
    public function someLocation(LocationInterface|LocationAggregateInterface $location): bool
    {
        if(is_a($location, LocationAggregateInterface::class))
            $location = $location->getLocation();

        return $this->getNorth() >= $location->getLatitude() && $this->getWest() <= $location->getLongitude() &&
            $this->getSouth() <= $location->getLatitude() && $this->getEast() >= $location->getLongitude();
    }

    /**
     * Объекты границ пересекаются если
     * одна из точек переданной границы
     * лежит внутри текущей границы.
     * @inheritDoc
     */
    public function intersection( BoundsInterface $bounds ): bool
    {
        $north = $bounds->getNorth(); //север +
        $west = $bounds->getWest(); //Запад -
        $south = $bounds->getSouth(); // Юг -
        $east = $bounds->getEast(); // Восток +

        // Проверяем NorthWest Северо-Западную точку.
        // $north поподает по высоте.
        if( $north <= $this->getNorth() && $north >= $bounds->getSouth() )
            if( $west >= $this->getWest() && $west <= $this->getEast())
                return true;

        // Проверяем SouthEast Юго-Восточную точку
        if( $south <= $this->getNorth() && $south >= $bounds->getSouth() )
            if( $east >= $this->getWest() && $east <= $this->getEast())
                return true;

        // Проверяем NorthEast Северо-Восточную точку
        if( $north <= $this->getNorth() && $north >= $bounds->getSouth() )
            if( $east >= $this->getWest() && $east <= $this->getEast())
                return true;

        // Проверяем SouthWest Северо-Западную точку
        if( $south <= $this->getNorth() && $south >= $bounds->getSouth() )
            if( $west >= $this->getWest() && $west <= $this->getEast())
                return true;

        return false;
    }

    /**
     * GeometryInterface без остатка входит в
     * объект текущих границ если его собственные границы
     * полностью вписаны в текущий объект.
     * @inheritDoc
     */
    public function contains(GeometryInterface $geometry): bool
    {
        $bounds = $geometry->getBounds();

        return $bounds->getNorth() <= $this->getNorth() && $bounds->getWest() >= $this->getWest() &&
            $bounds->getSouth() >= $this->getSouth() && $bounds->getEast() <= $this->getEast();

    }
}