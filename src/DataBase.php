<?php

namespace App;

class DataBase
{
    /** @var \PDO $pdo */
    private $pdo;

    public function __construct($host, $dataBase, $login, $password)
    {
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

        $this->pdo = new \PDO("mysql:dbname={$dataBase};host={$host}", $login, $password, $opt);
    }

    /**
     * @return \PDO
     */
    public function getDb()
    {
        return $this->pdo;
    }

    public function select($sql, $values = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);

        return $stmt->fetchAll();
    }

    public function insert($sql, $values = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
    }
}
