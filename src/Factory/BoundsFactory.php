<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Factory;

use Maris\Interfaces\Geo\Aggregate\LocationAggregateInterface;
use Maris\Interfaces\Geo\Factory\BoundsFactoryInterface;
use Maris\Interfaces\Geo\Model\BoundsInterface;
use Maris\Interfaces\Geo\Model\LocationInterface;
use Maris\Symfony\Geo\Embeddable\Model\Entity\Bounds;

/***
 * Фабрика для создания границ фигуры.
 */
class BoundsFactory implements BoundsFactoryInterface
{

    public function new(float $north, float $west, float $south, float $east): BoundsInterface
    {
        return new Bounds( $north, $west, $south, $east );
    }

    public function fromLocations(LocationAggregateInterface|LocationInterface ...$locations): BoundsInterface
    {
        $latMin = 90.0;
        $latMax = -90.0;
        $lngMin = 180.0;
        $lngMax = -180.0;

        foreach ($locations as $location) {
            $latMin = min($location->getLatitude(), $latMin);
            $lngMin = min($location->getLocation(), $lngMin);
            $latMax = max($location->getLatitude(), $latMax);
            $lngMax = max($location->getLocation(), $lngMax);
        }

        return $this->new( $latMax, $lngMin, $latMin, $lngMax );
    }
}