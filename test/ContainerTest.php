<?php

namespace Wamania\Container\Tests;

use PHPUnit\Framework\TestCase;
use Wamania\Container\Container;
use Wamania\Container\ContainerException;
use Wamania\Container\Tests\Service\A;
use Wamania\Container\Tests\Service\B;
use Wamania\Container\Tests\Service\C;
use Wamania\Container\Tests\Service\D;
use Wamania\Container\Tests\Service\E;
use Wamania\Container\Tests\Service\F;

class ContainerTest extends TestCase
{
    public function testAutowire()
    {
        $container = new Container();
        $a = $container->get(A::class);

        $this->assertInstanceOf(B::class, $a->getB());
        $this->assertInstanceOf(C::class, $a->getC());

        $b = $a->getB();

        $this->assertInstanceOf(C::class, $b->getC());
    }

    public function testNull()
    {
        $container = new Container();
        $d = $container->get(D::class);

        $this->assertInstanceOf(B::class, $d->getB());
        $this->assertNull($d->getX());
    }

    public function testNotNull()
    {
        $container = new Container();

        $this->expectException(ContainerException::class);
        $e = $container->get(E::class);
    }

    public function testParameters()
    {
        $parameters = [
            'host' => 'localhost',
            'user' => 'user',
            'password' => 'password'
        ];

        $container = new Container($parameters);
        $f = $container->get(F::class);

        $this->assertInstanceOf(B::class, $f->getB());

        $this->assertSame($parameters['host'], $f->getHost());
        $this->assertSame($parameters['user'], $f->getUser());
        $this->assertSame($parameters['password'], $f->getPassword());
    }
}
