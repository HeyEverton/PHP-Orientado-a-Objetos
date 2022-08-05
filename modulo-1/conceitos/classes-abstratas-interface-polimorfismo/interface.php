<?php

interface Animal {
    public function sound();
    public function run();
    

}

class Dog implements Animal {
    public function sound()
    {
        return 'au au au';
    }
    public function run()
    {
        return "Dog is running...";
    }
}



$dog = new Dog;
print $dog->run();
print "\n";
print $dog->sound();
   