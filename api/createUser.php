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


//decode les données et sort un flux =  Décode une chaîne JSON
//Cette fonction ne fonctionne qu'avec des chaînes encodées en UTF-8.
$data = json_decode($users->email, $users->password);

//on assigne les valeurs de la classe user au tableau decodé
$users->email = $data['email'];
$users->password = $data['password'];
//Appel de la methode d'insertion de la classe users
$addUser = $users->createUser();
//Si ca marche on retourne un message ok c bon sinon ce dead
if($addUser){
    http_response_code(200);
    echo json_encode("Utilisateur ajouté avec succès !");
}else{
    http_response_code(404);
    echo json_encode("Erreur d'ajout du membres !");
}






