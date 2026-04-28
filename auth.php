<?php
session_start();
require("connect.inc.php");

$pdo = new PDO("mysql:host=$host;port=3307;dbname=$dbname;charset=utf8", $login, $password);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$action = $_POST['action'] ?? '';

if ($action === 'login') {
    $username = trim($_POST['username'] ?? '');
    $mdp      = $_POST['password'] ?? '';

    if ($username === '' || $mdp === '') {
        header('Location: login.php?error=Champs+manquants');
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($mdp, $user['password'])) {
        $_SESSION['user_id']  = $user['id'];
        $_SESSION['username'] = $user['username'];
        header('Location: index.html');
        exit;
    } else {
        header('Location: login.php?error=Identifiants+incorrects');
        exit;
    }

} elseif ($action === 'register') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $mdp      = $_POST['password'] ?? '';
    $mdp2     = $_POST['password_confirm'] ?? '';

    if ($username === '' || $email === '' || $mdp === '') {
        header('Location: login.php?mode=register&error=Champs+manquants');
        exit;
    }

    if ($mdp !== $mdp2) {
        header('Location: login.php?mode=register&error=Les+mots+de+passe+ne+correspondent+pas');
        exit;
    }

    // Vérifier si username ou email déjà pris
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    if ($stmt->fetch()) {
        header('Location: login.php?mode=register&error=Nom+d\'utilisateur+ou+email+déjà+utilisé');
        exit;
    }

    $hash = password_hash($mdp, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hash]);

    header('Location: login.php?success=Compte+créé,+vous+pouvez+vous+connecter');
    exit;

} else {
    header('Location: login.php');
    exit;
}
?>
