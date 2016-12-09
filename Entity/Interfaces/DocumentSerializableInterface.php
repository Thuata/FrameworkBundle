<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 10:21
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Entity\Interfaces;
use Thuata\FrameworkBundle\Entity\DocumentSerialization;

/**
 * Interface DocumentSerializableInterface
 * Specifies that the entity has specific behaviour when stored as
 * part of a document.
 *
 * @package   Thuata\FrameworkBundle\Entity\Interfaces
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
interface DocumentSerializableInterface
{
    /**
     * Returns an array that will be stored as a document
     *
     * @return DocumentSerializationInterface
     */
    public function documentSerialize(): DocumentSerializationInterface;

    /**
     * Returns an instance of the entity from a document serialization
     *
     * @param DocumentSerialization $document
     */
    public function documentUnSerialize(DocumentSerialization $document);
}