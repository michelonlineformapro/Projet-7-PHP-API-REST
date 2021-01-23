<?php


class Users
{
    private $isConnect;
    private $table_name = "users";

    //DATAS
    public $id;
    public $email;
    public $password;

    //Connexion
    public function __construct($db)
    {
        $this->isConnect = $db;
    }

    //ALL USERS

    public function getAllUsers(){
        $sql = "SELECT * FROM users";
        $req = $this->isConnect->query($sql);
        $req->execute();
        return $req;
    }

    //CREER USERS

    public function createUser(){
        $sql = "INSERT INTO ". $this->table_name ." SET email = :email, password = :password";
        $req = $this->isConnect->prepare($sql);
        //Anti faille XSS
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        //Bind des paramètres
        $req->bindParam(":email", $this->email);
        $req->bindParam(":password", $this->password);

        if($req->execute()){
            return true;
        }else{
            return false;
        }
    }
    //Un user
    public function getOneUser(){
        $sql = "SELECT id, email, password FROM ". $this->table_name ." WHERE id = ?";
        $req = $this->isConnect->prepare($sql);
        $req->bindParam(1, $this->id);
        $req->execute(array($this->id));

        //Stock du tabealud'une valeur
        $dataRow = $req->fetch(PDO::FETCH_ASSOC);
        $this->email = $dataRow['email'];
        $this->password = $dataRow['password'];
        $this->id = $dataRow['id'];
        return $req;
    }

    //Mise à jour User
    public function updateUser(){
        $sql = "UPDATE ".$this->table_name." SET email = :email, password = :password WHERE id = :id";
        $req = $this->isConnect->prepare($sql);
        //Anti faille XSS
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $req->bindParam(":email", $this->email);
        $req->bindParam(":password", $this->password);
        $req->bindParam(":id", $this->id);

        if($req->execute()){
            return true;
        }else{
            return false;
        }
    }

    //SUPPRIMER USER
    function deleteUser(){
        $sql = "DELETE FROM ".$this->table_name." WHERE id = ?";
        $req = $this->isConnect->prepare($sql);

        $this->id = htmlspecialchars(strip_tags($this->id));
        $req->bindParam(1, $this->id);

        if($req->execute()){
            return true;
        }else{
            return false;
        }
    }



}