<?php

namespace Wamania\Container\Tests\Service;

class F
{
    /**
     * @var B
     */
    private $b;

    /**
     * @var string
     */
    private $host;

    /**
     * @var string
     */
    private $user;

    /**
     * @var string
     */
    private $password;

    /**
     * F constructor.
     * @param B $b
     * @param $_parameter_host
     * @param $_parameter_user
     * @param $_parameter_password
     */
    public function __construct(B $b, $_parameter_host, $_parameter_user, $_parameter_password)
    {
        $this->b = $b;
        $this->host = $_parameter_host;
        $this->user = $_parameter_user;
        $this->password = $_parameter_password;
    }

    public function getB()
    {
        return $this->b;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
