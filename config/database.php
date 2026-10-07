<?php

class database {
    private string $host = "localhost";

    private string $port = "3306";

    private string $db = "thuvien_db";

    private string $username = "root";

    private string $pass = "";
    
    public PDO $pdo;

    public function __construct()
    {
        $dsn = "mysql:host=$this->host;port=$this->port;
        dbname=$this->db;charset=utf8mb4";
        try{
            $this->pdo = new PDO($dsn, $this->username, $this->pass);
            // echo "Ket noi db thanh cong";
        }catch(PDOException $e){
            echo "Loi ket noi ".$e->getMessage();
        }
    }
}

?>