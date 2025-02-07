<?php

class Database
{
    private $dbConnect = null;

    public function __construct($host, $username, $password, $database)
    {
        try {
            $connect_database = new \PDO("mysql:dbname=" . $database . ";host=" . $host . ";", $username, $password);
            $connect_database->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $connect_database->exec("SET CHARACTER SET utf8");
            $this->dbConnect = $connect_database;
        } catch (\PDOException $e) {
            exit("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, array $array = array())
    {
        if ($this->dbConnect == "") {
            return;
        }
        $q = $this->dbConnect->prepare($sql);
        error_log($sql);
        $q->execute($array);
        return $q;
    }
}

$hostname = "localhost";
$database = "u299560388_651118";
$username = "u299560388_651118";
$password = "CU1186Vk";

$mysql = new Database($hostname, $username, $password, $database);