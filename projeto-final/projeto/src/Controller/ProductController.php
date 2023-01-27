<?php
namespace Code\Controller;

use Code\DB\Connection;
use Code\Entity\Product;

class ProductController
{
    public function view($slug)
    {
        $product = (new Product(Connection::getInstance()))->where(['slug', $slug]);
        
        var_dump($product);
    }
}
