<?php

namespace Storage;

use Config\Directory;
use PDO;

class SQLiteStorage extends DBStorage
{
    public function __construct()
    {
        $dsn = "sqlite:" . Directory::storage() . "db.sqlite";
        $this->pdo = new PDO($dsn);
        parent::__construct();
    }
}
