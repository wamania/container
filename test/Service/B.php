<?php

namespace Wamania\Container\Tests\Service;

class B
{
    /**
     * @var
     */
    private $c;

    /**
     * B constructor.
     * @param C $c
     */
    public function __construct(C $c)
    {
        $this->c = $c;
    }

    public function getC()
    {
        return $this->c;
    }
}
