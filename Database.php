<?php

class Database
{

    public $connection;


    public function __construct()
    {
        
        $ini = parse_ini_file(__DIR__ . '/dbconfig.ini');

        
        $dsn = "mysql:host=" . $ini['servername'] .
            ";port=" . $ini['port'] .
            ";dbname=" . $ini['dbname'];

        
        $this->connection = new PDO($dsn, $ini['username'], $ini['password'], [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);

       
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    }

    
    public function query($sql, $params = [])
    {
        
        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);

        return $stmt;
    }
}
