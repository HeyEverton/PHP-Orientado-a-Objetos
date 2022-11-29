<?php 

class Cart
{
    private $item;

    public function addItem(Product $product)
    {
        $this->itens[] = $product;
    }

    public function getItems()
    {
        return $this->itens;
    }

}