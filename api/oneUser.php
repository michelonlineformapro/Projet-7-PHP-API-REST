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
//Si id existe ok sinon die
$users->id = isset($_GET['id']) ? $_GET['id'] : die();


//Appel de la methode de la classe User
$users->getOneUser();

//Condition
if($users->email != null){
    //On creer un tableau
    $empty_array = array(
        "id" => $users->id,
        "email" => $users->email,
        "password" => $users->password
    );
    http_response_code(200);
    echo json_encode($empty_array);
}else{
    http_response_code(404);
    echo json_encode("Aucun id trouvé");
}

