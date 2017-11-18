<?php

namespace Controller;

class UserController extends AbstractSiteController
{
    /**
     * @param null $login
     * @param null $password
     */
    public function login($login = null, $password = null)
    {
        $errorMessage = ($login !== 'admin' || $password !== '123')
            ? 'Error login or password'
            : '';
        if (empty($errorMessage)) {
            $this->serviceProvider->getUserAuthService()->authorize(1);
            $this->request->redirect('/');
            die();
        }

        $this->view
            ->withParam('errorMessage', $errorMessage)
            ->withParam('login', $login)
            ->render('/user/login');
    }

    public function logout()
    {
        $this->serviceProvider->getUserAuthService()->logout();
        $this->request->redirect('/');
        die();
    }
}