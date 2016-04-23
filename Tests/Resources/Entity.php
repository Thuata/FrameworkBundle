<?php
/**
 * Created by PhpStorm.
 * User: amaud_000
 * Date: 03/04/2016
 * Time: 15:49
 */

namespace Thuata\FrameworkBundle\Tests\Resources;

use Thuata\FrameworkBundle\Entity\AbstractEntity;

/**
 * Class Entity
 *
 * @package Thuata\FrameworkBundle\Tests\Resources
 */
class Entity extends AbstractEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $foo;

    /**
     * @var string
     */
    private $bar;

    /**
     * Gets id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets id
     *
     * @param int $id
     *
     * @return Entity
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Gets foo
     *
     * @return string
     */
    public function getFoo()
    {
        return $this->foo;
    }

    /**
     * Sets foo
     *
     * @param string $foo
     *
     * @return Entity
     */
    public function setFoo($foo)
    {
        $this->foo = $foo;
        return $this;
    }

    /**
     * Gets bar
     *
     * @return string
     */
    public function getBar()
    {
        return $this->bar;
    }

    /**
     * Sets bar
     *
     * @param string $bar
     *
     * @return Entity
     */
    public function setBar($bar)
    {
        $this->bar = $bar;
        return $this;
    }
}