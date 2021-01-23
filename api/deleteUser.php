<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//Appel des classes
require "../config/Database.php";
require "../class/Users.php";

//connexion a caonfig -> database class
$database = new Database();
//Recup methode PDO
$db = $database->getPDO();

//Instance users class et ses methodes crud
//Necessite une connexion imposée par le constructeur
$users = new Users($db);

$data = json_decode($users->id);
//Si id existe ok sinon die
$users->id = $data['id'];

if($users->deleteUser()){
    echo json_encode("Utilisateur supprimer");
}else{
    echo json_encode("Erreur lors de la suppression de l'utilisateur");
}
