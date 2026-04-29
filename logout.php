<?php
session_start(); // On ouvre la session pour pouvoir la fermer
session_unset(); // On vide toutes les variables de session (on vide le casier)
session_destroy(); // On détruit la session (on rend les clés du casier)

// On redirige vers l'accueil du contrôleur
header("Location: gamecontroller.php?p=home");
exit();
?>