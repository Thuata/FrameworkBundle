<?php

namespace Thuata\FrameworkBundle;

use Doctrine\ORM\Configuration;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thuata\ComponentBundle\Hydrator\ColumnHydrator;
use Thuata\FrameworkBundle\Bridge\Doctrine\EntityHydrator;
use Thuata\FrameworkBundle\Repository\Registry\ArrayRegistry;
use Thuata\FrameworkBundle\Repository\Registry\DoctrineRegistry;
use Thuata\FrameworkBundle\Repository\Registry\MongoDBRegistry;
use Thuata\FrameworkBundle\Repository\Registry\RegistryFactory;

class ThuataFrameworkBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        // init column hydrator
        /** @var Configuration $doctrineConfiguration */
        $doctrineConfiguration = $this->container->get('doctrine')->getManager()->getConfiguration();
        $doctrineConfiguration->addCustomHydrationMode(ColumnHydrator::HYDRATOR_MODE, ColumnHydrator::class);
        $doctrineConfiguration->addCustomHydrationMode(EntityHydrator::HYDRATOR_MODE, EntityHydrator::class);
        RegistryFactory::registerRegistry(ArrayRegistry::NAME, ArrayRegistry::class);
        RegistryFactory::registerRegistry(DoctrineRegistry::NAME, DoctrineRegistry::class);
        RegistryFactory::registerRegistry(MongoDBRegistry::NAME, MongoDBRegistry::class);
    }
}
