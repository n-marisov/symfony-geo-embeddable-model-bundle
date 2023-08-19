<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Factory;

use Maris\Interfaces\Geo\Aggregate\LocationAggregateInterface;
use Maris\Interfaces\Geo\Factory\CartesianFactoryInterface;
use Maris\Interfaces\Geo\Model\CartesianInterface;
use Maris\Interfaces\Geo\Model\EllipsoidInterface;
use Maris\Interfaces\Geo\Model\LocationInterface;
use Maris\Symfony\Geo\Embeddable\Model\Entity\Cartesian;

class CartesianFactory implements CartesianFactoryInterface
{

    protected EllipsoidInterface $ellipsoid;

    /**
     * @param EllipsoidInterface $ellipsoid
     */
    public function __construct(EllipsoidInterface $ellipsoid)
    {
        $this->ellipsoid = $ellipsoid;
    }


    /**
     * @inheritDoc
     */
    public function new(float $x, float $y, float $z): CartesianInterface
    {
        return new Cartesian( $x, $y, $z );
    }

    /**
     * @inheritDoc
     */
    public function fromLocation(LocationInterface|LocationAggregateInterface $location): CartesianInterface
    {
        if(is_a($location,LocationAggregateInterface::class))
            $location = $location->getLocation();

        $latitude = deg2rad( 90 - $location->getLatitude() );
        $longitude = deg2rad( ($location->getLongitude() > 0) ? $location->getLongitude() : $location->getLongitude() + 360 );

        return $this->new(
            $this->ellipsoid->getArithmeticMeanRadius() * cos( $longitude ) * sin( $latitude ),
            $this->ellipsoid->getArithmeticMeanRadius() * sin( $longitude ) * sin( $latitude ),
            $this->ellipsoid->getArithmeticMeanRadius() * cos( $latitude )
        );
    }
}