 <?php
require __DIR__  . '/Cart.php';
require __DIR__  . '/Product.php';

$product = new Product();
$product->setId(1);
$product->setName('Dell Intel Core i5');
$product->setPrice(14.500);


$product2 = new Product();
$product2->setId(2);
$product2->setName('Asus Notebook Gamer');
$product2->setPrice(20.000);


$cart = new Cart();

$cart->addItem($product);
$cart->addItem($product2);

foreach ($cart->getItems() as $item) {
    print $item->getId() . ' ' . $item->getName() . ' ' . $item->getPrice() . "\n";
}