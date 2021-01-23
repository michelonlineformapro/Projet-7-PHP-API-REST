<?php
//Header api rest (get post put-patch delete)
//Autorise cors
header("Access-Control-Allow-Origin: *");
//Le type de fichier encoder est json + utf8
header("Content-Type: application/json; charset=UTF-8");

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
//Appel de la methode tous les employé
$stmt = $users->getAllUsers();
//Compter le nombre d'elements
$usersCount = $stmt->rowCount();

//Encodage en json
echo json_encode($usersCount);

//SI la table users est vide
if($usersCount > 0){
    //On creer un tableau vide
    $userArr = array();
    //le tableau est le corp de la page
    $userArr['users'] = array();
    //Nom du compteur
    $userArr["usersCount"] = $usersCount;
    //On decompile le tableau (...element en js)
    //Boucle de lecture
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        //tous les elements
        $userDATAS = array(
            "id" => $id,
            "email" => $email,
            "password" => $password
        );
        //Après avoir decompile on compile
        //On ajoute les element au tableau
        array_push($userArr['users'], $userDATAS);
    }
    //Affiche les elements
    echo json_encode($userArr);
}else{
    http_response_code(400);
    echo json_encode(array("message" => "Aucun membres trouvé" ));
}
