# Lazy load container
Simple PHP container with lazy load and autowiring

# install
```bash
composer require wamania/container
```

# Get a service
Each class of your project can be a service. 
```php
<?php

use Wamania\Container;

class OneService
{
}

$container = new Container();
$oneService = $container->get(OneService::class);
```
Throw an NotFoundException if the service has not been built yet and if the class doesn't exists.

# Has a service ?
```php
<?php

use Wamania\Container;

$container = new Container();
$oneService = $container->has(OneService::class);
```
Return true if the service has been built or if the class exists, otherwise return false

# Autowiring
if you have dependances between your services, the container will try to build them if it can.

```php
<?php

use Wamania\Container;

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
Be careful to circular reference : 
 - if OneService need AnotherService
 - AND if AnotherService need OneService
 
 the container will throw a ContainerException.
 
 If you try to inject an argument which is neither a class/service nor a parameter, and which cannot be null by default, it will throw a ContainerException.

# Parameters
You can pass parameters to your container and inject them in your services.

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

use Wamania\Container;

$parameters = [
    'host' => 'localhost',
    'user' => 'user',
    'password' => 'secret'
];

$container = new Container($parameters);
$db = $container->get(Db::class);
```
