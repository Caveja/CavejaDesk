<?php

namespace Caveja\Bundle\MoneyBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }
}
