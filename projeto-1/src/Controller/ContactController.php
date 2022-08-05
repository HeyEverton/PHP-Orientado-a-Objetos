<?php

namespace Code\Controller;

use Code\View\View;

class ContactController
{
    public function index()
    {
        $view = new View(view: 'site/contact.phtml');
        return $view->render();
    }
}
