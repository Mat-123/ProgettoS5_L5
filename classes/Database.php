<?php
class Database
{
    private $host = 'localhost';
    private $user = 'root';
    private $password = 'root';
    private $dbname = 'progettoS5L5';
    private $conn;

    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new PDO($dsn, $this->user, $this->password, $options);
        } catch (PDOException $e) {
            echo "Errore di connessione: " . $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}
