<?php

namespace Code\Controller\Admin;

use Code\Authenticator\CheckUserLogged;
use Code\DB\Connection;
use Code\Entity\User;
use Code\Security\PasswordHash;
use Code\Security\Validator\Sanitizer;
use Code\Security\Validator\Validator;
use Code\Session\Flash;
use Code\View\View;

class UsersController
{

    use CheckUserLogged;

    public function __construct()
    {
        if (!$this->check()) return header('Location: ' . HOME . '/auth/login');
    }

    public function index()
    {
        $view = new View('admin/users/index.phtml');
        $view->users = (new User(Connection::getInstance()))->findAll();

        return $view->render();
    }

    public function new()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = $_POST;
                Sanitizer::sanitizeData($data, User::$filters);

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/users/new');
                }

                if (!Validator::validatePasswordMinStringLength($data['password'])) {
                    Flash::add('warning', 'A senha precisa ter no mínimo 6 caracteres.');
                    return header('Location: ' . HOME . '/admin/users/new');
                }

                if (!Validator::validatePasswordConfirm($data['password'], $data['password_confirm'])) {
                    Flash::add('warning', 'As senhas não são batem.');
                    return header('Location: ' . HOME . '/admin/users/new');
                }

                $post = new User(Connection::getInstance());

                $data['password'] = PasswordHash::hash($data['password']);

                unset($data['confirm_password']);

                $flashMessage = new Flash();

                if (!$post->insert($data)) {
                    $flashMessage->add('danger', 'Erro ao criar a usuario!');
                    return header('Location: ' . HOME . '/admin/users/new');
                }

                Flash::add('success', 'Usuário criado com sucesso!');
                return header('Location: ' . HOME . '/admin/users');
            }

            $view = new View('admin/users/new.phtml');
            $view->users = (new User(Connection::getInstance()))->findAll('id, first_name, last_name');

            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/users');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/users');
        }
    }

    public function edit($id = null)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = $_POST;
                Sanitizer::sanitizeData($data, User::$filters);
                $data['id'] = (int) $id;

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/users/edit/' . $id);
                }

                $user = new User(Connection::getInstance());

                if ($data['password']) {

                    if (!Validator::validatePasswordMinStringLength($data['password'])) {
                        Flash::add('warning', 'A senha precisa ter no mínimo 6 caracteres.');
                        return header('Location: ' . HOME . '/admin/users/edit/' . $id);
                    }

                    if (!Validator::validatePasswordConfirm($data['password'], $data['password_confirm'])) {
                        Flash::add('warning', 'As senhas não batem.');
                        return header('Location: ' . HOME . '/admin/users/edit/' . $id);
                    }
                    $data['password'] = PasswordHash::hash($data['password']);
                } else {
                    unset($data['password']);
                }
                unset($data['password_confirm']);


                $flashMessage = new Flash();

                if (!$user->update($data)) {
                    $flashMessage->add('danger', 'Erro ao editar este usuario!');
                    return header('Location: ' . HOME . '/admin/users/edit/' . $id);
                }

                Flash::add('success', 'Usuário atualizado com sucesso!');
                return header('Location: ' . HOME . '/admin/users/edit/' . $id);
            }

            $view = new View('admin/users/edit.phtml');
            $view->user = (new User(Connection::getInstance()))->find($id);

            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/users');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/users');
        }
    }

    public function remove($id = null)
    {
        try {
            $post = new User(Connection::getInstance());

            if (!$post->delete($id)) {
                Flash::add('danger', 'Erro ao remover usuario!');
                return header('Location: ' . HOME . '/admin/users');
            }

            Flash::add('success', 'Usuário removida com sucesso!');
            return header('Location: ' . HOME . '/admin/users');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/users');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/users');
        }
    }
}
