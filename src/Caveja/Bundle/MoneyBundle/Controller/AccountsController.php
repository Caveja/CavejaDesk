<?php

namespace Caveja\Bundle\MoneyBundle\Controller;

use Caveja\Bundle\MoneyBundle\Entity\Account;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $repo = $this->getAccountRepository();

        $account = $repo->find($id);

        if (!$account instanceof Account) {
            throw new NotFoundHttpException('Account not found');
        }

        $view = $this->view($account, 200);

        return $this->handleView($view);
    }

    public function postAccountAction(Request $request, $id)
    {
        $repo = $this->getAccountRepository();

        $account = $repo->find($id);

        if (!$account instanceof Account) {
            throw new NotFoundHttpException('Account not found');
        }

        $om = $this->getAccountObjectManager();

        $account->setName($request->request->get('name'));
        $account = $om->merge($account);
        $om->flush();

        $view = $this->view($account, 200);

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
}
