# Technical Layer

The purpose of the business layer is to resolve technical constraints.

It will fetch, prepare and persist entities for the business layer. In
fact it will not _actually_ fetch or persist the entities. It will use
the data layer for those operations, but the entities will be prepared
before persist and after fetching.

The managers will also provide some methods to fetch entities in various
ways. Methods like ```getArticleBySlug(string $slug): Article```
or ```getArticlesByPage(int $page, int $nbByPage): array```.

The technical layer is composed of managers. A single manager exist for
an entity. This is the job of that particular manager to fetch and
persist that entity in the various ways needed by the business layer.

Managers can interact with each others and call the data layer to
perform fetching and persisting tasks. They can not interact with the
business layer.

The services from business layer (created from
the ```Thuata\FrameworkBundle\Service\ServiceFactory``` will have access
to the managers from a method to giving them access to
the ```Thuata\FrameworkBundle\Service\ManagerFactory```

Be careful, managers from the technical layer are not the doctrine's
EntityManager. They have completely different behaviours and purpose.

Managers must extend the ```Thuata\FrameworkBundle\Manager\AbstractManager```
class so the can access the data layer when factored by the manager
factory.

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

We needed to fetch a TodoList and persist it. First thing lets create
the TodoList manager :

Create the ```TodoListManager.php``` file :

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
│       ├─ Resources/
│       ├─ Service/
│       │   └─ TodoManagementService.php
│       └─ AppBundle.php
├─ var/
├─ vendor/
└─ web/
```

And its definition. Remember it must extend
the ```Thuata\FrameworkBundle\Manager\AbstractManager``` :

```php
namespace AppBundle\Manager;

use AppBundle\Entity\TodoList;
use Thuata\FrameworkBundle\Manager\AbstractManager;

/**
 * <b>TodoListManager</b><br>
 *
 *
 * @package AppBundle\Manager
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoListManager extends AbstractManager
{
    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return TodoList::class;
    }
}
```

The getEntityClassName method is required, it has to return the class
name of the entity managed by the manager.

That's it. As-is the manager provides some basics methods to fetch the
entities, we will come at this later.

Let's get back to our ```TodoManagementService``` defined in the
previous [Business Layer](code-exemple/business-layer.md) part of the
doc.

That service can access the ```TodoListManager``` from
the ```Thuata\FrameworkBundle\Service\ManagerFactory``` witch can be
accessed from the method ```$this->getManagerFactory()```

```php

use AppBundle\Entity\TodoList;
use AppBundle\Manager\TodoListManager;

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
        // get the manager factory
        $managerFactory = $this->getManagerFactory();
        
        // get the manager :
        // the manager factory has as method getManager(string $class)
        // that will return an instance of the $class manager
        $todoListManager = $managerFactory->getManager(TodoListManager::class); 
        
        $list = '?'; // Call the technical layer to create the new TodoList

        $list->setName($name);
        
        // ask the technical layer to save the TodoList

        return $list;
    }
    
...
```

Now lets checks the methods provided by the TodoListManager (from its
parent class ```Thuata\FrameworkBundle\Manager\AbstractManager```).

```php
class AbstractManager
{
    /**
     * Gets a new intance of an entity
     *
     * @return AbstractEntity
     */
    public function getNew(): AbstractEntity
    {}

    /**
     * Gets an entity by its ids
     *
     * @param integer $id
     *
     * @return AbstractEntity
     */
    public function getById($id): ?AbstractEntity
    {}

    /**
     * Gets Entities by criteria ...
     *
     * @param array $criteria
     * @param array $orders
     * @param int   $limit
     * @param int   $offset
     *
     * @return array
     */
    public function getEntitiesBy(array $criteria = [], array $orders = [], $limit = null, $offset = null): array
    {}

    /**
     * Gets an entitiy matching criteria
     *
     * @param array $criteria
     * @param array $orders
     * @param int   $offset
     *
     * @return AbstractEntity
     */
    public function getOneEntityBy(array $criteria = [], array $orders = [], $offset = null): ?AbstractEntity
    {}

    /**
     * Get entities with id in $ids
     *
     * @param array $ids
     *
     * @return array
     */
    public function getByIds(array $ids): array
    {}

    /**
     * Persists an entity
     *
     * @param AbstractEntity $entity
     */
    public function persist(AbstractEntity $entity)
    {}

    /**
     * Removes an entity
     *
     * @param AbstractEntity $entity
     */
    public function remove(AbstractEntity $entity)

    /**
     * Gets all entities
     *
     * @return array
     */
    public function getAll(): array
    {}

    /**
     * Gets all entities not deleted. Works with the interface
     * SoftDeleteInterface
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getAllNotDeleted(): array
    {}
}
```

The AbstractManager class also provide a bunch of protected method that
can be overridden.

```php
class AbstractManager
{
    /**
     * Prepares an entity, setting its default values
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForNew(AbstractEntity $entity): bool
    {
    }

    /**
     * Prepares an entity when retrieved from database
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForGet(AbstractEntity $entity): bool
    {
    }

    /**
     * Prepares an entity for persist
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForPersist(AbstractEntity $entity): bool
    {
    }

    /**
     * Prepares an entity for remove
     *
     * @param AbstractEntity $entity
     *
     * @return boolean
     */
    protected function prepareEntityForRemove(AbstractEntity $entity): bool
    {
    }

}
```

Those methods are preparators. They actualy prepare the entity for the
action the manager was told to execute :
- When a new entity is required from the manager it is prepared through
the ```prepareEntityForNew()``` method after its instanciation
- When an entity is fetched from the manager it is prepared through
the ```prepareEntityForGet()``` method after it is fetched.
- When an entity is persisted from the manager it is prepared through
the ```prepareEntityForPersist()``` method before it is persisted.
- When an entity is removed from the manager it is prepared through
the ```prepareEntityForRemove()``` method before the removal.

If you need to override those methods (and you will) keep in mind that
they should return a boolean. If it returns true the operation continues
normally. If false is returned the operation is stopped for that entity.

>Note that it is a good practice to call the parent method when you
>override one of those. As they may have their own automatic behaviors.
>For instance the ```prepareEntityForNew()``` will set a creation data
>to the entity if it implements the right interface.
>(```Thuata\FrameworkBundle\Entity\Interfaces\TimestampableInterface```)

Back to our TodoListManager. We don't need any particular preparator for
a new entity. But we need to check if a TodoList exists this the same
name. So we will override the ```prepareEntityForPersist()``` method to
do that check.

```php
namespace AppBundle\Manager;

use AppBundle\Entity\TodoList;
use Thuata\FrameworkBundle\Manager\AbstractManager;

/**
 * <b>TodoListManager</b><br>
 *
 *
 * @package AppBundle\Manager
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoListManager extends AbstractManager
{
    /**
     * Returns the class name for the entity
     *
     * @return string
     */
    protected function getEntityClassName(): string
    {
        return TodoList::class;
    }

    //region Preparators
    /**
     * Overrides the AbstractManager::prepareEntityForPersist method to check if a TodoList with the same name exists
     *
     * @param \Thuata\FrameworkBundle\Entity\AbstractEntity $entity
     *
     * @return bool
     *
     * @throws \Exception
     */
    protected function prepareEntityForPersist(AbstractEntity $entity): bool
    {
        $res = parent::prepareEntityForPersist($entity); // The parent method will return a boolean

        if ($res) { // If false no need to do anything, the entity won't be persisted
            $existing = $this->getOneEntityBy([ // That method will return a single entity matching ...
                'name' => $entity->getName()    // ... name property == $entity->getName()
            ]);

            if ($existing instanceof TodoList) {
                // Here we can just set $res to false or return false. But I prefer throwing an exception
                // Most of time I would suggest to define a custom exception that could be easily catch
                // to display a nice error to the user. Well, it's a demo...
                throw new \Exception('A list with that name already exists');
            }
        }

        return $res;
    }
    //endregion
}
```

So now that our manager is done let the service use it.
 
```php
namespace AppBundle\Service;

use AppBundle\Entity\TodoList;
use AppBundle\Manager\TodoListManager;
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
    /**
     * Creates a new TodoList
     *
     * @param string $name
     *
     * @return \AppBundle\Entity\TodoList
     */
    public function createList(string $name): TodoList
    {
        // We get the manager
        $manager = $this->getManagerFactory()->getManager(TodoListManager::class);
        // We get a new instance of TodoList
        /** @var TodoList $list */
        $list = $manager->getNew();

        $list->setName($name);

        // we persist the entity
        $manager->persist($list);

        return $list;
    }
}
```

And now the User Layer (Controller)

```php

namespace AppBundle\Controller;

use AppBundle\Service\TodoManagementService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * <b>TodoController</b><br>
 *
 *
 * @package AppBundle\Controller
 *
 * @author  Anthony Maudry <anthony.maudry@thuata.com>
 */
class TodoController extends Controller
{
    /**
     * Index action
     *
     * @return Response
     *
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('Todo/index.html.Twig');
    }

    /**
     * Action to create a new list
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/list/create-list.html", name="create_list")
     */
    public function createListAction(Request $request)
    {
        $formBuilder = $this->createFormBuilder();

        $formBuilder->add('name', 'text', [
            'label' => 'Name'
        ]);

        $form = $formBuilder->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $name = $form->get('name')->getData();

            /** @var TodoManagementService $service */
            $service = $this->container->get('thuata_framework.servicefactory')->getService(TodoManagementService::class);

            $service->createList($name);

            // We redirect to home for the moment with a 201 "CREATED" HTTP status
            return $this->redirect($this->generateUrl('home', 201));
        }

        return $this->render('Todo/create-list.html.twig', [
            'listForm' => $form->createView()
        ]);
    }
}
```

Ok we are almost done. In the manager we used the method ```getOneEntityBy(array $criteria, ...)```.

That method is a built-in one from the AbstractManager that will interrogate the data layer to fetch
entities.

So move on to the [Data Layer](data-layer.md)