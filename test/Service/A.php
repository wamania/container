<?php

namespace Wamania\Container\Tests\Service;

class A
{
    /**
     * @var B
     */
    private $b;

    /**
     * @var C
     */
    private $c;

    /**
     * A constructor.
     * @param B $b
     * @param C $c
     */
    public function __construct(B $b, C $c)
    {
        $this->b = $b;
        $this->c = $c;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getC()
    {
        return $this->c;
    }
}
