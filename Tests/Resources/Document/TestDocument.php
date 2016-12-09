<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 11:50
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Tests\Resources\Document;
use Thuata\FrameworkBundle\Document\AbstractDocument;
use Thuata\FrameworkBundle\Tests\Resources\Entity\DocumentSerializableEntity;


/**
 * Class TestDocument
 *
 * @package   Thuata\FrameworkBundle\Tests\Document
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class TestDocument extends AbstractDocument
{
    const ENTITY_NAME = 'FrameworkBundle:TestDocument';

    /**
     * Gets serializableEntity
     *
     * @return DocumentSerializableEntity
     */
    public function getSerializableEntity(): DocumentSerializableEntity
    {
        return $this->getMongoDocumentData('serializableEntity');
    }

    /**
     * Sets serializableEntity
     *
     * @param DocumentSerializableEntity $serializableEntity
     *
     * @return TestDocument
     */
    public function setSerializableEntity(DocumentSerializableEntity $serializableEntity): TestDocument
    {
        $this->setMongoDocumentData('serializableEntity', $serializableEntity);

        return $this;
    }
}