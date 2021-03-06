<?php
class Conn{
    public $dbhost;
    public $dbport;
    public $dbuser;
    public $dbpwd;
    public $dbname;
    public $dsn;
    public $conn;

    public function __construct(){}
    protected function connect(){
        $this->dbhost = getenv('LAMPIHOST');
        $this->dbport = getenv('LAMPIPORT');
        $this->dbuser = getenv('LAMPIUSER');
        $this->dbpwd = getenv('LAMPIPWD');
        $this->dbname = getenv('LAMPIDB');
        $this->dsn = "pgsql:host=".$this->dbhost." user=".$this->dbuser." port=".$this->dbport." password=".$this->dbpwd." dbname=".$this->dbname;
        $this->conn = new PDO($this->dsn);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    public function pdo(){ if (!$this->conn){ $this->connect();} return $this->conn; }
    public function __destruct(){ if ($this->conn){ $this->conn = null; } }
}

?>
