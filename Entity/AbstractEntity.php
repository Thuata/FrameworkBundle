<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Thuata\FrameworkBundle\Entity;

/**
 * <b>AbstractEntity</b><br>
 * Base class for entities
 *
 * @package Thuata\FrameworkBundle\Entity
 *
 * @author  Anthony Maudry <amaudry@gmail.com>
 */
abstract class AbstractEntity
{
    const ENTITY_NAME = 'ThuataFrameworkBundle:AbstractEntity';

    /**
     * Gets the entity id
     *
     * @return int|string
     */
    abstract public function getId();
}
