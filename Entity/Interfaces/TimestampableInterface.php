<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\FrameworkBundle\Entity\Interfaces;

use DateTime;

/**
 * <b>TimestampableInterface</b><br>
 * Interface to provide timestamp information on an entity (creationDate, updateDate)
 *
 * @package Thuata\FrameworkBundle\Entity\Interfaces
 *
 * @author Anthony Maudry <amaudry@gmail.com>
 */
interface TimestampableInterface
{
    /**
     * Sets the creation date
     *
     * @param DateTime $creationDate
     *
     * @return null|TimestampableInterface
     */
    public function setCreationDate(DateTime $creationDate);

    /**
     * Gets the creation date
     *
     * @return DateTime
     */
    public function getCreationDate();

    /**
     * Sets the edition date
     *
     * @param DateTime $creationDate
     *
     * @return null|TimestampableInterface
     */
    public function setEditionDate(DateTime $creationDate);

    /**
     * Gets the creation date
     *
     * @return DateTime
     */
    public function getEditionDate();
}
