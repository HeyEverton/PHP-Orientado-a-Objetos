<?php

class Product {

    // public $props = [];

    // public function __set($name, $value)
    // {
    //     $this->props[$name] = $value;
    // }

    // public function __get($name)
    // {
    //     return $this->props[$name];
    // }
    public function __call($name, $params)
    {
        print_r([$name, $params]);
    }
    public static function __callStatic($name, $params)
    {
        print_r([$name, $params]);
    }
}
print Product::getConnection();

$produto = new Product();
$produto->save('Produto 1', 19.99);

// print $produto->price;
















// $produto->name = 'Nome do Produto';
// $produto->price = 19.99;