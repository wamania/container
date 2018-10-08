# Lazy load container
Simple PHP container with lazy load and autowiring

# Build a service
Each class of your project can be a service. 
```php
<?php

class OneService
{
}

$container = new Container();
$oneService = $container->get(OneService::class);
```

# Autowiring
if you have dependances between your services, the container will try to build them if it can.

```php
<?php

class OneService
{
}

class AnotherService
{
    private $oneService;
    
    public function __construct(OneService $oneService)
    {
        $this->oneService = $oneService;
    }
    
    public function getOneService()
    {
        return $this->oneService;
    }
}

$container = new Container();
$anotherService = $container->get(AnotherService::class);

$oneService = $anotherService->getOneService();
```

# Parameters
You can pass parameters to your container and inject them in your services


```php
<?php

class Db
{
    private $host;
    
    private $user;
    
    private $password;

    // we have defined Container::PARAMETER_PATTERN = '_parameter_%s'
    // if the container find the pattern in an argument, it inject the corresponding parameter value
    public function __construct($_parameter_host, $_parameter_user, $_parameter_password)
    {
        $this->host = $_parameter_host;
        $this->user = $_parameter_user;
        $this->password = $_parameter_password;
    }
}

```

```php
<?php

$parameters = [
    'host' => 'localhost',
    'user' => 'user',
    'password' => 'secret'
];

$container = new Container($parameters);
$db = $container->get(Db::class);
```
