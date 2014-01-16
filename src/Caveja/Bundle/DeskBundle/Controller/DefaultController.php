<?php

namespace Caveja\Bundle\DeskBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->redirect($this->generateUrl('caveja_money_homepage'));
    }
}
