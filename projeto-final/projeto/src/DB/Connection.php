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
            self::$instance = new \PDO(dsn: 'mysql:dbname=' . DB_NAME . ';host=' . DB_HOST, username: DB_USER, password: DB_PASSWORD);
        }

        return self::$instance;
    }
}
