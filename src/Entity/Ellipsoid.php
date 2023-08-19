<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Entity;

use Maris\Interfaces\Geo\Model\EllipsoidInterface;

/***
 * Объект эллипсоида который можно хранить
 * в базе данных как встроенный класс.
 */
class Ellipsoid implements EllipsoidInterface
{

    protected float $polarRadius;

    protected float $equatorRadius;

    /**
     * @param float $polarRadius
     * @param float $equatorRadius
     */
    public function __construct( float $polarRadius, float $equatorRadius )
    {
        $this->polarRadius = $polarRadius;
        $this->equatorRadius = $equatorRadius;
    }


    /**
     * @inheritDoc
     */
    public function getPolarRadius(): float
    {
        return $this->polarRadius;
    }

    /**
     * @inheritDoc
     */
    public function getEquatorRadius(): float
    {
        return $this->equatorRadius;
    }

    /**
     * @inheritDoc
     */
    public function getArithmeticMeanRadius(): float
    {
        return ($this->polarRadius + $this->equatorRadius) / 2 ;
    }

    /**
     * @inheritDoc
     */
    public function getFlattening(): float
    {
        return 1 / $this->getReverseFlattening();
    }

    /**
     * @inheritDoc
     */
    public function getReverseFlattening(): float
    {
        return ($this->equatorRadius - $this->polarRadius) / $this->equatorRadius;
    }
}