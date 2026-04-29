<?php
session_start();
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
      
        $limite = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $prochaineLimite = $limite + 10;

        
        $u_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

    
        $requete = $db->prepare("
            SELECT Jeux.*, 
            (SELECT COUNT(*) FROM favoris WHERE id_jeu = Jeux.id AND id_user = :uid) as est_fav
            FROM Jeux 
            LIMIT :limite
        ");
        
        $requete->bindValue(':limite', $limite, PDO::PARAM_INT);
        $requete->bindValue(':uid', $u_id, PDO::PARAM_INT);
        $requete->execute();
        
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

    case 'profile':
        
        if (!isset($_SESSION['user'])) {
            header("Location: login.php");
            exit();
        }

        $stmt = $db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$_SESSION['user']]);
        $infosUser = $stmt->fetch(PDO::FETCH_ASSOC);

        $stmtFav = $db->prepare("
        SELECT Jeux.* FROM Jeux 
        INNER JOIN favoris ON Jeux.id = favoris.id_jeu 
        WHERE favoris.id_user = ?
        ");
        $stmtFav->execute([$_SESSION['user_id']]);
        $mesFavoris = $stmtFav->fetchAll(PDO::FETCH_ASSOC);

        $tbs->LoadTemplate("profile.html");
        $tbs->MergeField('user', $infosUser);
        $tbs->MergeBlock('fav', $mesFavoris);
        break;
    
    case 'add_fav':
        
        if (!isset($_SESSION['user_id'])) { 
            header("Location: login.php?error=Connectez-vous pour ajouter des favoris");
            exit();
        }

        $id_jeu = intval($_GET['id_jeu']);
        $id_user = $_SESSION['user_id'];

        
        $stmt = $db->prepare("INSERT IGNORE INTO favoris (id_user, id_jeu) VALUES (?, ?)");
        $stmt->execute([$id_user, $id_jeu]);

        
        header("Location: gamecontroller.php?p=games");
        exit();
        break;
    }

// Test temporaire à supprimer après
// --- Dans gamecontroller.php, juste avant $tbs->Show() ---

if (isset($_SESSION['user']) && !empty($_SESSION['user'])) {
    $statut = 'connecte';
} else {
    $statut = 'visiteur';
}

// On peut aussi passer le pseudo pour être sûr
$pseudo_tbs = isset($_SESSION['user']) ? $_SESSION['user'] : "";

// On ne change rien au reste du fichier
// 4. Affichage final
$tbs->Show();
?>

