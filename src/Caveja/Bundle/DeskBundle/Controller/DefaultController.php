<?php

namespace Caveja\Bundle\DeskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('CavejaDeskBundle:Default:index.html.twig', array('name' => $name));
    }
}
