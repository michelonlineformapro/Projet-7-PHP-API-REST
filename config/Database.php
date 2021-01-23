<?php


class Database
{
    private $host = "localhost";
    private $dbname = "fullstack";
    private $user = "root";
    private $pass = "";
    public $isConnect;

    public function getPDO(){
        $this->isConnect = null;
        try {
            $this->isConnect = new PDO("mysql:host=" .$this->host.";dbname=".$this->dbname."",$this->user, $this->pass);
            $this->isConnect->exec("set names utf8");
        }catch (PDOException $e){
            die("Erreur de connexion " .$e->getMessage());
        }
        return $this->isConnect;
    }

}