<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 10:34
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Repository\Registry;

use MongoDB\BSON\ObjectID;
use MongoDB\Client;
use MongoDB\Collection;
use MongoDB\Driver\Cursor;
use Thuata\ComponentBundle\Bridge\Doctrine\ShortcutNotationParser;
use Thuata\ComponentBundle\Registry\ClassAwareInterface;
use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Document\AbstractDocument;
use Thuata\FrameworkBundle\Entity\Interfaces\DocumentSerializableInterface;

/**
 * Class MongoDBRegistry
 *
 * @package   Thuata\FrameworkBundle\Repository\Registry
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
class MongoDBRegistry implements RegistryInterface, MongoDBAwareInterface, ClassAwareInterface
{
    const NAME = 'mongodb';

    /**
     * @var Collection
     */
    private $collection;

    /**
     * @var string
     */
    private $entityClass;

    /**
     * Finds an item by key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function findByKey($key)
    {
        $document = $this->collection->findOne(['_id' => $key]);

        return $this->hydrateEntity($document);
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
        $result = [];
        /** @var Cursor $list */
        $list = $this->collection->find(['_id' => ['$in' => $keys]]);

        foreach ($list as $document) {
            $result[] = $this->hydrateEntity($document);
        }

        return $result;
    }

    /**
     * adds an item to the registry
     *
     *
     * @param mixed $key
     * @param mixed $data
     *
     * @throws \Exception
     */
    public function add($key, $data)
    {
        $toInsert = $this->getDocumentData($data);

        $result = $this->collection->insertOne($toInsert);

        $data->_id = $result->getInsertedId();
    }

    /**
     * Gets document data
     *
     * @param $document
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function getDocumentData($document)
    {
        if (is_array($document)) {
            $data = $document;
        } elseif ($document instanceof AbstractDocument) {
            $reflectionClass = new \ReflectionClass($document);
            $documentProperty = $reflectionClass->getParentClass()->getProperty('document');
            $documentProperty->setAccessible(true);
            $data = $documentProperty->getValue($document);
            foreach ($data as $key => &$value) {
                if ($value instanceof DocumentSerializableInterface) {
                    $value = $value->documentSerialize()->jsonSerialize();
                }
            }
        } else {
            throw new \Exception('Invalid data type, array or AbstractDocument expected');
        }

        return $data;
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
        $this->collection->deleteOne(['_id' => new ObjectID($key)]);
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
        $toUpdate = $this->getDocumentData($data);

        $this->collection->updateOne(['_id' => new ObjectID($key)], ['$set' => $toUpdate]);
    }

    /**
     * {@inheritdoc}
     */
    public function setMongoDBCollection(Collection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * Sets the entity name
     *
     * @param string $entityClass
     */
    public function setEntityClass(string $entityClass)
    {
        $this->entityClass = $entityClass;
    }

    /**
     * Hydrates a document entity with a mongo document
     *
     * @param mixed $document
     *
     * @return AbstractDocument
     *
     * @throws \Exception
     */
    private function hydrateEntity($document)
    {
        $class = $this->entityClass;
        $reflectionClass = new \ReflectionClass(AbstractDocument::class);
        $entity = new $class();

        if (!($entity instanceof AbstractDocument)) {
            throw new \Exception(sprintf('"%s" is not a subclass of "%s"', $this->entityClass, AbstractDocument::class));
        }

        $documentProperty = $reflectionClass->getProperty('document');
        $documentProperty->setAccessible(true);
        $documentProperty->setValue($entity, $document);

        return $entity;
    }
}