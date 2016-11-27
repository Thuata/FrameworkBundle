# Registries configuration

_Thuata Framework Bundle_ uses registries to fetch entities from their ids.

By default ot provides an ```ArrayRegistry``` and a ```DoctrineRegistry```.
 
You can implement your own registries witch must implement the ```RegistryInterface```.

Let see what that interface provides :

```php

namespace Thuata\ComponentBundle\Registry;
/**
 * <b>RegistryInterface</b><br>
 *
 *
 * @package thuata\componentbundle\Registry
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
interface RegistryInterface
{
    /**
     * Finds an item by key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function findByKey($key);

    /**
     * Finds a list of items by keys
     *
     * @param array $keys
     *
     * @return array
     */
    public function findByKeys(array $keys);

    /**
     * adds an item to the registry
     *
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @return void
     */
    public function add($key, $data);

    /**
     * Removes an item
     *
     * @param mixed $key
     *
     * @return void
     */
    public function remove($key);

    /**
     *
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @return void
     */
    public function update($key, $data);
}
```

Ok now lets see. We develop a ```YamlRegistry``` that will store the entities serialized
in files.

>That particular registry is quite useless, it is very consistent by also very slow. It
>would be a better bet to use a database. Unless you really can't or don't want to access
>a database.

Lets create the class :

```php

namespace AppBundle\Registry;

use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\ComponentBundle\Registry\ClassAwareInterface;

/**
 * YamlRegistry
 *
 * @package  AppBundle\Registry
 *
 * @author You <you@yourself.com>
 *
 * The ClassAwareInterface provides a setEntityClass method that is called
 * by the RegistryFactory to provide the entity class name to the registry
 *
 */
class YamlRegistry implements RegistryInterface, ClassAwareInterface
{
    // that constant will provide the path to the file according to the entity
    const FILE_FORMAT = '/var/entities/%s.yml

    /**
     * Finds an item by key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function findByKey($key)
    {
        // here we will provide the method to fetch an entity by its "key" (id)
    }

    /**
     * Finds a list of items by keys
     *
     * @param array $keys
     *
     * @return array
     */
    public function findByKeys(array $keys)
    {
        // Ok here something like a loop on the keys to call the findByKey method
        // and store the result in an array that will be returned
    }

    /**
     * adds an item to the registry
     *
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @return void
     */
    public function add($key, $data)
    {
        // Here we serialize the entity ($data) and add it to the yaml. Lets say 1
        // entity per line with something like :
        // entities:
        //     {id} : {serialized entity}
    }

    /**
     * Removes an item
     *
     * @param mixed $key
     *
     * @return void
     */
    public function remove($key)
    {
        // here we remove the line where we can find the entity
    }

    /**
     *
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @return void
     */
    public function update($key, $data)
    {
        // here we will update the line where the entity is found.
    }
    
    /**
     * Sets the entity class
     *
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass)
    {
        // we will use the entity class to know what file to write
    }
}
```

We will store in yaml files the entities. One file by entity class. We defined the constant
 ```FILE_FORMAT``` to store the string to pass to ```sptrinf``` to get full file path.
 
To get one file per entity class we can use the class name to retrieve the doctrine entity
name.

Remember the entities have a constant ```ENTITY_NAME``` providing the entity name.

Lets define the ```setEntityClass``` method and ```$filePath``` property :

```php
    /**
     * @var string
     */
    private $filePath;

    /**
     * Sets the entity class
     *
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass)
    {
        // We get the entity name from the ENTITY_NAME constant defined in the class
        $entityName =  constant(sprintf('%s::%s', $entityClass, 'ENTITY_NAME'));
        // We will use the entity name to name the file. But it as a ":" caracter
        // that is not allowed in file names. Lets replace it by a "-" :
        $fileName = strreplace(':', '-', $entityName);
        // Lets keep the file path :
        $this->filePath = sprintf(self::FILE_FORMAT, $fileName);
    }
```

Now we can access the file were the entities are stored through the ```$filePath``` property.

Lets write the ```add()``` method witch will be used to persist the entities in the files.

```php
use Symfony\Component\Yaml\Yaml;

    /**
     * adds an item to the registry
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @throws \Exception
     */
    public function add($key, $data)
    {
        $data = Yaml::parse(file_get_contents($this->filePath));

        $keys = array_keys($data['entities']);
        array_walk($keys, 'intval');

        if ($key === null) {
            $key = max($keys) + 1;
        }

        if (in_array($key, $keys)) {
            throw new \Exception('key already exists');
        }

        $data['entities'][(string) $key] = serialize($data);

        file_put_contents($this->filePath, Yaml::dump($data));
    }
```

The ```findByKey``` Method : 

```php
use Symfony\Component\Yaml\Yaml;

    /**
     * adds an item to the registry
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function findByKey($key)
    {
        $data = Yaml::parse(file_get_contents($this->filePath));

        if (in_array($key, $keys)) {
            return unserialize($data['entities'][(string) $key]);
        }

        return null;
    }
```

etc...

Once the registry is developed, we need to tell the bundle where to find it and when to use it.

In your ```config.yml``` file :

```yaml
thuata_framework:
    registries:
        yaml: "AppBundle\\Registry\\YamlRegistry"
```

You have to ways to tell the bundle to use it, each one for two particular case :

1. You need that registry for all you entities : in the ```config.yml``` file
2. You need it only for a particular entity : in the repsitory for that entity

In the ```config.yml``` file, list the registries to use under the ```default_registries```
entry. The registries will be used top to down to fetch entities and down to top to write
them.

```yaml
thuata_framework:
    registries:
        yaml: "AppBundle\\Registry\\YamlRegistry"
    default_registries:
        - array
        - yaml
        - doctrine
```

In that example, when fetching, the repository will search firstly in the ArrayRegistry
(array), then if not found in YamlRegistry (yaml)  and finally in DoctrineRegistry (doctrine).

When writting it will start from bottom to top to propagate the change.

If you are in the case you need only one entity to use the registry, simply overload the
 ```loadRegistries``` method of the repository :
 
 ```php
 
namespace AppBundle\Repository;

use AppBundle\Entity\TodoList;
use Thuata\FrameworkBundle\Repository\AbstractRepository;

/**
 * TodoListRepository
 *
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

    /**
     * Loads the registries
     */
    public function loadRegistries()
    {
        $this->addRegistry('array')
            ->addRegistry('yaml')
            ->addRegistry('doctrine');
    }
}
 ```
 
 >The default registries (array and doctrine) provide a ```NAME``` constant that hold
 >their name in the configuration. It is a good practice to do so and use it in the
 >```loadRegistries``` method.