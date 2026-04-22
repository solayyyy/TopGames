<?php

require("tbs_class.php");
require("connect.inc.php");

$tbs = new clsTinyButStrong;

// On initialise les variables pour éviter les erreurs
$db = null;
$etatConnexion = "";

try {
    // 1. On crée la connexion et on l'assigne à $db
    $db = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
    
    // Configurer PDO pour afficher les erreurs SQL
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $etatConnexion = "Connexion Réussie";
} catch (PDOException $erreur) {
    // Si la connexion échoue, on affiche l'erreur
    $etatConnexion = "Erreur de connexion : " . $erreur->getMessage();
    die($etatConnexion); 
}

// 2. On utilise $db (et non plus getConnexion())
$requete = $db->query("SELECT * FROM Jeux");
$mesJeux = $requete->fetchAll(PDO::FETCH_ASSOC);

// 3. Affichage avec TinyButStrong
$tbs->LoadTemplate("review.html");
$tbs->MergeBlock('bloc_jeux', $mesJeux); 

$tbs->Show();

?>


