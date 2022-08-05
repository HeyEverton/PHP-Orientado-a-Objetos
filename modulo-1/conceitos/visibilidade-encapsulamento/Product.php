<?php

class Product
{
    private $name;
    private $price;
    private $description;
    private $category;

    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        return $this->name;
    }
//
    public function getPrice()
    {
        return $this->price;
    }
    public function setPrice($price)
    {
        return $this->price;
    }
//
    public function getDescription()
    {
        return $this->description;
    }
    public function setDescription($description)
    {
        return $this->description;
    }
//
    public function getCategory()
    {
        return $this->category;
    }
    public function setCategory($category)
    {
        return $this->category;
    }
}
$product = new Product();
$product->name = 'OK';

