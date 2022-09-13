<?php

require_once '../config.php';

class MySQLConnection
{
    private PDO $pdo;

    private String $host;
    private String $db;
    private String $user;
    private String$pass;
    private int $port;
    private String $charset;

    public function __construct()
    {
        $this->host = HOST;
        $this->port = PORT;
        $this->db = DB;
        $this->user = USER;
        $this->pass = PASS;
        $this->charset = CHARSET;
    }

    public function connect(): void
    {
        $options = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset;port=$this->port";
        try {
            $this->pdo = new \PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getAllFields(String $table, array $where): array|false
    {
        $sql = "SELECT * FROM $table WHERE ";

        $cntr = 0;
        foreach ($where as $field => $value) {
            if($cntr > 0) {
                $sql .= " AND ";
            }
            $sql .= "'$field'='$value";
            $cntr++;
        }
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}