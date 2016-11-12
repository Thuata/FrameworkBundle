<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 10:34
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Repository\Registry;

use MongoDB\Client;
use MongoDB\Collection;
use Thuata\ComponentBundle\Registry\RegistryInterface;
use Thuata\FrameworkBundle\Document\AbstractDocument;

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
class MongoDBRegistry implements RegistryInterface, MongoDBAwareInterface
{
    const NAME = 'mongodb';

    /**
     * @var Collection
     */
    private $collection;

    /**
     * Finds an item by key
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function findByKey($key)
    {
        $this->collection->findOne(['_id' => $key]);
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
        $this->collection->findOne(['_id' => ['$in' => $keys]]);
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

        $this->collection->insertOne($toInsert);
    }

    /**
     * Gets document data
     *
     * @param $document
     *
     * @return array
     * @throws \Exception
     */
    protected function getDocumentData($document): array
    {
        if (is_array($document)) {
            $data = $document;
        } elseif ($document instanceof AbstractDocument) {
            $reflectionClass = new \ReflectionClass($document);
            $documentProperty = $reflectionClass->getProperty('document');
            $documentProperty->setAccessible(true);
            $data = $documentProperty->getValue($document);
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
        $this->collection->deleteOne(['_id' => $key]);
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

        $this->collection->updateOne(['_id' => $key], $toUpdate);
    }

    /**
     * {@inheritdoc}
     */
    public function setMongoDBCollection(Collection $collection)
    {
        $this->collection = $collection;
    }
}