<?php

class Animale {
    public $name;

    public function sleep()
    {
        return $this->name . ' are sleeping...';
    }
    public function eat()
    {
        return $this->name . ' are eating';
    }
}



class Dog extends Animale {

}

class Cat extends Animale {

}
$cat = new Cat();
$cat->name = 'Enma';
print $cat->eat();




$dog = new Dog();
$dog->name = 'Ted';

// print $dog->sleep();