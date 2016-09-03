<?php

namespace Thuata\FrameworkBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Thuata\ComponentBundle\Hydrator\ColumnHydrator;

class ThuataFrameworkBundle extends Bundle
{
    public function boot()
    {
        // init column hydrator
        $this->container->get('doctrine')->getManager()->getConfiguration()->addCustomHydrationMode(ColumnHydrator::HYDRATOR_MODE, ColumnHydrator::class);
    }
}
