<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Entity;

use Maris\Interfaces\Geo\Factory\FeatureFactoryInterface;
use Maris\Interfaces\Geo\Model\BoundsInterface;
use Maris\Interfaces\Geo\Model\FeatureInterface;
use Maris\Interfaces\Geo\Model\LocationInterface;

/**
 * Координаты точки.
 */
class Location implements LocationInterface
{
    private float $latitude;

    private float $longitude;

    /**
     * @param float $latitude
     * @param float $longitude
     */
    public function __construct( float $latitude, float $longitude )
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
    }

    public function getBounds(): BoundsInterface
    {
        return new Bounds(
            $this->latitude,
            $this->longitude,
            $this->latitude,
            $this->longitude
        );
    }

    public function toArray(): array
    {
        return [
            "type" => "Point",
            "coordinates" => [ $this->longitude, $this->latitude ]
        ];
    }

    public function toFeature(FeatureFactoryInterface $factory): FeatureInterface
    {
        return $factory->fromGeometry( $this );
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}