<?php

namespace Caveja\Bundle\MoneyBundle\Controller;

use Caveja\Bundle\MoneyBundle\Entity\Account;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AccountsController extends FOSRestController
{
    public function postAccountsAction(Request $request)
    {
        $om = $this->getDoctrine()->getManagerForClass('Caveja\\Bundle\\MoneyBundle\\Entity\\Account');

        $account = new Account();
        $account->setName($request->request->get('name'));

        $om->persist($account);
        $om->flush();

        $view = $this->view(['id' => $account->getId()], 200);

        return $this->handleView($view);
    }
}
