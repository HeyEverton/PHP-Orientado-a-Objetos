<?php
//public
//protected
//private

class Person {
    public $name;
    protected $age;
 
    public function showName()
    {
        return $this->name;
    }
}

$person = new Person();
$person->name = 'Everton';
$person->age = 19;

print $person->name; 