<?php

namespace Code\Controller;

use Code\DB\Connection;
use Code\Entity\Category;
use Code\Entity\Post;
use Code\Session\Flash;
use Code\View\View;
use URLify;

class CategoryController
{
    public function index($slug)
    {
        try {
            $category = current((new Category(Connection::getInstance()))->where(['slug' => $slug]));

            $view = new View('site/category.phtml');
            $view->posts = (new Post(Connection::getInstance()))->where(['categories_id' => $category['id']]);
            $view->category = $category['name'];

            return $view->render();
        } catch (\Exception $e) {
            Flash::add('warning', 'Nenhuma postagem não foi encontrada com a categoria ' . $category['name']);
            header('Location: ' . HOME);
        }
    }
}
