<?php

namespace Thuata\FrameworkBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('ThuataFrameworkBundle:Default:index.html.twig', array('name' => $name));
    }
}
