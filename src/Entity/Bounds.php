<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Entity;

use Maris\Interfaces\Geo\Aggregate\LocationAggregateInterface;
use Maris\Interfaces\Geo\Factory\BoundsFactoryInterface;
use Maris\Interfaces\Geo\Model\BoundsInterface;
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
}