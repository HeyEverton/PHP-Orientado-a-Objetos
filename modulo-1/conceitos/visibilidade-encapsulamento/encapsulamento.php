<?php

class BankAccount
{
    public $balance = 0;

    public function __construct()
    {
        $this->balance = 30;
    }


    public function deposit($money)
    {
        $this->balance += $money;
    }
    
    public function withDraw($money)
    {
        if ($money > $this->balance) {
            return false;
        } else {
            $this->balance += $money;
        }
    }
}

$bankAccount = new BankAccount();
$bankAccount->deposit(10);
$bankAccount->deposit(20);
print $bankAccount->balance;