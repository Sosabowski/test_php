<?php

namespace Storage;

use PDO;

class MySQLStorage extends DBStorage
{
    public function __construct()
    {
        $dsn = "mysql:host=127.0.0.1;port=3306;dbname=test";
        $username = "test";
        $password = "test123";
        $this->pdo = new PDO($dsn, $username, $password);
        parent::__construct();
    }
}
