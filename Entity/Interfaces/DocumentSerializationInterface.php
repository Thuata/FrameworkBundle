<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 10:22
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Entity\Interfaces;


/**
 * Interface DocumentSerializationInterface
 * Provides the entity manager and the data to store in the document.
 * This will allow to
 *
 * @package   Thuata\FrameworkBundle\Entity\Interfaces
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
interface DocumentSerializationInterface extends \JsonSerializable
{

    /**
     * The manager class to call when data is unserialized
     *
     * @return string
     */
    public function getManagerClass(): string;

    /**
     * The data to store in the document
     *
     * @return array
     */
    public function getSerializedData(): array;

    /**
     * Deserialize the data
     *
     * @param array $json
     *
     * @return DocumentSerializationInterface
     */
    public static function jsonDeserialize(array $json): DocumentSerializationInterface;
}