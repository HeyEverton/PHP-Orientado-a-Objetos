<?php
namespace Code\Excpetions;

use Throwable;

class MyCustomException
 {
    public function __construct($message = "My Custom Message", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
 }