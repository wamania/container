<?php

namespace Wamania\Container;

use Psr\Container\ContainerInterface;

/**
 * Class Container
 *
 * @package Wamania\Container
 * @author Wamania <wamania@gmail.com>
 * @license MIT
 */
class Container implements ContainerInterface
{
    const PARAMETER_PATTERN = '_parameter_%s';

    /**
     * Builded services
     * @var array
     */
    private $services;

    /**
     * Building services to find circulars references
     * @var array
     */
    private $building;

    /**
     * @var array
     */
    private $parameters;

    /**
     * Container constructor.
     * @param array $parameters
     */
    public function __construct(array $parameters = [])
    {
        $this->services = [];
        $this->building = [];
        $this->parameters = [];

        foreach ($parameters as $key => $value) {
            $this->addParameter($key, $value);
        }
    }

    /**
     * @inheritdoc
     */
    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (isset($this->building[$id])) {
            throw new ContainerException(sprintf('Circular reference on service: %s', $id));
        }

        if (!class_exists($id)) {
            throw new NotFoundException(sprintf('Class %s not found.', $id));
        }

        // get constructor parameters
        $reflectionClass = new \ReflectionClass($id);
        $constructor = $reflectionClass->getConstructor();

        $args = [];
        foreach ($constructor->getParameters() as $arg) {
            $type = $arg->getType();

            // if no type
            if (null == $type) {
                // is parameter ?
                if (isset($this->parameters[$arg->getName()])) {
                    $args[] = $this->parameters[$arg->getName()];
                    continue;
                }

                // else null ok
                if (($arg->isDefaultValueAvailable()) && (null === $arg->getDefaultValue())) {
                    $args[] = null;
                    continue;
                }

                throw new ContainerException(sprintf('Argument %s on %s have no type and cannot be null', $arg->getName(), $id));
            }

            $this->building[$id] = true;
            $args[] = $this->get($type->getName());
        }

        // our service
        $this->services[$id] = new $id(...$args);

        return $this->services[$id];
    }

    /**
     * @inheritdoc
     */
    public function has($id)
    {
        return (isset($this->services[$id]) || (class_exists($id)));
    }

    /**
     * @param string $key
     * @param mixed $value
     *
     * @return Container
     */
    public function addParameter(string $key, $value)
    {
        $this->parameters[sprintf(self::PARAMETER_PATTERN, $key)] = $value;

        return $this;
    }
}
