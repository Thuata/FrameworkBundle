<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 11:31
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Entity;
use Thuata\FrameworkBundle\Document\AbstractDocument;
use Thuata\FrameworkBundle\Entity\AbstractEntity;
use Thuata\FrameworkBundle\Entity\DocumentSerialization;
use Thuata\FrameworkBundle\Entity\Interfaces\DocumentSerializableInterface;
use Thuata\FrameworkBundle\Entity\Interfaces\DocumentSerializationInterface;
use Thuata\FrameworkBundle\Tests\Resources\Manager\DocumentSerializableManager;


/**
 * Class DocumentSerializableEntity
 *
 * @package   Thuata\FrameworkBundle\Tests\Resources\Entity
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class DocumentSerializableEntity extends AbstractEntity implements DocumentSerializableInterface
{
    private $id;

    private $string;

    private $integer;

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
     * Gets string
     *
     * @return mixed
     */
    public function getString()
    {
        return $this->string;
    }

    /**
     * Sets string
     *
     * @param mixed $string
     *
     * @return DocumentSerializableEntity
     */
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Gets integer
     *
     * @return mixed
     */
    public function getInteger()
    {
        return $this->integer;
    }

    /**
     * Sets integer
     *
     * @param mixed $integer
     *
     * @return DocumentSerializableEntity
     */
    public function setInteger($integer)
    {
        $this->integer = $integer;

        return $this;
    }

    /**
     * Returns an array that will be stored as a document
     *
     * @return DocumentSerializationInterface
     */
    public function documentSerialize(): DocumentSerializationInterface
    {
        return new DocumentSerialization(DocumentSerializableManager::class, [
            'string' => $this->string,
            'integer' => $this->integer
        ]);
    }

    /**
     * Returns an instance of the entity from a document serialization
     *
     * @param DocumentSerialization $document
     */
    public function documentUnSerialize(DocumentSerialization $document)
    {
        $data = $document->getSerializedData();

        $this->string = $data['string'];
        $this->integer = $data['integer'];
    }
}