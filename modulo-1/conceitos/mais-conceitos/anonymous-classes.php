<?php

use BankAccount as GlobalBankAccount;

$classAnonymous = new Class {
    public function log($message)
    {
        return $message;
    }
};

class BankAccount 
{
    public function withdraw($value, $classAnonymous)
    {
       return $classAnonymous->log('Logging withdraw...');
    }
}

$bkAccount = new GlobalBankAccount();
print $bkAccount->withdraw(19, $classAnonymous);