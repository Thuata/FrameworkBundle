<?php
/**
 * Created by Enjoy Your Business.
 * Date: 09/11/2016
 * Time: 14:07
 * Copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 */

namespace Thuata\FrameworkBundle\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;


/**
 * Trait ThuataControllerTrait
 *
 * @package   Thuata\FrameworkBundle\Controller
 *
 * @author    Emmanuel Derrien <emmanuel.derrien@enjoyyourbusiness.fr>
 * @author    Anthony Maudry <anthony.maudry@enjoyyourbusiness.fr>
 * @author    Loic Broc <loic.broc@enjoyyourbusiness.fr>
 * @author    Rémy Mantéi <remy.mantei@enjoyyourbusiness.fr>
 * @author    Lucien Bruneau <lucien.bruneau@enjoyyourbusiness.fr>
 * @author    Matthieu Prieur <matthieu.prieur@enjoyyourbusiness.fr>
 * @copyright 2014 Enjoy Your Business - RCS Bourges B 800 159 295 ©
 *
 * @property ContainerInterface $container
 */
trait ThuataControllerTrait
{
    /**
     * Gets the service factory
     *
     * @return \Thuata\FrameworkBundle\Service\ServiceFactory
     */
    protected function getServiceFactory()
    {
        return $this->container->get(ThuataControllerInterface::SERVICE_FACTORY_ID);
    }

    /**
     * Gets the manager factory
     *
     * @return \Thuata\FrameworkBundle\Manager\ManagerFactory
     */
    protected function getManagerFactory()
    {
        return $this->container->get(ThuataControllerInterface::MANAGER_FACTORY_ID);
    }

    /**
     * @return Request
     */
    protected function getCurrentRequest()
    {
        return $this->container->get('request_stack')->getCurrentRequest();
    }
}