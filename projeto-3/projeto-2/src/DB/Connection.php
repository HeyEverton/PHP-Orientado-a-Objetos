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
            self::$instance = new \PDO(dsn: 'mysql:dbname=my_expenses;host=127.0.0.1', username: 'root', password: 'ruaViruri175');
        }

        return self::$instance;
    }


}