<?php

namespace Code\Controller\Admin;

use Code\Authenticator\CheckUserLogged;
use Code\DB\Connection;
use Code\Entity\Category;
use Code\Security\Validator\Sanitizer;
use Code\Security\Validator\Validator;
use Code\Session\Flash;
use Code\View\View;
use URLify;

class CategoriesController
{
    use CheckUserLogged;

    public function __construct()
    {
        if (!$this->check()) return header('Location: ' . HOME . '/auth/login');
    }

    public function index()
    {
        $view = new View('admin/categories/index.phtml');
        $view->categories = (new Category(Connection::getInstance()))->findAll();

        return $view->render();
    }

    public function new()
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = $_POST;
                Sanitizer::sanitizeData($data, Category::$filters);

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/categories/new');
                }

                $category = new Category(Connection::getInstance());
                $data['slug'] = (new URLify())->slug($data['name']);


                $flashMessage = new Flash();

                if (!$category->insert($data)) {
                    $flashMessage->add('danger', 'Erro ao criar categoria!');
                    return header('Location: ' . HOME . '/admin/categories/new');
                }

                Flash::add('success', 'Categoria criado com sucesso!');
                return header('Location: ' . HOME . '/admin/categories');
            }

            $view = new View('admin/categories/new.phtml');

            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/categories');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/categories');
        }
    }

    public function edit($id = null)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $data = $_POST;
                Sanitizer::sanitizeData($data, Category::$filters);
                $data['id'] = (int) $id;

                if (!Validator::validateRequiredFields($data)) {
                    Flash::add('warning', 'Preencha todos os campos.');
                    return header('Location: ' . HOME . '/admin/categories/edit/' . $id);
                }

                $category = new Category(Connection::getInstance());
                $flashMessage = new Flash();

                if (!$category->update($data)) {
                    $flashMessage->add('danger', 'Erro ao editar esta categoria!');
                    return header('Location: ' . HOME . '/admin/categories/edit/' . $id);
                }

                Flash::add('success', 'Categoria atualizada com sucesso!');
                return header('Location: ' . HOME . '/admin/categories/edit/' . $id);
            }

            $view = new View('admin/categories/edit.phtml');
            $view->category = (new Category(Connection::getInstance()))->find($id);
            return $view->render();
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/categories');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/categories');
        }
    }

    public function remove($id = null)
    {
        try {
            $post = new Category(Connection::getInstance());

            if (!$post->delete($id)) {
                Flash::add('danger', 'Erro ao remover categoria!');
                return header('Location: ' . HOME . '/admin/categories/');
            }

            Flash::add('success', 'Categoria removida com sucesso!');
            return header('Location: ' . HOME . '/admin/categories/');
        } catch (\Exception $e) {
            if (APP_DEBUG) {
                Flash::add('danger', $e->getMessage());
                return header('Location: ' . HOME . '/admin/categories');
            }
            Flash::add('danger', 'Oops! Parece que ocorreu algum erro nos nossos servidores. Tente novamente mais tarde.');
            return header('Location: ' . HOME . '/admin/categories');
        }
    }

}
