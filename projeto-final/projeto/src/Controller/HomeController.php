<?php

namespace Code\Controller;

use Code\DB\Connection;
use Code\Entity\Category;
use Code\Entity\Product;
use Code\View\View;

class HomeController
{
    public function index()
    {
        $pdo = Connection::getInstance();

        $view = new View(view: 'site/index.phtml');
        $view->products = (new Product($pdo))->findAll();
        $view->categories = (new Category($pdo))->findAll('name, slug');
        return $view->render();
    }
}
