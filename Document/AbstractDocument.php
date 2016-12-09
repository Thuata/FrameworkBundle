<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 11:29
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Document;

use MongoDB\BSON\ObjectID;
use Thuata\FrameworkBundle\Entity\AbstractEntity;

/**
 * Class AbstractDocument
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */
abstract class AbstractDocument extends AbstractEntity
{
    const ENTITY_NAME = 'ThuataFrameworkBundle:AbstractDocument';

    /**
     * @var array
     */
    private $document;

    /**
     * Gets the document id
     *
     * @return string
     */
    public function getId(): ?string
    {
        if (array_key_exists('_id', $this->document)) {
            return $this->document['_id'];
        }

        return null;
    }

    /**
     * Gets a document property
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->getMongoDocumentData($name);
    }

    /**
     * Sets data to the document
     *
     * @param string $name
     * @param mixed  $value
     */
    function __set($name, $value)
    {
        $this->setMongoDocumentData($name, $value);
    }

    /**
     * Gets the original document
     *
     * @return array
     */
    public function getMongoDocument()
    {
        return $this->document;
    }

    /**
     * Gets data from the document
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function getMongoDocumentData($name)
    {
        if (array_key_exists($name, $this->document)) {
            return $this->document[$name];
        }

        return null;
    }

    /**
     * Sets data to the document
     *
     * @param string $name
     * @param mixed  $value
     */
    protected function setMongoDocumentData($name, $value)
    {
        $this->document[$name] = $value;
    }
}