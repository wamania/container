# container
Simple PHP container with lazy load and autowiring

# Build a service
Each class of your project can be a service. 
```php

class OneService
{
}

$container = new Container();
$oneService = $container->get(OneService::class);
```

# Autowiring
if you have dependances between your services, the container will try to build them if it can.

```php
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
