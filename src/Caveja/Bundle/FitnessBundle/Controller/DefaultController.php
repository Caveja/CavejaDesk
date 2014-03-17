<?php

namespace Caveja\Bundle\FitnessBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CavejaFitnessBundle:Default:index.html.twig', array('name' => $name));
    }
}
