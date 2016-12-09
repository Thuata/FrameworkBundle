<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/12/2016
 * Time: 10:41
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Entity;

use Thuata\FrameworkBundle\Entity\Interfaces\DocumentSerializationInterface;


/**
 * Class DocumentSerialization
 *
 * @package   Thuata\FrameworkBundle\Entity
 *
 * @author    Anthony Maudry <https://anthony-maudry.github.io>
 * @author    Enjoy Your Business <http://www.enjoyyourbusiness.fr>
 *
 * @copyright 2016 Anthony Maudry <https://anthony-maudry.github.io>
 */
class DocumentSerialization implements DocumentSerializationInterface
{
    /**
     * @var string
     */
    private $managerClass;

    /**
     * @var array
     */
    private $data;

    public function __construct(string $managerClass, array $data)
    {
        $this->managerClass = $managerClass;
        $this->data = $data;
    }

    /**
     * The manager class to call when data is unserialized
     *
     * @return string
     */
    public function getManagerClass(): string
    {
        return $this->managerClass;
    }

    /**
     *
     *
     * @return array
     */
    public function getSerializedData(): array
    {
        return $this->data;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
            'document_serialization' => [
                'manager_class' => $this->managerClass,
                'data' => $this->data
            ]
        ];
    }

    /**
     * Deserialize the data
     *
     * @param array $json
     *
     * @return DocumentSerializationInterface
     */
    public static function jsonDeserialize(array $json): DocumentSerializationInterface
    {
        $managerClass = $json['document_serialization']['manager_class'];
        $data = $json['document_serialization']['data'];

        return new self($managerClass, $data);
    }
}