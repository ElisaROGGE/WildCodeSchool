<?php
// Connexion à la base de données
$db = new PDO('mysql:host=localhost;dbname=wildcodeschool;charset=utf8', 'root', '', [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, 
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
]);

$task = "list";
if(array_key_exists("task", $_GET)){
    $task = $_GET['task'];
}

if($task == "write"){
    postMessage();
}else{
    getMessages();
}

function getMessages(){
    global $db;
    // Je fais une requête SQL pour récupérer les noms en base de données et je limite à 10 sur la page
    $resultat = $db->query("SELECT * FROM argonaute ORDER BY date DESC LIMIT 10");
    // Je traite les résultats
    $messages = $resultat->fetchAll();
    // J'affiche les données sous forme de JSON
    echo json_encode($messages);
}

function postMessage(){
    global $db;
    // J'analyse les paramètres passés en POST
    if(!array_key_exists('nom', $_POST)){
        echo json_encode(["status" => "error", "message" => "Erreur"]);
        return;
    }
    $nom = $_POST['nom'];
    // Je vérifie si le nom est vide
    if($nom !== ''){
        // Je créé une requête pour insérer les données
        $query = $db->prepare('INSERT INTO argonaute SET nom = :nom, date = NOW()');
        $query->execute([
            "nom" => $nom
        ]);

        echo json_encode(["status" => "success"]);
    }else{
        echo json_encode(['status' => "error"]);
    }
    
}