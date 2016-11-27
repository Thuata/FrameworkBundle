# Data Layer

The Data layer is composed of repositories and registries.
 
Registires are connectors to various storage systems witch allow to fetch entities by their ids.

Registries can store entities in database, an array in memory or a cache system. By default
```ThuataFrameworkBundle``` will provide an ```ArrayRegistry``` and a ```DoctrineRegistry```.

The first on stores entities in an array during execution and the second one stores entities in
database through Doctrine. The first one is very fast but completely not persistent and the
second one is totaly persistant but slower. By using both of those registries the repository
will be able to access the entities faster if requested multiple times.

Repositories (witch are NOT Doctrine's ```EntityRepository```) will fetch entities ids
corresponding to a query and use the registries to load entities from those ids.

When the manager calls the repository to get entities, it runs a query to load ids matching
the request from the manager. From thoses ids it then calls the ```ArrayRegistry``` to fetch
the entities. If not all entities are found the missing one will be fetched from the
 ```DoctrineRegistry```.
 
It is possible to modify the default behaviour the add, remove or replace registries.

The Bundle [registries configuration](../configuration/registries.md) allows that.

When you create an entity you must also create the corresponding repository. The repository
 must extend ```Thuata\FrameworkBundle\Repository\AbstractRepository```. That parent class
 has an abstract method ```getEntityClass(): string``` that should be defined and should
 return the Entity class name.
 
The entity must also provide a ```ENTITY_NAME``` constant containing its entity name for
Doctrine.

If we get back to our exemple :

 : the TODO list application. Let's have a
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

We did all the job from user layer to technical layer. For the data layer, if we keep
 ```ThuataFrameworkBundle``` defaults, we just have to create the repository for the
 ```TodoList``` entity and add the ```ENTITY_NAME``` constant.
 
First we create the PHP file for the repository and call it ```TodoListRepository.php```
in the ```Repository``` directory of our bundle. The file system will then be :

```
<your project>/
├─ app/
├─  bin/
├─ src/
│   └─ AppBundle/
│       ├─ Controller/
│       ├─ Entity/
│       │   └─ TodoList.php
│       ├─ Manager/
│       │   └─ TodoListManager.php
│       ├─ Repository/
│       │   └─ TodoListRepository.php
│       ├─ Resources/
│       ├─ Service/
│       │   └─ TodoManagementService.php
│       └─ AppBundle.php
├─ var/
├─ vendor/
└─ web/
```

ANd the content of our repository :

```php
namespace AppBundle\Repository;

use AppBundle\Entity\TodoList;
use Thuata\FrameworkBundle\Repository\AbstractRepository;

/**
 * TodoListRepository
 *
 * @package AppBundle\Repository
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoListRepository extends AbstractRepository
{
    /**
     * Gets the entity class
     *
     * @return string
     */
    public function getEntityClass(): string
    {
        return TodoList::class;
    }
}
```

And we add the constant to our Entity :

```php
namespace AppBundle\Entity;

use Thuata\FrameworkBundle\Entity\AbstractEntity;

/**
 * TodoList
 *
 * @package AppBundle\Entity
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoList extends AbstractEntity
{
    const ENTITY_NAME = 'AppBundle:TodoList';
    // ... all other entity stuff
}
```

We are done. We have wrote all the stack for the TodoList entity and have done the treatment
to create one.