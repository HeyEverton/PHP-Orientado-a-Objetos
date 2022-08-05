<?php

trait MyTrait
{
    public function hello()
    {
        return 'Hello World';
    }
}

trait MyTrait2
{
    public function showName($name)
    {
        return 'Hello, ' . $name;
    }

    public function hello()
    {
        return 'Hello World 2';
    }
}

class Client 
{
    use MyTrait, MyTrait2{
        MyTrait::hello insteadof MyTrait2;
    }
}

$c= new Client();
print $c->hello();
print '<br/>';
print $c->showName('Everton');