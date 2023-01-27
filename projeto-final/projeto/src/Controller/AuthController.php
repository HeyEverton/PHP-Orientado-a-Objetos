<?php

namespace Code\Controller;

use Code\Authenticator\Authenticator;
use Code\DB\Connection;
use Code\Entity\User;
use Code\Session\Flash;
use Code\View\View;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            var_dump($_POST);
            $user = new User(Connection::getInstance());

            $authenticator = new Authenticator($user);

            if (!$authenticator->login($_POST)) {
                Flash::add('danger', "E-mail e/ou senha incorretos");
                return header("Location: " . HOME . '/auth/login');
            }
            Flash::add('success', 'Login feito com sucesso');
            return header("Location: " . HOME . '/admin/products');
        }
        $view = new View('auth/index.phtml');
        return $view->render();
    }

    public function logout()
    {
        $auth = (new Authenticator())->logout();
        Flash::add('success', 'Usuário deslogado com sucesso');
        return header("Location: " . HOME);
    }
}
