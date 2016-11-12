<?php

namespace Thuata\FrameworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thuata\ComponentBundle\Hydrator\ColumnHydrator;
<<<<<<< HEAD

class ThuataFrameworkBundle extends Bundle
{
=======
use Thuata\FrameworkBundle\Repository\Registry\ArrayRegistry;
use Thuata\FrameworkBundle\Repository\Registry\DoctrineRegistry;
use Thuata\FrameworkBundle\Repository\Registry\MongoDBRegistry;
use Thuata\FrameworkBundle\Repository\Registry\RegistryFactory;

class ThuataFrameworkBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
>>>>>>> feature/multi
    public function boot()
    {
        // init column hydrator
        $this->container->get('doctrine')->getManager()->getConfiguration()->addCustomHydrationMode(ColumnHydrator::HYDRATOR_MODE, ColumnHydrator::class);
<<<<<<< HEAD
=======
        RegistryFactory::registerRegistry(ArrayRegistry::NAME, ArrayRegistry::class);
        RegistryFactory::registerRegistry(DoctrineRegistry::NAME, DoctrineRegistry::class);
        RegistryFactory::registerRegistry(MongoDBRegistry::NAME, MongoDBRegistry::class);
>>>>>>> feature/multi
    }
}
