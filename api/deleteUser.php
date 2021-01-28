<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE");
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

$id = $_GET['id'];
if(!$id){
    return http_response_code(400);
}

//SUPPRIMER

$sql = "DELETE FROM `users`  WHERE `id` = '{$id}' LIMIT 1";
$delete = $db->prepare($sql);

$delete->bindParam(1, $id);
$ok = $delete->execute();

if($ok){
    http_response_code(204);
}else{
    http_response_code(422);
}