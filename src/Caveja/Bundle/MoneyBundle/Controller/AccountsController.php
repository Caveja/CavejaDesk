<?php

namespace Caveja\Bundle\MoneyBundle\Controller;

use Caveja\Bundle\MoneyBundle\Entity\Account;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;

class AccountsController extends FOSRestController
{
    const ENTITY_CLASS = 'Caveja\\Bundle\\MoneyBundle\\Entity\\Account';

    public function postAccountsAction(Request $request)
    {
        $om = $this->getAccountObjectManager();

        $account = new Account();
        $account->setName($request->request->get('name'));

        $om->persist($account);
        $om->flush();

        $view = $this->view(['id' => $account->getId()], 200);

        return $this->handleView($view);
    }

    public function getAccountsAction()
    {
        $view = $this->view($this->getAccountRepository()->findAll(), 200);

        return $this->handleView($view);
    }

    public function getAccountAction($id)
    {
        $view = $this->view($this->findAccount($id), 200);

        return $this->handleView($view);
    }

    public function postAccountAction(Request $request, $id)
    {
        $account = $this->findAccount($id);

        $om = $this->getAccountObjectManager();

        $account->setName($request->request->get('name'));
        $account = $om->merge($account);
        $om->flush();

        $view = $this->view($account, 200);

        return $this->handleView($view);
    }

    public function deleteAccountAction($id)
    {
        $account = $this->findAccount($id);

        $om = $this->getAccountObjectManager();
        $om->remove($account);
        $om->flush();

        $view = $this->routeRedirectView('caveja_money_get_accounts');

        return $this->handleView($view);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null|object
     */
    private function getAccountObjectManager()
    {
        return $this->getDoctrine()->getManagerForClass(self::ENTITY_CLASS);
    }

    /**
     * @return mixed
     */
    private function getAccountRepository()
    {
        return $this->getAccountObjectManager()->getRepository(self::ENTITY_CLASS);
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    private function findAccount($id)
    {
        $repo = $this->getAccountRepository();
        $account = $repo->find($id);

        if (!$account instanceof Account) {
            throw $this->createNotFoundException();
        }

        return $account;
    }
}
