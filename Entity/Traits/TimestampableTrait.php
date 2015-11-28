<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\FrameworkBundle\Entity\Traits;

use DateTime;

/**
 * Trait defining properties and method to match TimestampableInterface
 *
 * @author Anthony Maudry <anthony.maudry@thuata.com>
 */
trait TimestampableTrait
{
    /**
     * @var DateTime
     */
    protected $creationDate;

    /**
     * @var DateTime
     */
    protected $editionDate;

    /**
     * Sets the creation date
     *
     * @param DateTime $creationDate
     *
     * @return TimestampableInterface
     */
    public function setCreationDate(DateTime $creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Gets the creation date
     *
     * @return DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Sets the edition date
     *
     * @param DateTime $editionDate
     *
     * @return TimestampableInterface
     */
    public function setEditionDate(DateTime $editionDate)
    {
        $this->editionDate = $editionDate;

        return $this;
    }

    /**
     * Gets the creation date
     *
     * @return DateTime
     */
    public function getEditionDate()
    {
        return $this->editionDate;
    }
}
