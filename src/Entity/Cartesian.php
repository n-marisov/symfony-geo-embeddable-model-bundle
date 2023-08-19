<?php

namespace Maris\Symfony\Geo\Embeddable\Model\Entity;

use Maris\Interfaces\Geo\Model\CartesianInterface;

/**
 * Точка на карте в Декартовой системе координат.
 */
class Cartesian implements CartesianInterface
{
    protected float $x;

    protected float $y;

    protected float $z;

    /**
     * @param float $x
     * @param float $y
     * @param float $z
     */
    public function __construct(float $x, float $y, float $z)
    {
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
    }

    /**
     * @return float
     */
    public function getX(): float
    {
        return $this->x;
    }

    /**
     * @return float
     */
    public function getY(): float
    {
        return $this->y;
    }

    /**
     * @return float
     */
    public function getZ(): float
    {
        return $this->z;
    }


    /**
     * Умножает все значения на переданное число.
     * @param float $value
     * @return $this
     */
    public function product( float $value ):self
    {
        $this->x *= $value;
        $this->y *= $value;
        $this->z *= $value;
        return $this;
    }

}