<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, PATCH");
//Le type de fichier encoder est json + utf8
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Access-Control-Allow-Headers, Authorization");

//Appel des classes
require "../config/Database.php";
require "../class/Users.php";

//connexion a caonfig -> database class
$database = new Database();
//Recup methode PDO
$db = $database->getPDO();
//Recup flux php recup des valeurs du json et decode
$postData = json_decode(file_get_contents("php://input"));

if(isset($postData) && !empty($postData)) {
    //Association des valeur au input angular
    $id = $postData->id;
    $email = $postData->email;
    $password = $postData->password;

    $sql = "UPDATE users SET `email` = '{$email}', `password` = '{$password}' WHERE `id` = '{$id}'";
    $update = $db->prepare($sql);

    if($update){
        $users = [
            "email" => $email,
            "password" => $password,
            "id" => $db->lastInsertId()
        ];
        //Bind des params
        $update->bindParam(1, $id);
        $update->bindParam(2, $email);
        $update->bindParam(3, $password);

        $update->execute(array($id, $email, $password));
        //Reponse serveur
        http_response_code(200);
        //encodage du tableau
        echo json_encode($users);
    }else{
        http_response_code(404);
    }

}
