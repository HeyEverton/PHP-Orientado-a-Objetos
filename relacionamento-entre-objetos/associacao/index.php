<?php
require __DIR__ . '/Publishing.php';
require __DIR__ . '/Book.php';

$publishing = new Publishing();
$publishing->setName('Editora 1');
$publishing->setId(123);

$book = new Book();

$book->setTitle('O livro dos cinco aneis');
$book->setIsbn('11.2222.22.22');
$book->setPublishing($publishing);

print $book->getPublishing()->getName();
