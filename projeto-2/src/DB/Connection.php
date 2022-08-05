<?php
namespace Code\DB;

class Connection 
{
    private static $instance = null;


    private function __construct()
    {
        
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new \PDO(dsn: 'mysql:dbname=formacao_php;host=127.0.0.1', username: 'root', password: '');
        }

        return self::$instance;
    }


}