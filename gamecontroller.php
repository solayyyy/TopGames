<?php

require ("tbs_class.php");
require("connect.inc.php");

$tbs = new clsTinyButStrong;
$pdo = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$etatConnexion= "";

try {
    $etatConnexion = "Connexion Réussi";
} catch (PDOException $erreur) {
    $etatConnexion = $erreur->getMessage() ;
}

$db = getConnexion();


$requete = $db->query("SELECT * FROM Jeux");
$mesJeux = $requete->fetchAll(PDO::FETCH_ASSOC);


$tbs->LoadTemplate("index.html");
$tbs->MergeBlock('bloc_jeux', $mesJeux); 

$tbs->Show();
?>




