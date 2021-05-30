<?php

namespace Mind\Pdo\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createConnection() : PDO
    {
        $dsn = 'mysql:dbname=mind;host=127.0.0.1';
        $user = 'root';
        $password = 'root';

        return new PDO($dsn, $user, $password);
    }
}
