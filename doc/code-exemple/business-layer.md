## Business layer

As said before, the business layer will resolve the needs defined by the
product owner.

The business layer is composed of services. witch can or can not be
symfony services.

Thuata Framework provides a service factory ```Thuata\FrameworkBundle\Service\ServiceFactory```
that is a symfony service.

You can access it from the container with the id ```thuata_framework.service.factory```

```php
/** @var $container ContainerInterface */
$serviceFactory = $container->get('thuata_framework.service.factory');
```

The service factory can retrieve a service by its class name or by its
symfony service id.

Keep in mind that your services must extend ```Thuata\FrameworkBundle\Service\AbstractService```
in order to be loaded by the thuata service factory and to be aware of
the __technical layer__.

If you need to inject dependencies to your service create a symfony
service and get it trough Thuata ServiceFactory by passing its id.

Lets have an example :

Service class definition :

```php

namespace AppBundle\Service;

use Thuata\FrameworkBundle\Service\AbstractService;

class MySymfonyService extends AbstractService
{
    // anything wonderfull to be done in your service
}
```

Configuration in ```services.yml```

```yml
services:
    app.service.my_symfony_service:
        # injection of my dependencies
        # No need to inject thuata service factory
```

Getting the service in code :

```php
$serviceFactory = $container->get('thuata_framework.service.factory');

$service = $serviceFactory->getService('app.service.my_symfony_service');

// do your business magic :)
```

If your service was not a symfony service :

```php
use AppBundle\Service\MySymfonyService;

...

$serviceFactory = $container->get('thuata_framework.service.factory');

$service = $serviceFactory->getService(MySymfonyService::class);

// do your business magic :)
```

The service factory will register all instances loaded, so during the
execution it will always serve the same instance of the service, even
if it has been gotten by its service id.

There is a limitation at this : if you got a service by a service id,
getting it by a class name will provide a new instance. You will have
two instances of the service, one with dependencies injected as a
symfony service and the other one without them.

We continue with our exemple : the TODO list application. Let's have a
reminder.

>We need to create an application that will manage todo lists.
>
> Here are the needs :
>- As a user I can create a list with a name
>- As a user I can create a todo in a list with a content
>- As a user I can order my todos
>- As a user I can see a list of lists
>- As a user I can see a list of todos
>- As a user I can mark a todo as DONE
>- As a user I can remove a todo
>- As an admin I can see a chart with the number of todos created by day
>on a sliding month
>
>We work on the first story : __As a user I can create a list with a
>name__

It is a good practice to give a specific role to a service that is binded
to similar business needs. for our example we may imagine :

- A service for administration
- A service for todos and list management (creation / deletion, etc.)
- A service for todos and list fetching

So lets create our first service. It's the one that will manage todos
and list. Let's call it ```TodoManagementService```.

We don't need any dependency injection there, so we do not need to
create a service id. But we will still place it in the Service directory
of the bundle to keep things at place.

But first of all we need an entity : the list.

Entities are representation of the data sotred an manipulated by the
application. It's exactly the same kind of data generated with doctrine.

By the way you could generate it with doctrine :) witch is a very nice
tool.

The entity will be a ```TodoList``` object. It will contain :
- A private property ```$id (int)``` to have a unique identification
- A private property ```$name (string)```
- A fluent setter for name : ```setName(string $name): TodoList```
- A getter for name: ```getName(): string```
- A getter for id: ```getId(): string```

To be used by the bundle the entities should extend
the ```Thuata\FrameworkBundle\Entity\AbstractEntity``` class.

The definition file will be placed in the dir ```<bundle>/Entity/```

Ok lets create the entity file ```TodoList.php``` :

```
<your project>/
├─ app/
├─  bin/
├─ src/
│   └─ AppBundle/
│       ├─ Controller/
│       ├─ Entity/
│       │   └─ List.php
│       ├─ Resources/
│       └─ AppBundle.php
├─ var/
├─ vendor/
└─ web/
```

And write the class definition :

```php

namespace AppBundle\Entity;

use Thuata\FrameworkBundle\Entity\AbstractEntity;

/**
 * <b>TodoList</b><br>
 *
 *
 * @package AppBundle\Entity
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoList extends AbstractEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Gets the entity id
     *
     * @return int|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets Name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Sets Name
     *
     * @param string $name
     *
     * @return TodoList
     */
    public function setName($name): TodoList
    {
        $this->name = $name;

        return $this;
    }
}
```

Now the List entity is done, lets create our service file :

```
<your project>/
├─ app/
├─  bin/
├─ src/
│   └─ AppBundle/
│       ├─ Controller/
│       ├─ Entity/
│       │   └─ TodoList.php
│       ├─ Resources/
│       ├─ Service/
│       │   └─ TodoManagementService.php
│       └─ AppBundle.php
├─ var/
├─ vendor/
└─ web/
```

And the class definition :

```php
<?php

namespace AppBundle\Service;

use Thuata\FrameworkBundle\Service\AbstractService;

/**
 * <b>TodoManagementService</b><br>
 *
 *
 * @package AppBundle\Service
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoManagementService extends AbstractService 
{
}
```

Now we need a method to save the list from its name :

In ```TodoManagementService``` :

```php
use AppBundle\Entity\TodoList;

...

    /**
     * Creates a new TodoList
     *
     * @param string $name
     *
     * @return \AppBundle\Entity\TodoList
     */
    public function createList(string $name): TodoList
    {
        $list = '?'; // Call the technical layer to create the new TodoList

        $list->setName($name);
        
        // ask the technical layer to save the TodoList

        return $list;
    }
    
...
```

In the method we let the technical layer create the new instance of the
TodoList entity. This will allow us to prepare the new instance.

In this exemple there is nothing to prepare, but let imagine we want to
add a creation date and an edition date, the thechnical layer would set
the creation date before returning the new instance.

We also will let the technical layer save the todolist. Before
persisting the entity it will be able to prepare it. With the dates
exemple it could modify the update date each time the entity is
persisted.

Ok its time to dive into the [Technical Layer](code-exemple/technical-layer.md).