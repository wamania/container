<?php

namespace Wamania\Container\Tests\Service;

class D
{
    /**
     * @var B
     */
    private $b;

    /**
     * @var mixed
     */
    private $x;

    /**
     * A constructor.
     * @param B $b
     * @param mixed $x
     */
    public function __construct(B $b, $x = null)
    {
        $this->b = $b;
        $this->x = $x;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getX()
    {
        return $this->x;
    }
}
