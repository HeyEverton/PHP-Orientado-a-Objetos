<?php
namespace Code;

use Code\Excpetions\MyCustomException;

class Sum 
{
    public function doSum($num1, $num2)
    {
        if ($num2 > 10) {
           // throw new \Exception("Parâmetro 2 deve ser menor que 10");

           throw new MyCustomException("Testando...");
        }
    
        return $num1 + $num2;
    }
}