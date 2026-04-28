<?php
require("tbs_class.php");
require("connect.inc.php");

$tbs = new clsTinyButStrong;


try {
    $db = new PDO("mysql:host=$host;dbname=$dbname", $login, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $erreur) {
    die("Erreur de connexion : " . $erreur->getMessage());
}

$page = isset($_GET['p']) ? $_GET['p'] : 'home';


switch ($page) {
    case 'games':
        $requete = $db->query("SELECT * FROM Jeux");
        $mesJeux = $requete->fetchAll(PDO::FETCH_ASSOC);
        
        $tbs->LoadTemplate("review.html"); 
        $tbs->MergeBlock('bloc_jeux', $mesJeux);
        break;

    case 'blog':
        
        $tbs->LoadTemplate("categories.html"); 
        // $tbs->MergeBlock('bloc_blog', $mesArticles);
        break;

    case 'home':
    default:
        $tbs->LoadTemplate("index.html"); 
        break;
}

// 4. Affichage final
$tbs->Show();
?>

